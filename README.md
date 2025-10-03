# Email Resend Plugin

The **Email Resend Plugin** is an extension for [Grav CMS](https://github.com/getgrav/grav) that allows sending emails via the Resend API.

## Installation

### GPM Installation (Recommended)

To install the plugin via the [GPM](https://learn.getgrav.org/cli-console/grav-cli-gpm), navigate to the root of your Grav installation and run:

    bin/gpm install email-resend

### Admin Plugin Installation

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins` menu and clicking the `Add` button.

## Configuration

### 1. Email Resend Plugin Configuration

Copy the `user/plugins/email-resend/email-resend.yaml` file to `user/config/plugins/email-resend.yaml` and only edit that copy.

**Default configuration:**

```yaml
enabled: true
api_key: your_resend_api_key_here
```

### 2. Get Your Resend API Key

1. Create an account on [resend.com](https://resend.com)
2. Go to the "API Keys" section in your dashboard
3. Create a new API key
4. Copy the API key (starts with `re_`)

### 3. Main Email Plugin Configuration

In the `user/config/plugins/email.yaml` file, configure:

```yaml
enabled: true
from: onboarding@resend.dev  # For testing
# from: your-email@your-domain.com  # For production
to: your-email@example.com
mailer:
  engine: resend
```

## Usage

### Testing Email Sending

To test email sending, use the command:

    bin/plugin email test-email -t your-email@example.com

This command will send a test email to the specified address.

### Testing Configuration

To test without verifying your domain, use the address `onboarding@resend.dev` as the "from" address:

```yaml
# user/config/plugins/email.yaml
from: onboarding@resend.dev
```

**Testing limitations:**
- Maximum 100 emails per month
- Only to your own email address
- "From" address limited to `onboarding@resend.dev`

### Production Configuration

To use your own domain in production:

1. Verify your domain in the Resend dashboard
2. Add the required DNS records
3. Change the "from" address to your domain:

```yaml
# user/config/plugins/email.yaml
from: contact@your-domain.com
```

## Features

- ✅ Email sending via Resend API
- ✅ Multiple recipients support (to, cc, bcc)
- ✅ Attachments support
- ✅ Custom headers support
- ✅ Reply-to support
- ✅ Error and success logging
- ✅ Robust error handling

## Troubleshooting

### "Missing 'to' field" Error

This error indicates that the email object is not properly configured. Check:

1. The main Email plugin configuration
2. The "to" address is defined
3. The engine is properly set to "resend"

### "Resend API key is not configured" Error

Verify that your API key is correctly configured in `user/config/plugins/email-resend.yaml`.

### Logs

Plugin logs are available in `logs/grav.log` with the `[EmailResend]` prefix.

## Credits

This plugin uses the [Resend](https://resend.com) API for email sending.

