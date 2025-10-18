# Nav Component

Documentation for the Bootstrap 5.3 Nav component in Symfony UX Bootstrap bundle.

## Overview

The Nav component (`bs:nav` and `bs:nav-item`) provides flexible navigation components with support for tabs, pills, underline styles, and various layout options. It follows [Bootstrap 5.3 Navs and Tabs](https://getbootstrap.com/docs/5.3/components/navs-tabs/) specifications.

## Components

This implementation consists of two components:
- **`bs:nav`** - The navigation container
- **`bs:nav-item`** - Individual navigation items/links

## Basic Usage

### Simple Navigation

```twig
<twig:bs:nav>
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/contact">Contact</twig:bs:nav-item>
    <twig:bs:nav-item :disabled="true">Disabled</twig:bs:nav-item>
</twig:bs:nav>
```

### Without List Structure

Use `tag="nav"` and `wrapper="false"` for a simpler structure:

```twig
<twig:bs:nav tag="nav">
    <twig:bs:nav-item href="/" :active="true" :wrapper="false">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about" :wrapper="false">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/contact" :wrapper="false">Contact</twig:bs:nav-item>
</twig:bs:nav>
```

## Nav Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Nav style: `null`, `'tabs'`, `'pills'`, or `'underline'` |
| `fill` | `bool` | `false` | Fill available space equally (`nav-fill`) |
| `justified` | `bool` | `false` | Equal width items (`nav-justified`) |
| `vertical` | `string\|bool` | `false` | Stack vertically: `false`, `true`, or responsive (`'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'`) |
| `align` | `?string` | `null` | Horizontal alignment: `null`, `'start'`, `'center'`, or `'end'` |
| `tag` | `string` | `'ul'` | HTML tag: `'ul'`, `'ol'`, `'nav'`, or `'div'` |
| `id` | `?string` | `null` | Optional ID attribute |
| `role` | `?string` | `null` | ARIA role (auto-detected based on tag if null) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## NavItem Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `?string` | `null` | Link text (alternative to content block) |
| `href` | `?string` | `null` | Link URL |
| `active` | `bool` | `false` | Mark item as active |
| `disabled` | `bool` | `false` | Disable the nav item |
| `tag` | `string` | `'a'` | HTML tag: `'a'`, `'button'`, or `'span'` (auto-detected) |
| `id` | `?string` | `null` | Optional ID attribute |
| `target` | `?string` | `null` | Link target: `'_blank'`, `'_self'`, etc. |
| `ariaCurrent` | `string\|bool\|null` | `'page'` | Value for `aria-current` when active |
| `wrapper` | `bool` | `true` | Render nav-item wrapper (for `<ul>` nav) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Tabs Navigation

```twig
<twig:bs:nav variant="tabs">
    <twig:bs:nav-item href="#home" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="#profile">Profile</twig:bs:nav-item>
    <twig:bs:nav-item href="#messages">Messages</twig:bs:nav-item>
    <twig:bs:nav-item href="#settings">Settings</twig:bs:nav-item>
</twig:bs:nav>
```

### Pills Navigation

```twig
<twig:bs:nav variant="pills">
    <twig:bs:nav-item href="#home" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="#profile">Profile</twig:bs:nav-item>
    <twig:bs:nav-item href="#messages">Messages</twig:bs:nav-item>
</twig:bs:nav>
```

### Underline Navigation

```twig
<twig:bs:nav variant="underline">
    <twig:bs:nav-item href="/" :active="true">Active</twig:bs:nav-item>
    <twig:bs:nav-item href="/link">Link</twig:bs:nav-item>
    <twig:bs:nav-item href="/another">Another Link</twig:bs:nav-item>
</twig:bs:nav>
```

### Vertical Navigation

```twig
<twig:bs:nav :vertical="true">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/services">Services</twig:bs:nav-item>
</twig:bs:nav>
```

### Responsive Vertical

Stack on medium screens and up:

```twig
<twig:bs:nav vertical="md">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/services">Services</twig:bs:nav-item>
</twig:bs:nav>
```

### Centered Navigation

```twig
<twig:bs:nav align="center">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/contact">Contact</twig:bs:nav-item>
</twig:bs:nav>
```

### Right-Aligned Navigation

```twig
<twig:bs:nav align="end">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    <twig:bs:nav-item href="/contact">Contact</twig:bs:nav-item>
</twig:bs:nav>
```

### Fill Available Space

```twig
<twig:bs:nav :fill="true">
    <twig:bs:nav-item href="/" :active="true">Active</twig:bs:nav-item>
    <twig:bs:nav-item href="/link">Much longer nav link</twig:bs:nav-item>
    <twig:bs:nav-item href="/another">Link</twig:bs:nav-item>
</twig:bs:nav>
```

### Justified Navigation

Equal width items:

```twig
<twig:bs:nav :justified="true">
    <twig:bs:nav-item href="/" :active="true">Active</twig:bs:nav-item>
    <twig:bs:nav-item href="/link">Much longer nav link</twig:bs:nav-item>
    <twig:bs:nav-item href="/another">Link</twig:bs:nav-item>
</twig:bs:nav>
```

### Vertical Pills with Centered Alignment

```twig
<twig:bs:nav variant="pills" :vertical="true" align="center">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/profile">Profile</twig:bs:nav-item>
    <twig:bs:nav-item href="/messages">Messages</twig:bs:nav-item>
</twig:bs:nav>
```

### With Dropdowns (Using Bootstrap JavaScript)

```twig
<twig:bs:nav variant="pills">
    <twig:bs:nav-item href="/" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
    
    {# Dropdown nav item #}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" 
           aria-expanded="false">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </li>
</twig:bs:nav>
```

### Nav as Tabs (with Tab Content)

```twig
{# Tab navigation #}
<twig:bs:nav variant="tabs" id="myTab" role="tablist">
    <twig:bs:nav-item 
        :active="true" 
        id="home-tab"
        attr="{{ {'data-bs-toggle': 'tab', 'data-bs-target': '#home', 'role': 'tab', 'aria-controls': 'home', 'aria-selected': 'true'} }}">
        Home
    </twig:bs:nav-item>
    <twig:bs:nav-item 
        id="profile-tab"
        attr="{{ {'data-bs-toggle': 'tab', 'data-bs-target': '#profile', 'role': 'tab', 'aria-controls': 'profile', 'aria-selected': 'false'} }}">
        Profile
    </twig:bs:nav-item>
    <twig:bs:nav-item 
        id="messages-tab"
        attr="{{ {'data-bs-toggle': 'tab', 'data-bs-target': '#messages', 'role': 'tab', 'aria-controls': 'messages', 'aria-selected': 'false'} }}">
        Messages
    </twig:bs:nav-item>
</twig:bs:nav>

{# Tab content #}
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        Home content...
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        Profile content...
    </div>
    <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
        Messages content...
    </div>
</div>
```

### Custom Classes and Attributes

```twig
<twig:bs:nav 
    variant="pills" 
    class="mb-3 custom-nav" 
    attr="{{ {'data-controller': 'navigation'} }}">
    <twig:bs:nav-item 
        href="/" 
        :active="true" 
        class="custom-item"
        attr="{{ {'data-action': 'click->navigation#select'} }}">
        Home
    </twig:bs:nav-item>
    <twig:bs:nav-item href="/about">About</twig:bs:nav-item>
</twig:bs:nav>
```

### Button-Based Navigation

```twig
<twig:bs:nav tag="nav">
    <twig:bs:nav-item tag="button" :active="true" :wrapper="false">Active</twig:bs:nav-item>
    <twig:bs:nav-item tag="button" :wrapper="false">Link</twig:bs:nav-item>
    <twig:bs:nav-item tag="button" :wrapper="false">Another Link</twig:bs:nav-item>
    <twig:bs:nav-item tag="button" :disabled="true" :wrapper="false">Disabled</twig:bs:nav-item>
</twig:bs:nav>
```

## Accessibility

### ARIA Roles

The component automatically sets appropriate ARIA roles:
- `<ul>` or `<ol>` tags get `role="list"`
- `<nav>` tag gets `role="navigation"`

### Active State

Use `aria-current` to indicate the active nav item:

```twig
<twig:bs:nav-item href="/" :active="true" ariaCurrent="page">Home</twig:bs:nav-item>
```

Supported `ariaCurrent` values:
- `'page'` - current page in a set of pages
- `'step'` - current step in a process
- `'location'` - current location within an environment
- `'date'` - current date within a collection
- `'time'` - current time within a collection
- `true` - generic current state

### Disabled State

Disabled items include proper ARIA attributes:

```twig
<twig:bs:nav-item :disabled="true">Disabled</twig:bs:nav-item>
```

This adds:
- `aria-disabled="true"`
- `tabindex="-1"`
- `.disabled` class

### Keyboard Navigation

- Nav items are focusable via Tab key
- Disabled items are removed from tab order (`tabindex="-1"`)
- For tab interfaces, use proper `role="tablist"` and `role="tab"` attributes

### Screen Readers

- Use descriptive labels for nav items
- Provide context with `aria-label` on the nav container if needed:

```twig
<twig:bs:nav attr="{{ {'aria-label': 'Main navigation'} }}">
    <!-- nav items -->
</twig:bs:nav>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  nav:
    variant: null         # null | 'tabs' | 'pills' | 'underline'
    fill: false           # nav-fill: fill available space equally
    justified: false      # nav-justified: equal widths
    vertical: false       # false | true | 'sm' | 'md' | 'lg' | 'xl' | 'xxl' (responsive)
    align: null           # null | 'start' | 'center' | 'end'
    tag: 'ul'             # 'ul' | 'ol' | 'nav' | 'div'
    id: null
    role: null            # null (auto-detected based on tag)
    class: null
    attr: {  }

  nav_item:
    label: null
    href: null
    active: false
    disabled: false
    tag: 'a'              # 'a' | 'button' | 'span' (auto-detected)
    id: null
    target: null          # For links: '_blank' | '_self' | '_parent' | '_top'
    aria_current: 'page'  # Value for aria-current when active
    wrapper: true         # Render nav-item wrapper (for <ul> nav)
    class: null
    attr: {  }
```

### Customizing Defaults

Override defaults in your configuration:

```yaml
neuralglitch_ux_bootstrap:
  nav:
    variant: 'pills'
    align: 'center'
    class: 'mb-3'
  
  nav_item:
    aria_current: 'location'
```

## Testing

The component includes comprehensive tests:

```bash
# Run Nav tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/NavTest.php

# Run NavItem tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/NavItemTest.php
```

Test coverage includes:
- Default options
- All variants (tabs, pills, underline)
- Layout options (fill, justified, vertical, align)
- Different HTML tags
- Active and disabled states
- Auto-detection of tag types
- Custom classes and attributes
- Configuration defaults

## Best Practices

### DO:
- ✅ Use semantic HTML (`<nav>` for main navigation)
- ✅ Mark the current page with `active` and `aria-current="page"`
- ✅ Use `disabled` for unavailable items
- ✅ Provide descriptive labels for nav items
- ✅ Use `wrapper="false"` with `tag="nav"` for cleaner markup
- ✅ Choose the appropriate variant for your use case

### DON'T:
- ❌ Don't mix list and non-list structures (use consistent `tag` and `wrapper` values)
- ❌ Don't forget to mark the active item
- ❌ Don't use multiple active items (unless using tabs with JavaScript)
- ❌ Don't omit `aria-current` when using active state
- ❌ Don't use divs when semantic elements are available

## Related Components

- **Navbar** - Full-featured navigation bar with branding and responsive collapse
- **Breadcrumbs** - Hierarchical navigation trail
- **ListGroup** - Similar list-based component for content
- **Tabs** - See examples above for tab interfaces

## References

- [Bootstrap 5.3 Navs & Tabs Documentation](https://getbootstrap.com/docs/5.3/components/navs-tabs/)
- [Bootstrap 5.3 JavaScript Tab Behavior](https://getbootstrap.com/docs/5.3/components/navs-tabs/#javascript-behavior)
- [WAI-ARIA Authoring Practices - Tabs](https://www.w3.org/WAI/ARIA/apg/patterns/tabs/)
- [MDN: ARIA current attribute](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Attributes/aria-current)

## Migration Guide

If migrating from plain Bootstrap markup:

**Before (Bootstrap HTML):**
```html
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
</ul>
```

**After (Twig Component):**
```twig
<twig:bs:nav variant="pills">
    <twig:bs:nav-item href="#" :active="true">Active</twig:bs:nav-item>
    <twig:bs:nav-item href="#">Link</twig:bs:nav-item>
</twig:bs:nav>
```

Benefits:
- Cleaner, more maintainable markup
- Type-safe props with autocompletion
- Consistent component interface
- Configurable defaults
- Automatic accessibility attributes

