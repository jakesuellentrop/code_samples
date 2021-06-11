# First Mile Market
## Toast notifications

I wrote a simple system for flashing messages to the session. When a new message is flashed from a controller, the `HandleInertiaRequest.php` middleware shares it to the front end framework. The `AppLayout.vue` component watches the flash messages and uses the message key to display the appropriate style of toast message.
