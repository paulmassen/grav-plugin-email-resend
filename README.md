# Email Resend Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of the plugin.**

The **Email Resend** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). Resend integration for new Email plugin

## Installation

Installing the Email Resend plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](https://learn.getgrav.org/cli-console/grav-cli-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install email-resend

This will install the Email Resend plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/email-resend`.

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/email-resend/email-resend.yaml` to `user/config/plugins/email-resend.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
transport: api
api_key: your_resend_api_key_here
```

Note that if you use the Admin Plugin, a file with your configuration named email-resend.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

Ce plugin permet d'envoyer des emails via l'API Resend. Une fois configuré, vous pouvez utiliser le plugin Email de Grav avec l'engine "Resend".

### Configuration

1. Obtenez votre clé API Resend depuis [resend.com](https://resend.com)
2. Configurez le plugin dans l'administration ou dans le fichier de configuration
3. Sélectionnez "Resend" comme engine dans la configuration du plugin Email

### Fonctionnalités

- ✅ Envoi d'emails via l'API Resend
- ✅ Support des destinataires multiples (to, cc, bcc)
- ✅ Support des pièces jointes
- ✅ Support des en-têtes personnalisés
- ✅ Logging des erreurs et succès
- ✅ Gestion des erreurs robuste

### Exemple de configuration

```yaml
# user/config/plugins/email-resend.yaml
enabled: true
transport: api
api_key: re_xxxxxxxxxxxxx
```

## Credits

**Did you incorporate third-party code? Want to thank somebody?**

## To Do

- [ ] Future plans, if any

