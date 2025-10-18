# Toast Component

The `bs:toast` component provides lightweight notifications with auto-hide and positioning based on Bootstrap 5.3.

## Basic Usage

```twig
{# Simple toast #}
<twig:bs:toast 
  title="Notification" 
  message="Your changes have been saved." />

{# Toast with content #}
<twig:bs:toast variant="success">
  <strong>Success!</strong> Operation completed.
</twig:bs:toast>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `message` | `?string` | `null` | Toast message text |
| `title` | `?string` | `null` | Toast header title |
| `header` | `bool` | `true` | Show toast header |
| `body` | `bool` | `true` | Show toast body |
| `autohide` | `bool` | `true` | Auto-hide after delay |
| `delay` | `int` | `5000` | Delay in milliseconds before hiding |
| `animation` | `bool` | `true` | Enable fade animation |
| `position` | `string` | `'top-0 end-0'` | Toast container position classes |
| `stimulusController` | `string` | `'bs-toast'` | Stimulus controller identifier |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Success notification #}
<twig:bs:toast 
  variant="success" 
  title="Success" 
  message="Your profile has been updated." />

{# Warning with custom position #}
<twig:bs:toast 
  variant="warning" 
  title="Warning" 
  message="Your session will expire soon." 
  position="top-0 start-0" />

{# Toast without auto-hide #}
<twig:bs:toast 
  variant="info" 
  :autohide="false"
  message="This toast will stay until manually closed." />

{# Toast with custom delay #}
<twig:bs:toast 
  variant="primary" 
  :delay="3000"
  message="This will disappear in 3 seconds." />
```

## Position Options

Common toast positions:
- `'top-0 start-0'` - Top left
- `'top-0 start-50 translate-middle-x'` - Top center
- `'top-0 end-0'` - Top right (default)
- `'top-50 start-0 translate-middle-y'` - Middle left
- `'top-50 start-50 translate-middle'` - Center
- `'top-50 end-0 translate-middle-y'` - Middle right
- `'bottom-0 start-0'` - Bottom left
- `'bottom-0 start-50 translate-middle-x'` - Bottom center
- `'bottom-0 end-0'` - Bottom right

## Stimulus Controller

The toast component uses the `bs-toast` Stimulus controller.

**Controller:** `assets/controllers/bs_toast_controller.js`

**Data Attributes:**
- `data-controller="bs-toast"` - Activates controller
- `data-bs-autohide` - Bootstrap native autohide
- `data-bs-delay` - Bootstrap native delay

## References

- [Bootstrap 5.3 Toasts Documentation](https://getbootstrap.com/docs/5.3/components/toasts/)
