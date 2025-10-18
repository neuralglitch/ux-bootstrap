# Alert Stack Component

## Overview

The `bs:alert-stack` component provides a powerful and flexible solution for displaying multiple alerts in a stack format. It's perfect for:

- **Flash Messages**: Display one-time notifications after form submissions or actions
- **Bulk Notifications**: Show multiple alerts at once
- **Toast Management**: Auto-hiding notifications with positioning control

The component handles alert positioning, auto-hiding, dismissal, and enforces maximum alert limits.

## Basic Usage

### Simple String Alerts

```twig
<twig:bs:alert-stack :alerts="[
    'Your changes have been saved!',
    'Email verification sent.',
    'Profile updated successfully.'
]" />
```

### Structured Alert Data

```twig
{% set alerts = [
    {message: 'Success! Your changes have been saved.', variant: 'success'},
    {message: 'Warning: Your session will expire soon.', variant: 'warning'},
    {message: 'Error: Unable to connect to server.', variant: 'danger'}
] %}

<twig:bs:alert-stack :alerts="alerts" />
```

### With Positioning

```twig
{# Top-right corner (default) #}
<twig:bs:alert-stack 
    position="top-end"
    :alerts="alerts" />

{# Bottom-left corner #}
<twig:bs:alert-stack 
    position="bottom-start"
    :alerts="alerts" />

{# Top-center #}
<twig:bs:alert-stack 
    position="top-center"
    :alerts="alerts" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `alerts` | `array` | `[]` | Array of alerts (strings or arrays with message/variant/etc) |
| `position` | `string` | `'top-end'` | Stack position: `'top-end'`, `'top-start'`, `'top-center'`, `'bottom-end'`, `'bottom-start'`, `'bottom-center'` |
| `maxAlerts` | `int` | `0` | Maximum alerts to show (0 = unlimited) |
| `defaultVariant` | `string` | `'info'` | Default Bootstrap variant if not specified per alert |
| `autoHide` | `bool` | `false` | Whether alerts should auto-hide |
| `autoHideDelay` | `int` | `5000` | Auto-hide delay in milliseconds |
| `fade` | `bool` | `true` | Enable fade animation |
| `dismissible` | `bool` | `true` | Alerts dismissible by default |
| `zIndex` | `int` | `1080` | CSS z-index for the stack |
| `gap` | `float` | `0.75` | Gap between alerts (in rem) |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Alert Object Structure

Each alert in the `alerts` array can be:

### Simple String

```twig
'Your message here'
```

### Full Object

```twig
{
    message: 'Alert message (HTML supported)',
    variant: 'success',              // 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark'
    dismissible: true,               // Override default dismissible setting
    autoHide: true,                  // Override default auto-hide setting
    autoHideDelay: 3000,             // Override default auto-hide delay
    id: 'my-custom-alert-id'         // Optional custom ID
}
```

## Examples

### Flash Messages Integration

```php
// In your Symfony controller
$this->addFlash('success', 'Your profile has been updated!');
$this->addFlash('warning', 'Some fields need attention.');
$this->addFlash('info', 'Don\'t forget to verify your email.');

return $this->redirectToRoute('profile');
```

```twig
{# In your template #}
{% set flashAlerts = [] %}
{% for label, messages in app.flashes %}
    {% for message in messages %}
        {% set flashAlerts = flashAlerts|merge([{
            message: message,
            variant: label,
            dismissible: true
        }]) %}
    {% endfor %}
{% endfor %}

{% if flashAlerts|length > 0 %}
    <twig:bs:alert-stack 
        :alerts="flashAlerts"
        position="top-end"
        :autoHide="true"
        :autoHideDelay="5000" />
{% endif %}
```

### Auto-hiding Notifications

```twig
<twig:bs:alert-stack 
    :alerts="notifications"
    position="top-end"
    :autoHide="true"
    :autoHideDelay="3000"
    :maxAlerts="5" />
```

### Bottom Toast-style Stack

```twig
<twig:bs:alert-stack 
    position="bottom-end"
    :alerts="[
        {message: 'Message sent!', variant: 'success', autoHide: true, autoHideDelay: 2000},
        {message: 'File uploaded.', variant: 'info', autoHide: true, autoHideDelay: 2000}
    ]" />
```

### Mixed Auto-hide Behavior

```twig
{% set alerts = [
    {message: 'This will stay until dismissed', variant: 'danger', autoHide: false},
    {message: 'This will auto-hide in 3 seconds', variant: 'success', autoHide: true, autoHideDelay: 3000},
    {message: 'This will auto-hide in 5 seconds', variant: 'info', autoHide: true, autoHideDelay: 5000}
] %}

<twig:bs:alert-stack :alerts="alerts" />
```

### Maximum Alerts Limit

```twig
{# Only show the first 3 alerts #}
<twig:bs:alert-stack 
    :alerts="manyAlerts"
    :maxAlerts="3" />
```

### Custom Styling

```twig
<twig:bs:alert-stack 
    :alerts="alerts"
    :zIndex="2000"
    :gap="1.0"
    class="custom-stack shadow-lg" />
```

### All Position Options

```twig
{# Top positions #}
<twig:bs:alert-stack position="top-start" :alerts="alerts" />    {# Top-left #}
<twig:bs:alert-stack position="top-center" :alerts="alerts" />   {# Top-center #}
<twig:bs:alert-stack position="top-end" :alerts="alerts" />      {# Top-right (default) #}

{# Bottom positions #}
<twig:bs:alert-stack position="bottom-start" :alerts="alerts" /> {# Bottom-left #}
<twig:bs:alert-stack position="bottom-center" :alerts="alerts" />{# Bottom-center #}
<twig:bs:alert-stack position="bottom-end" :alerts="alerts" />   {# Bottom-right #}
```

### HTML Content in Alerts

```twig
{% set alerts = [
    {
        message: '<strong>Success!</strong> Your profile has been <a href="/profile" class="alert-link">updated</a>.',
        variant: 'success'
    }
] %}

<twig:bs:alert-stack :alerts="alerts" />
```

## JavaScript API

The component uses a Stimulus controller (`bs-alert-stack`) that provides a JavaScript API for dynamic alert management:

### Add Alert Dynamically

```javascript
// Get the controller instance
const stackElement = document.querySelector('[data-controller="bs-alert-stack"]');
const stack = this.application.getControllerForElementAndIdentifier(stackElement, 'bs-alert-stack');

// Add a new alert
stack.addAlert({
    message: 'New notification!',
    variant: 'info',
    dismissible: true,
    autoHide: true,
    autoHideDelay: 3000
});
```

### Remove Specific Alert

```javascript
// Remove alert by ID
stack.removeAlert('alert-id-123');
```

### Clear All Alerts

```javascript
// Clear all alerts from the stack
stack.clearAll();
```

### Using with Turbo/Stimulus

```javascript
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    showNotification(event) {
        const message = event.detail.message;
        const variant = event.detail.variant || 'info';
        
        // Find the alert stack
        const stackElement = document.querySelector('[data-controller="bs-alert-stack"]');
        if (stackElement) {
            const stack = this.application.getControllerForElementAndIdentifier(
                stackElement, 
                'bs-alert-stack'
            );
            
            stack.addAlert({
                message: message,
                variant: variant,
                autoHide: true,
                autoHideDelay: 3000
            });
        }
    }
}
```

## Accessibility

The Alert Stack component follows Bootstrap's alert accessibility patterns:

- Each alert has `role="alert"` for screen readers
- Dismissible alerts have proper `aria-label` on close buttons
- Alerts are keyboard accessible (close with Tab + Enter/Space)
- Auto-hiding alerts don't interfere with screen reader announcements

### Screen Reader Considerations

```twig
{# For critical errors, consider not auto-hiding #}
{% set criticalAlert = {
    message: 'Critical: Your session has expired. Please log in again.',
    variant: 'danger',
    dismissible: true,
    autoHide: false  {# Don't auto-hide critical alerts #}
} %}

<twig:bs:alert-stack :alerts="[criticalAlert]" />
```

## Configuration

You can configure default values in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  alert_stack:
    # Positioning
    position: 'top-end'
    
    # Limits
    max_alerts: 5
    
    # Defaults
    default_variant: 'info'
    dismissible: true
    
    # Auto-hide behavior
    auto_hide: true
    auto_hide_delay: 4000
    fade: true
    
    # Styling
    z_index: 1080
    gap: 0.75
    
    # Custom classes/attributes
    class: 'my-alert-stack'
    attr: {}
```

## Use Cases

### 1. Form Validation Errors

```php
// Controller
foreach ($form->getErrors(true) as $error) {
    $this->addFlash('danger', $error->getMessage());
}
```

```twig
{# Template #}
<twig:bs:alert-stack 
    :alerts="app.flashes('danger')|map(msg => {message: msg, variant: 'danger'})"
    position="top-center"
    :dismissible="true" />
```

### 2. Multi-step Process Updates

```twig
{% set processAlerts = [
    {message: '✓ Step 1: Profile information saved', variant: 'success'},
    {message: '✓ Step 2: Payment processed', variant: 'success'},
    {message: '⏳ Step 3: Email confirmation pending...', variant: 'warning'}
] %}

<twig:bs:alert-stack 
    :alerts="processAlerts"
    position="top-center"
    :maxAlerts="3" />
```

### 3. Real-time Notifications

```javascript
// WebSocket or SSE integration
socket.on('notification', (data) => {
    const stack = getAlertStackController();
    stack.addAlert({
        message: data.message,
        variant: data.type,
        autoHide: true,
        autoHideDelay: 5000
    });
});
```

### 4. Bulk Operations Feedback

```twig
{% set bulkResults = [
    {message: 'Successfully processed 45 items', variant: 'success'},
    {message: 'Skipped 3 items (already processed)', variant: 'info'},
    {message: 'Failed to process 2 items', variant: 'danger'}
] %}

<twig:bs:alert-stack 
    :alerts="bulkResults"
    position="top-end"
    :dismissible="true" />
```

## Testing

```php
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\AlertStack;

public function testAlertStack(): void
{
    $component = new AlertStack($this->config);
    $component->alerts = [
        ['message' => 'Test', 'variant' => 'success']
    ];
    $component->mount();
    $options = $component->options();
    
    $this->assertCount(1, $options['alerts']);
    $this->assertSame('success', $options['alerts'][0]['variant']);
}
```

## Advanced Examples

### Conditional Rendering Based on Count

```twig
{% if flashMessages|length > 0 %}
    <twig:bs:alert-stack 
        :alerts="flashMessages"
        :maxAlerts="5"
        :autoHide="flashMessages|length < 3" />  {# Only auto-hide if 2 or fewer #}
{% endif %}
```

### Per-variant Styling with Custom Classes

```twig
{% set alerts = notifications|map(n => {
    message: n.text,
    variant: n.level,
    class: n.level == 'danger' ? 'border-danger border-2' : null
}) %}

<twig:bs:alert-stack :alerts="alerts" />
```

### Integration with Symfony Mailer Events

```php
// Event Subscriber
public function onEmailSent(MessageEvent $event): void
{
    $this->session->getFlashBag()->add('success', 
        'Email sent to ' . $event->getMessage()->getTo()[0]->getAddress()
    );
}
```

```twig
<twig:bs:alert-stack 
    :alerts="app.flashes('success')|map(m => {message: m, variant: 'success', autoHide: true})"
    position="bottom-end" />
```

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Requires Bootstrap 5.3+
- Requires Stimulus 3.0+

## Related Components

- **Alert** (`bs:alert`): Single alert component
- **Toast** (`bs:toast`): Toast notifications
- **Modal** (`bs:modal`): Modal dialogs for important messages

## References

- [Bootstrap Alerts Documentation](https://getbootstrap.com/docs/5.3/components/alerts/)
- [Symfony Flash Messages](https://symfony.com/doc/current/controller.html#flash-messages)
- [Stimulus Controller API](https://stimulus.hotwired.dev/)

