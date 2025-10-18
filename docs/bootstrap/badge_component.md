# Badge Component

The `bs:badge` component provides small count and labeling elements with support for positioning and styling based on Bootstrap 5.3's badge component.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Props](#component-props)
- [Examples](#examples)
  - [Basic Badges](#basic-badges)
  - [Badge Variants](#badge-variants)
  - [Pill Badges](#pill-badges)
  - [Link Badges](#link-badges)
  - [Positioned Badges](#positioned-badges)
  - [Badges in Buttons](#badges-in-buttons)
  - [Text Color Customization](#text-color-customization)
- [Accessibility](#accessibility)
- [Configuration](#configuration)
- [Testing](#testing)
- [Related Components](#related-components)
- [References](#references)

## Overview

The badge component provides:
- 8 color variants
- Pill-style rounded badges
- Clickable badge links
- Positioned badges for notifications
- Text color customization
- Full accessibility support

## Basic Usage

```twig
{# Simple badge #}
<twig:bs:badge variant="primary">New</twig:bs:badge>

{# Badge with label prop #}
<twig:bs:badge variant="danger" label="Hot" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `label` | `?string` | `null` | Badge text (alternative to content block) |
| `pill` | `bool` | `false` | Use rounded pill style |
| `href` | `?string` | `null` | URL for clickable badge (auto-sets tag to `'a'`) |
| `target` | `?string` | `null` | Link target: `'_blank'`, `'_self'`, etc. |
| `rel` | `?string` | `null` | Link relationship: `'noopener'`, `'noreferrer'`, etc. |
| `title` | `?string` | `null` | Tooltip text |
| `id` | `?string` | `null` | Unique identifier |
| `text` | `?string` | `null` | Text color utility: `'white'`, `'dark'`, `'body'`, etc. |
| `positioned` | `bool` | `false` | Enable absolute positioning (for notification badges) |
| `position` | `?string` | `null` | Position utilities: `'top-0 start-100'`, `'top-0 end-0'`, etc. |
| `translate` | `bool` | `true` | Apply translate-middle when positioned |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Basic Badges

```twig
<h1>Example heading <twig:bs:badge variant="secondary">New</twig:bs:badge></h1>
<h2>Example heading <twig:bs:badge variant="success">New</twig:bs:badge></h2>
<h3>Example heading <twig:bs:badge variant="primary">New</twig:bs:badge></h3>
```

### Badge Variants

```twig
<twig:bs:badge variant="primary">Primary</twig:bs:badge>
<twig:bs:badge variant="secondary">Secondary</twig:bs:badge>
<twig:bs:badge variant="success">Success</twig:bs:badge>
<twig:bs:badge variant="danger">Danger</twig:bs:badge>
<twig:bs:badge variant="warning">Warning</twig:bs:badge>
<twig:bs:badge variant="info">Info</twig:bs:badge>
<twig:bs:badge variant="light">Light</twig:bs:badge>
<twig:bs:badge variant="dark">Dark</twig:bs:badge>
```

### Pill Badges

```twig
<twig:bs:badge variant="primary" :pill="true">Primary</twig:bs:badge>
<twig:bs:badge variant="secondary" :pill="true">Secondary</twig:bs:badge>
<twig:bs:badge variant="success" :pill="true">Success</twig:bs:badge>
```

### Link Badges

```twig
{# Clickable badge #}
<twig:bs:badge variant="primary" href="/notifications">
  Notifications <twig:bs:badge variant="light" text="dark">4</twig:bs:badge>
</twig:bs:badge>

{# Badge link with external target #}
<twig:bs:badge 
  variant="info" 
  href="https://example.com" 
  target="_blank" 
  rel="noopener noreferrer">
  Visit Site
</twig:bs:badge>
```

### Positioned Badges

```twig
{# Notification badge on button #}
<button type="button" class="btn btn-primary position-relative">
  Inbox
  <twig:bs:badge 
    variant="danger" 
    :positioned="true" 
    position="top-0 start-100" 
    :translate="true">
    99+
  </twig:bs:badge>
</button>

{# Badge on icon #}
<div class="position-relative" style="width: 2rem; height: 2rem;">
  <svg class="bi" width="32" height="32" fill="currentColor">
    <use xlink:href="#bell-fill"/>
  </svg>
  <twig:bs:badge 
    variant="danger" 
    :positioned="true" 
    position="top-0 start-100" 
    class="p-1">
    <span class="visually-hidden">New alerts</span>
  </twig:bs:badge>
</div>
```

### Badges in Buttons

```twig
<twig:bs:button variant="primary">
  Notifications <twig:bs:badge variant="light" text="dark">4</twig:bs:badge>
</twig:bs:button>

<twig:bs:button variant="secondary">
  Profile <twig:bs:badge variant="danger">9</twig:bs:badge>
</twig:bs:button>
```

### Text Color Customization

```twig
{# Light badge with dark text #}
<twig:bs:badge variant="light" text="dark">Light</twig:bs:badge>

{# Dark badge with white text (default) #}
<twig:bs:badge variant="dark">Dark</twig:bs:badge>

{# Custom text color #}
<twig:bs:badge variant="primary" text="warning">Custom</twig:bs:badge>
```

## Accessibility

The badge component includes accessibility features:

- Semantic `<span>` or `<a>` elements
- Link badges include proper `href` attributes
- External links can have `rel` for security
- Use `visually-hidden` for screen reader context on icon badges
- Positioned badges inherit button/link accessibility

**Best Practices:**
- Add `visually-hidden` text for icon-only badges
- Use descriptive text, not just numbers
- Ensure sufficient color contrast
- Provide `title` for additional context

**Example with screen reader text:**
```twig
<twig:bs:badge variant="danger">
  4 <span class="visually-hidden">unread messages</span>
</twig:bs:badge>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  badge:
    variant: 'secondary'       # Default variant
    pill: false                # Not rounded by default
    href: null                 # No link by default
    target: '_self'            # Default link target
    rel: null                  # No rel by default
    title: null                # No tooltip by default
    id: null
    text: null                 # No text color override
    positioned: false          # Not positioned by default
    position: null             # No position classes
    translate: true            # Apply translate-middle when positioned
    class: null
    attr: {}
```

## Testing

The badge component includes comprehensive tests in `tests/Twig/Components/Bootstrap/BadgeTest.php`.

Run tests:
```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/BadgeTest.php
```

## Related Components

- **Button** - For actionable badges
- **Alert** - For larger contextual messages
- **Card** - For content with badge headers

## References

- [Bootstrap 5.3 Badges Documentation](https://getbootstrap.com/docs/5.3/components/badge/)
- [Bootstrap Badge Examples](https://getbootstrap.com/docs/5.3/components/badge/#examples)
- [Symfony UX TwigComponent](https://symfony.com/bundles/ux-twig-component/current/index.html)

