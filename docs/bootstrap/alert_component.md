# Alert Component

The `bs:alert` component provides contextual feedback messages with automatic dismissal and animation support based on Bootstrap 5.3's alert component.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Props](#component-props)
- [Examples](#examples)
  - [Basic Alert](#basic-alert)
  - [Alert Variants](#alert-variants)
  - [Dismissible Alert](#dismissible-alert)
  - [Auto-Hide Alert](#auto-hide-alert)
  - [Alert with HTML Content](#alert-with-html-content)
  - [Icon Alerts](#icon-alerts)
- [Accessibility](#accessibility)
- [Configuration](#configuration)
- [Stimulus Controller](#stimulus-controller)
- [Testing](#testing)
- [Related Components](#related-components)
- [References](#references)

## Overview

The alert component displays contextual feedback messages with support for:
- 8 color variants (primary, secondary, success, danger, warning, info, light, dark)
- Dismissible alerts with close button
- Auto-hide with configurable delay
- Fade animation
- Custom HTML content
- Accessibility features

## Basic Usage

```twig
{# Simple alert #}
<twig:bs:alert variant="success" message="Operation completed successfully!" />

{# Alert with content block #}
<twig:bs:alert variant="info">
  <strong>Info:</strong> This is an informational message.
</twig:bs:alert>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `message` | `?string` | `null` | Alert text content (alternative to content block) |
| `dismissible` | `bool` | `false` | Show close button to dismiss alert |
| `fade` | `bool` | `true` | Enable fade animation |
| `show` | `bool` | `true` | Show alert immediately (use with `fade`) |
| `autoHide` | `bool` | `false` | Automatically hide alert after delay |
| `autoHideDelay` | `int` | `5000` | Delay in milliseconds before auto-hiding (requires `autoHide: true`) |
| `role` | `string` | `'alert'` | ARIA role attribute |
| `stimulusController` | `string` | `'bs-alert'` | Stimulus controller identifier |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Basic Alert

```twig
<twig:bs:alert variant="primary" message="A simple primary alert" />
<twig:bs:alert variant="secondary" message="A simple secondary alert" />
<twig:bs:alert variant="success" message="A simple success alert" />
<twig:bs:alert variant="danger" message="A simple danger alert" />
```

### Alert Variants

```twig
{# Success alert #}
<twig:bs:alert variant="success">
  <strong>Success!</strong> Your changes have been saved.
</twig:bs:alert>

{# Error alert #}
<twig:bs:alert variant="danger">
  <strong>Error!</strong> Something went wrong. Please try again.
</twig:bs:alert>

{# Warning alert #}
<twig:bs:alert variant="warning">
  <strong>Warning!</strong> Your session will expire in 5 minutes.
</twig:bs:alert>

{# Info alert #}
<twig:bs:alert variant="info">
  <strong>Info:</strong> New features are available!
</twig:bs:alert>
```

### Dismissible Alert

```twig
{# Alert with close button #}
<twig:bs:alert 
  variant="success" 
  :dismissible="true">
  <strong>Success!</strong> You can close this alert by clicking the × button.
</twig:bs:alert>
```

### Auto-Hide Alert

```twig
{# Alert that automatically disappears after 3 seconds #}
<twig:bs:alert 
  variant="info" 
  :autoHide="true" 
  :autoHideDelay="3000"
  message="This alert will disappear in 3 seconds" />

{# Dismissible alert that also auto-hides #}
<twig:bs:alert 
  variant="success" 
  :dismissible="true" 
  :autoHide="true" 
  :autoHideDelay="5000">
  This alert can be closed manually or will auto-hide after 5 seconds.
</twig:bs:alert>
```

### Alert with HTML Content

```twig
<twig:bs:alert variant="warning">
  <h4 class="alert-heading">Well done!</h4>
  <p>You successfully read this important alert message.</p>
  <hr>
  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
</twig:bs:alert>
```

### Icon Alerts

```twig
{# Using UX Icons #}
<twig:bs:alert variant="success">
  <twig:ux:icon name="check-circle" /> Success! Your operation completed.
</twig:bs:alert>

{# Using Bootstrap Icons #}
<twig:bs:alert variant="danger">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  <strong>Error!</strong> Something went wrong.
</twig:bs:alert>
```

## Accessibility

The alert component includes several accessibility features:

- Uses `role="alert"` by default (configurable)
- Dismissible alerts include `aria-label` on close button
- Auto-hide alerts use Stimulus controller for smooth transitions
- Color is not the only means of conveying meaning (text/icons included)

**Best Practices:**
- Always include descriptive text, not just color
- Use `<strong>` or headings for emphasis
- Include icons for better comprehension
- Ensure sufficient color contrast

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  alert:
    variant: null              # No default variant
    dismissible: false         # Not dismissible by default
    fade: true                 # Fade animation enabled
    show: true                 # Show immediately
    auto_hide: false           # Auto-hide disabled
    auto_hide_delay: 5000      # 5 seconds delay
    role: 'alert'              # ARIA role
    stimulus_controller: 'bs-alert'
    class: null
    attr: {}
```

## Stimulus Controller

The alert component uses the `bs-alert` Stimulus controller for auto-hide functionality.

**Controller:** `assets/controllers/bs_alert_controller.js`

**Features:**
- Automatic dismissal after configured delay
- Smooth fade-out animation
- Integrates with Bootstrap's native alert behavior

**Data Attributes:**
- `data-controller="bs-alert"` - Activates controller (auto-added when `autoHide: true`)
- `data-bs-alert-auto-hide-value="true"` - Enables auto-hide
- `data-bs-alert-auto-hide-delay-value="5000"` - Sets delay in milliseconds

## Testing

The alert component includes comprehensive tests in `tests/Twig/Components/Bootstrap/AlertTest.php`.

Run tests:
```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/AlertTest.php
```

## Related Components

- **Toast** - For notification-style messages
- **Badge** - For labeling and counts
- **Card** - For content containers

## References

- [Bootstrap 5.3 Alerts Documentation](https://getbootstrap.com/docs/5.3/components/alerts/)
- [Bootstrap Alert JavaScript API](https://getbootstrap.com/docs/5.3/components/alerts/#methods)
- [Symfony UX TwigComponent](https://symfony.com/bundles/ux-twig-component/current/index.html)

