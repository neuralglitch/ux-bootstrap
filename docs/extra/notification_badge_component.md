# NotificationBadge Component

## Overview

The **NotificationBadge** is an Extra component that provides a specialized indicator badge for showing notifications, counts, or status on elements like navigation items, avatars, buttons, and icons. Unlike the regular Badge component, NotificationBadge is designed to be overlaid on other elements as an absolute-positioned indicator.

**Component**: `bs:notification-badge`  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Template**: `templates/components/extra/notification-badge.html.twig`

## Basic Usage

### Simple Notification Count

```twig
<button class="btn btn-primary position-relative">
  Messages
  <twig:bs:notification-badge content="5" />
</button>
```

### Notification Dot (No Content)

```twig
<button class="btn btn-primary position-relative">
  Notifications
  <twig:bs:notification-badge :dot="true" />
</button>
```

### With Pulse Animation

```twig
<button class="btn btn-primary position-relative">
  Inbox
  <twig:bs:notification-badge content="3" :pulse="true" />
</button>
```

### On Avatar

```twig
<div class="position-relative d-inline-block">
  <img src="/avatar.jpg" class="rounded-circle" alt="User" width="40" height="40">
  <twig:bs:notification-badge :dot="true" variant="success" />
</div>
```

### On Nav Item

```twig
<li class="nav-item">
  <a class="nav-link position-relative" href="#">
    Notifications
    <twig:bs:notification-badge content="12" />
  </a>
</li>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `content` | `?string` | `null` | The content to display (number, text, or null for dot) |
| `variant` | `string` | `'danger'` | Bootstrap color variant (primary, secondary, success, danger, warning, info, light, dark) |
| `position` | `string` | `'top-end'` | Position relative to parent: `top-start`, `top-end`, `bottom-start`, `bottom-end` |
| `size` | `string` | `'md'` | Size of the badge: `sm`, `md`, `lg` |
| `dot` | `bool` | `false` | Show as a dot (ignores content) |
| `pulse` | `bool` | `false` | Show pulse animation for new notifications |
| `bordered` | `bool` | `true` | Show white border around badge |
| `pill` | `bool` | `true` | Use pill (rounded) style |
| `max` | `?int` | `null` | Maximum number to display (e.g., 99 shows "99+") |
| `inline` | `bool` | `false` | Show inline instead of positioned (for special cases) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### All Variants

```twig
<div class="d-flex gap-3">
  <button class="btn btn-light position-relative">
    Primary
    <twig:bs:notification-badge variant="primary" content="1" />
  </button>
  
  <button class="btn btn-light position-relative">
    Success
    <twig:bs:notification-badge variant="success" content="2" />
  </button>
  
  <button class="btn btn-light position-relative">
    Danger
    <twig:bs:notification-badge variant="danger" content="3" />
  </button>
  
  <button class="btn btn-light position-relative">
    Warning
    <twig:bs:notification-badge variant="warning" content="4" />
  </button>
</div>
```

### All Positions

```twig
<div class="d-flex gap-3">
  <button class="btn btn-primary position-relative">
    Top Start
    <twig:bs:notification-badge position="top-start" content="1" />
  </button>
  
  <button class="btn btn-primary position-relative">
    Top End
    <twig:bs:notification-badge position="top-end" content="2" />
  </button>
  
  <button class="btn btn-primary position-relative">
    Bottom Start
    <twig:bs:notification-badge position="bottom-start" content="3" />
  </button>
  
  <button class="btn btn-primary position-relative">
    Bottom End
    <twig:bs:notification-badge position="bottom-end" content="4" />
  </button>
</div>
```

### Different Sizes

```twig
<div class="d-flex gap-3 align-items-center">
  <button class="btn btn-primary position-relative">
    Small
    <twig:bs:notification-badge size="sm" content="5" />
  </button>
  
  <button class="btn btn-primary position-relative">
    Medium
    <twig:bs:notification-badge size="md" content="10" />
  </button>
  
  <button class="btn btn-primary position-relative">
    Large
    <twig:bs:notification-badge size="lg" content="99" />
  </button>
</div>
```

### Max Number Display

```twig
{# Shows "99+" when content exceeds max #}
<button class="btn btn-primary position-relative">
  Messages
  <twig:bs:notification-badge content="150" :max="99" />
</button>
```

### Status Indicators on Avatars

```twig
<div class="d-flex gap-3">
  {# Online status #}
  <div class="position-relative d-inline-block">
    <img src="/user1.jpg" class="rounded-circle" width="50" height="50">
    <twig:bs:notification-badge 
      :dot="true" 
      variant="success" 
      position="bottom-end" 
    />
  </div>
  
  {# Away status #}
  <div class="position-relative d-inline-block">
    <img src="/user2.jpg" class="rounded-circle" width="50" height="50">
    <twig:bs:notification-badge 
      :dot="true" 
      variant="warning" 
      position="bottom-end" 
    />
  </div>
  
  {# Busy status #}
  <div class="position-relative d-inline-block">
    <img src="/user3.jpg" class="rounded-circle" width="50" height="50">
    <twig:bs:notification-badge 
      :dot="true" 
      variant="danger" 
      position="bottom-end" 
    />
  </div>
</div>
```

### Notification Menu

```twig
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Brand</a>
    
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link position-relative" href="#notifications">
          <i class="bi bi-bell"></i>
          <twig:bs:notification-badge content="5" :pulse="true" />
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link position-relative" href="#messages">
          <i class="bi bi-envelope"></i>
          <twig:bs:notification-badge content="2" />
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link position-relative" href="#profile">
          <img src="/avatar.jpg" class="rounded-circle" width="30" height="30">
          <twig:bs:notification-badge :dot="true" variant="success" position="bottom-end" />
        </a>
      </li>
    </ul>
  </div>
</nav>
```

### Shopping Cart Badge

```twig
<button class="btn btn-outline-primary position-relative">
  <i class="bi bi-cart"></i>
  Cart
  <twig:bs:notification-badge 
    content="3" 
    variant="primary"
    :bordered="false"
  />
</button>
```

### With Custom Content

```twig
<button class="btn btn-primary position-relative">
  Updates
  <twig:bs:notification-badge>
    {% block content %}New{% endblock %}
  </twig:bs:notification-badge>
</button>
```

### Inline Badge (No Positioning)

```twig
<span>
  Unread 
  <twig:bs:notification-badge 
    content="5" 
    :inline="true"
    size="sm" 
  />
</span>
```

## Styling and CSS

The component relies on Bootstrap utility classes and custom CSS classes:

### Required Custom CSS

Add these styles to your CSS for proper badge positioning and pulse animation:

```css
/* Notification Badge Sizing */
.badge-notification-sm {
    min-width: 1rem;
    min-height: 1rem;
    padding: 0.15rem 0.35rem;
    font-size: 0.65rem;
    line-height: 1;
}

.badge-notification-md {
    min-width: 1.25rem;
    min-height: 1.25rem;
    padding: 0.25rem 0.45rem;
    font-size: 0.75rem;
    line-height: 1;
}

.badge-notification-lg {
    min-width: 1.5rem;
    min-height: 1.5rem;
    padding: 0.35rem 0.55rem;
    font-size: 0.85rem;
    line-height: 1;
}

/* Notification Badge Positioning */
.badge-top-start {
    top: 0;
    left: 0;
}

.badge-top-end {
    top: 0;
    right: 0;
}

.badge-bottom-start {
    bottom: 0;
    left: 0;
}

.badge-bottom-end {
    bottom: 0;
    right: 0;
}

/* Pulse Animation */
.badge-pulse {
    animation: badge-pulse 2s infinite;
}

@keyframes badge-pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(var(--bs-danger-rgb), 0.7);
    }
    70% {
        box-shadow: 0 0 0 6px rgba(var(--bs-danger-rgb), 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(var(--bs-danger-rgb), 0);
    }
}

/* Parent container requirements */
.position-relative {
    position: relative;
}
```

**Note**: Make sure the parent element has `position: relative` (use Bootstrap's `position-relative` class).

## Accessibility

### ARIA Attributes

For better accessibility, add appropriate ARIA labels:

```twig
<button class="btn btn-primary position-relative" aria-label="Messages with 5 unread items">
  Messages
  <twig:bs:notification-badge 
    content="5"
    :attr="{'aria-hidden': 'true'}"
  />
</button>
```

### Screen Reader Text

The pulse animation includes visually hidden text:

```twig
<button class="btn btn-primary position-relative">
  Notifications
  <twig:bs:notification-badge content="3" :pulse="true" />
  {# Includes: <span class="visually-hidden">New notifications</span> #}
</button>
```

### Best Practices

1. **Always use with relative parent**: Ensure the parent element has `position: relative`
2. **Provide context**: Use `aria-label` on the parent to describe the badge content
3. **Hide decorative badges**: Use `aria-hidden="true"` for purely decorative indicators
4. **Meaningful colors**: Use semantic variants (danger for errors, success for status)

## Configuration

Global defaults can be configured in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  notification_badge:
    variant: 'danger'
    size: 'md'
    position: 'top-end'
    dot: false
    pill: true
    bordered: true
    pulse: false
    max: null
    inline: false
    class: null
    attr: {}
```

## Use Cases

### 1. Navigation Notifications

Show unread counts on navigation items:

```twig
<ul class="nav">
  <li class="nav-item">
    <a class="nav-link position-relative" href="#inbox">
      Inbox
      <twig:bs:notification-badge content="12" />
    </a>
  </li>
</ul>
```

### 2. User Status

Show online/offline status on avatars:

```twig
<div class="position-relative d-inline-block">
  <twig:bs:avatar src="/user.jpg" size="lg" />
  <twig:bs:notification-badge :dot="true" variant="success" />
</div>
```

### 3. Shopping Cart

Display item count in cart:

```twig
<twig:bs:button href="/cart" variant="outline-primary" class="position-relative">
  <i class="bi bi-cart"></i> Cart
  <twig:bs:notification-badge content="{{ cartItemCount }}" />
</twig:bs:button>
```

### 4. Alerts & Warnings

Show attention indicators:

```twig
<button class="btn btn-light position-relative">
  System Status
  <twig:bs:notification-badge :dot="true" :pulse="true" variant="warning" />
</button>
```

## Differences from Badge Component

| Feature | Badge Component | NotificationBadge Component |
|---------|----------------|----------------------------|
| Purpose | Display text labels, tags | Show notification indicators |
| Positioning | Inline/block element | Absolute positioned overlay |
| Size | Text-based sizing | Fixed min-width/height |
| Dot mode | ❌ No | ✅ Yes |
| Pulse animation | ❌ No | ✅ Yes |
| Max number | ❌ No | ✅ Yes (shows "99+") |
| Border | ❌ No | ✅ Optional white border |
| Use cases | Tags, labels, categories | Notification counts, status indicators |

## Testing

Run tests for the NotificationBadge component:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/NotificationBadgeTest.php
```

## Related Components

- **Badge**: Standard badge component for inline text labels
- **Avatar**: Often used together for user status indicators
- **Button**: Common parent for notification badges
- **Navbar**: Frequently contains notification badges

## Browser Support

Works in all modern browsers that support:
- CSS `position: absolute`
- CSS `translate` transform
- CSS animations (for pulse effect)

## References

- [Bootstrap Badges](https://getbootstrap.com/docs/5.3/components/badge/)
- [Bootstrap Position Utilities](https://getbootstrap.com/docs/5.3/utilities/position/)
- [CSS Animations](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations)

