<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class EmailResendPlugin
 * @package Grav\Plugin
 */
class EmailResendPlugin extends Plugin
{

    public static function getSubscribedEvents(): array
    {
        return [
            'onEmailEngines'       => ['onEmailEngines', 0],
            'onEmailTransportDsn'  => ['onEmailTransportDsn', 0],
            'onEmailMessage'       => ['onEmailMessage', 0],
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }
    
    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            return;
        }
    }
    

    public function onEmailEngines(Event $e)
    {
        $engines = $e['engines'];
        $engines->resend = 'Resend';
        
        // Debug: Logger l'enregistrement de l'engine
        $this->grav['log']->info('[EmailResend] Engine registered: resend');
    }

    public function onEmailTransportDsn(Event $e)
    {
        $engine = $e['engine'];
        if ($engine === 'resend') {
            // Empêcher Symfony Mailer de traiter ce DSN
            $e->stopPropagation();
            $e['dsn'] = 'null://null';
        }
    }
    
    public function onEmailMessage(Event $e)
    {
        $engine = $this->config->get('plugins.email.mailer.engine');
        
        if ($engine === 'resend') {
            $message = $e['message'];
            $params = $e['params'];
            
            // Envoyer l'email avec Resend
            $this->sendWithResend($message, $params);
            
            // Empêcher l'envoi par le système par défaut
            $e->stopPropagation();
        }
    }
    
    private function sendWithResend($message, $params)
    {
        $options = $this->config->get('plugins.email-resend');
        $apiKey = $options['api_key'] ?? '';
        
        if (empty($apiKey)) {
            throw new \RuntimeException('Resend API key is not configured');
        }
        
        // Utiliser l'API Resend directement
        $resend = \Resend::client($apiKey);
        
        // Récupérer l'objet email Symfony depuis le message Grav
        $email = $message->getEmail();
        
        // Convertir les adresses email en chaînes
        $toAddresses = [];
        foreach ($email->getTo() as $addr) {
            $toAddresses[] = $addr->toString();
        }
        
        $resendParams = [
            'from' => $email->getFrom()[0]->toString(),
            'to' => $toAddresses,
            'subject' => $email->getSubject(),
            'html' => $email->getHtmlBody(),
        ];
        
        // Ajouter les destinataires en copie si nécessaire
        if (!empty($email->getCc())) {
            $ccAddresses = [];
            foreach ($email->getCc() as $addr) {
                $ccAddresses[] = $addr->toString();
            }
            $resendParams['cc'] = $ccAddresses;
        }
        
        // Ajouter les destinataires en copie cachée si nécessaire
        if (!empty($email->getBcc())) {
            $bccAddresses = [];
            foreach ($email->getBcc() as $addr) {
                $bccAddresses[] = $addr->toString();
            }
            $resendParams['bcc'] = $bccAddresses;
        }
        
        // Ajouter le reply-to si spécifié
        if (!empty($email->getReplyTo())) {
            $replyToAddresses = [];
            foreach ($email->getReplyTo() as $addr) {
                $replyToAddresses[] = $addr->toString();
            }
            $resendParams['reply_to'] = $replyToAddresses;
        }
        
        $result = $resend->emails->send($resendParams);
        
        return $result;
    }
    
}
