# Sidebar Component

> **Extra Component** – Part of the NeuralGlitch UX Bootstrap Bundle

The Sidebar component provides a flexible navigation sidebar for admin dashboards, documentation sites, settings pages, and multi-level navigation. It supports multiple layout variants, responsive behavior, and mobile-friendly collapsing.

---

## Table of Contents

1. [Overview](#overview)
2. [Basic Usage](#basic-usage)
3. [Component Props](#component-props)
4. [Variants](#variants)
5. [Examples](#examples)
6. [Mobile Behavior](#mobile-behavior)
7. [Accessibility](#accessibility)
8. [Configuration](#configuration)
9. [Styling](#styling)
10. [Stimulus Integration](#stimulus-integration)
11. [Testing](#testing)
12. [Related Components](#related-components)
13. [References](#references)

---

## Overview

The Sidebar component offers a comprehensive solution for vertical navigation in web applications. Key features include:

- **5 Layout Variants**: Fixed, collapsible, overlay, push, and mini
- **Multi-level Navigation**: Support for nested menus
- **Mobile Responsive**: Automatic behavior switching on mobile devices
- **Customizable**: Width, position, styling, and behavior
- **Accessible**: ARIA attributes and keyboard navigation
- **Stimulus Integration**: Interactive toggle and collapse functionality

---

## Basic Usage

### Simple Sidebar

```twig
<twig:bs:sidebar>
  <nav class="ux-sidebar__nav">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="/dashboard">
          <span class="ux-sidebar__nav-icon">📊</span>
          <span class="ux-sidebar__nav-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users">
          <span class="ux-sidebar__nav-icon">👥</span>
          <span class="ux-sidebar__nav-text">Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/settings">
          <span class="ux-sidebar__nav-icon">⚙️</span>
          <span class="ux-sidebar__nav-text">Settings</span>
        </a>
      </li>
    </ul>
  </nav>
</twig:bs:sidebar>
```

### With Header and Footer

```twig
<twig:bs:sidebar
    :showHeader="true"
    headerTitle="Admin Panel"
    :showFooter="true">
    
  {# Content #}
  {% block content %}
    <nav class="ux-sidebar__nav">
      {# Navigation items #}
    </nav>
  {% endblock %}
  
  {# Custom footer #}
  {% block footer %}
    <div class="px-3 py-3">
      <div class="d-flex align-items-center">
        <img src="/avatar.jpg" class="rounded-circle" width="32" height="32">
        <div class="ms-2">
          <div class="fw-bold">John Doe</div>
          <small class="text-muted">Admin</small>
        </div>
      </div>
    </div>
  {% endblock %}
</twig:bs:sidebar>
```

---

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'fixed'` | Layout variant: `'fixed'`, `'collapsible'`, `'overlay'`, `'push'`, `'mini'` |
| `position` | `string` | `'left'` | Position: `'left'` or `'right'` |
| `width` | `string` | `'280px'` | Sidebar width (CSS value) |
| `miniWidth` | `string` | `'80px'` | Width when collapsed to mini |
| `collapsed` | `bool` | `false` | Initial collapsed state |
| `collapsible` | `bool` | `true` | Allow collapse/expand |
| `overlay` | `bool` | `false` | Show overlay backdrop when open |
| `backdropClose` | `bool` | `true` | Close on backdrop click |
| `mobileBreakpoint` | `string` | `'lg'` | Breakpoint for mobile behavior |
| `mobileBehavior` | `string` | `'overlay'` | Mobile behavior: `'overlay'`, `'push'`, `'hidden'` |
| `showHeader` | `bool` | `false` | Display header section |
| `headerTitle` | `string\|null` | `null` | Header title text |
| `showToggle` | `bool` | `true` | Show toggle button in header |
| `showFooter` | `bool` | `false` | Display footer section |
| `bg` | `string\|null` | `null` | Bootstrap background variant |
| `textColor` | `string\|null` | `null` | Text color variant |
| `border` | `bool` | `false` | Show border |
| `shadow` | `bool` | `false` | Show shadow |
| `scrollable` | `bool` | `true` | Make sidebar scrollable |
| `zIndex` | `int` | `1040` | CSS z-index value |
| `transition` | `string` | `'slide'` | Transition effect: `'slide'`, `'fade'`, `'none'` |
| `transitionDuration` | `int` | `300` | Transition duration in milliseconds |
| `stimulusController` | `string` | `'bs-sidebar'` | Stimulus controller name |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

---

## Variants

### 1. Fixed Sidebar

Always visible, cannot be hidden:

```twig
<twig:bs:sidebar variant="fixed">
  {# Content #}
</twig:bs:sidebar>
```

### 2. Collapsible Sidebar

Can be toggled open/closed:

```twig
<twig:bs:sidebar 
    variant="collapsible"
    :collapsible="true"
    :showHeader="true"
    headerTitle="Menu">
  {# Content #}
</twig:bs:sidebar>
```

### 3. Overlay Sidebar

Slides over content with backdrop:

```twig
<twig:bs:sidebar 
    variant="overlay"
    :overlay="true"
    :backdropClose="true">
  {# Content #}
</twig:bs:sidebar>
```

### 4. Push Sidebar

Pushes main content when opened:

```twig
<twig:bs:sidebar variant="push">
  {# Content #}
</twig:bs:sidebar>

{# Main content must have .main-content class #}
<main class="main-content">
  {# Page content #}
</main>
```

### 5. Mini Sidebar

Collapses to icon-only view:

```twig
<twig:bs:sidebar 
    variant="mini"
    miniWidth="80px">
  <nav class="ux-sidebar__nav">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <span class="ux-sidebar__nav-icon">📊</span>
          <span class="ux-sidebar__nav-text">Dashboard</span>
        </a>
      </li>
    </ul>
  </nav>
</twig:bs:sidebar>
```

---

## Examples

### Admin Dashboard Sidebar

```twig
<twig:bs:sidebar
    variant="mini"
    :showHeader="true"
    headerTitle="Admin"
    :showFooter="true"
    bg="dark"
    textColor="white"
    :border="true">
    
  {% block content %}
    <nav class="ux-sidebar__nav">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="/admin/dashboard">
            <span class="ux-sidebar__nav-icon">📊</span>
            <span class="ux-sidebar__nav-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/users">
            <span class="ux-sidebar__nav-icon">👥</span>
            <span class="ux-sidebar__nav-text">Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/products">
            <span class="ux-sidebar__nav-icon">📦</span>
            <span class="ux-sidebar__nav-text">Products</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/orders">
            <span class="ux-sidebar__nav-icon">🛒</span>
            <span class="ux-sidebar__nav-text">Orders</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/analytics">
            <span class="ux-sidebar__nav-icon">📈</span>
            <span class="ux-sidebar__nav-text">Analytics</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/settings">
            <span class="ux-sidebar__nav-icon">⚙️</span>
            <span class="ux-sidebar__nav-text">Settings</span>
          </a>
        </li>
      </ul>
    </nav>
  {% endblock %}
  
  {% block footer %}
    <div class="px-3 py-3 border-top">
      <div class="d-flex align-items-center">
        <twig:bs:avatar 
            initials="JD" 
            size="sm" 
            variant="primary" />
        <div class="ms-2 ux-sidebar__nav-text">
          <div class="fw-bold small">John Doe</div>
          <small class="text-muted">Admin</small>
        </div>
      </div>
    </div>
  {% endblock %}
</twig:bs:sidebar>
```

### Documentation Sidebar

```twig
<twig:bs:sidebar
    variant="fixed"
    width="300px"
    :border="true"
    :scrollable="true">
    
  <nav class="ux-sidebar__nav">
    <div class="px-3 py-2">
      <h6 class="text-muted text-uppercase small">Getting Started</h6>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="/docs/installation">Installation</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/docs/configuration">Configuration</a>
      </li>
    </ul>
    
    <div class="px-3 py-2 mt-3">
      <h6 class="text-muted text-uppercase small">Components</h6>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="/docs/components/button">Button</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/docs/components/alert">Alert</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/docs/components/card">Card</a>
      </li>
    </ul>
  </nav>
</twig:bs:sidebar>
```

### Multi-level Navigation

```twig
<twig:bs:sidebar variant="collapsible">
  <nav class="ux-sidebar__nav">
    <ul class="nav flex-column">
      {# Parent item with submenu #}
      <li class="nav-item">
        <a class="nav-link" href="#" data-bs-sidebar-target="navItem">
          <span class="ux-sidebar__nav-icon">📁</span>
          <span class="ux-sidebar__nav-text">Projects</span>
        </a>
        <div class="ux-sidebar__submenu">
          <a class="nav-link" href="/projects/active">Active Projects</a>
          <a class="nav-link" href="/projects/archived">Archived</a>
          <a class="nav-link" href="/projects/new">Create New</a>
        </div>
      </li>
      
      {# Single item #}
      <li class="nav-item">
        <a class="nav-link" href="/tasks">
          <span class="ux-sidebar__nav-icon">✓</span>
          <span class="ux-sidebar__nav-text">Tasks</span>
        </a>
      </li>
    </ul>
  </nav>
</twig:bs:sidebar>
```

### Settings Page Sidebar

```twig
<twig:bs:sidebar
    variant="overlay"
    position="right"
    width="350px"
    :collapsed="true"
    :overlay="true">
    
  {% block content %}
    <div class="p-4">
      <h5 class="mb-4">Quick Settings</h5>
      
      <div class="mb-3">
        <label class="form-label">Theme</label>
        <twig:bs:theme mode="form-select" />
      </div>
      
      <div class="mb-3">
        <label class="form-label">Language</label>
        <select class="form-select">
          <option>English</option>
          <option>Deutsch</option>
          <option>Français</option>
        </select>
      </div>
      
      <div class="mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="notifications">
          <label class="form-check-label" for="notifications">
            Enable notifications
          </label>
        </div>
      </div>
    </div>
  {% endblock %}
</twig:bs:sidebar>
```

---

## Mobile Behavior

The sidebar automatically adjusts its behavior on mobile devices based on the `mobileBreakpoint` prop.

### Overlay Behavior (Default)

Sidebar slides in as an overlay with backdrop:

```twig
<twig:bs:sidebar
    mobileBreakpoint="lg"
    mobileBehavior="overlay">
  {# Content #}
</twig:bs:sidebar>
```

### Hidden Behavior

Sidebar is completely hidden on mobile:

```twig
<twig:bs:sidebar
    mobileBreakpoint="md"
    mobileBehavior="hidden">
  {# Content #}
</twig:bs:sidebar>
```

### Push Behavior

Sidebar pushes content (may not be ideal for mobile):

```twig
<twig:bs:sidebar
    mobileBreakpoint="lg"
    mobileBehavior="push">
  {# Content #}
</twig:bs:sidebar>
```

---

## Accessibility

The Sidebar component includes built-in accessibility features:

1. **ARIA Attributes**: Toggle button includes `aria-expanded` state
2. **Keyboard Navigation**: Escape key closes the sidebar
3. **Focus Management**: Focus is trapped within sidebar when open (overlay mode)
4. **Semantic HTML**: Uses `<aside>` element for sidebar, `<nav>` for navigation
5. **Screen Reader Support**: Proper labels and announcements

### Recommendations

- Add `aria-label` to navigation elements
- Use `aria-current="page"` for active links
- Ensure sufficient color contrast
- Make interactive elements keyboard accessible

```twig
<twig:bs:sidebar 
    :attr="{'aria-label': 'Main navigation'}">
  <nav aria-label="Primary">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" 
           href="/dashboard" 
           aria-current="page">
          Dashboard
        </a>
      </li>
    </ul>
  </nav>
</twig:bs:sidebar>
```

---

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  sidebar:
    variant: 'fixed'
    position: 'left'
    width: '280px'
    mini_width: '80px'
    collapsed: false
    collapsible: true
    overlay: false
    backdrop_close: true
    mobile_breakpoint: 'lg'
    mobile_behavior: 'overlay'
    show_header: false
    header_title: null
    show_toggle: true
    show_footer: false
    bg: null
    text_color: null
    border: false
    shadow: false
    scrollable: true
    z_index: 1040
    transition: 'slide'
    transition_duration: 300
    stimulus_controller: 'bs-sidebar'
    class: null
    attr: {}
```

---

## Styling

### CSS Custom Properties

The sidebar component uses CSS custom properties for easy customization:

```css
:root {
  --ux-sidebar-width: 280px;
  --ux-sidebar-mini-width: 80px;
  --ux-sidebar-z-index: 1040;
  --ux-sidebar-transition-duration: 300ms;
  --ux-sidebar-bg: var(--bs-body-bg);
  --ux-sidebar-border-color: var(--bs-border-color);
  --ux-sidebar-shadow: 0 0 1rem rgba(0, 0, 0, 0.15);
  --ux-sidebar-backdrop-bg: rgba(0, 0, 0, 0.5);
}
```

### Custom Styling

Override default styles with custom CSS:

```scss
.ux-sidebar {
  --ux-sidebar-width: 320px;
  --ux-sidebar-bg: #1a1a2e;
  
  .nav-link {
    border-radius: 8px;
    margin: 0.25rem 0.5rem;
    
    &:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
  }
}
```

---

## Stimulus Integration

The sidebar component is powered by a Stimulus controller (`bs-sidebar`) that handles:

- Toggle open/close functionality
- Mobile responsive behavior
- Keyboard navigation (Escape key)
- Backdrop click handling
- Smooth transitions

### JavaScript API

```javascript
// Get the controller instance
const sidebarController = application.getControllerForElementAndIdentifier(
  document.querySelector('[data-controller="bs-sidebar"]'),
  'bs-sidebar'
);

// Open sidebar
sidebarController.open();

// Close sidebar
sidebarController.close();

// Toggle sidebar
sidebarController.toggle();
```

### Custom Events

The controller dispatches custom events:

```javascript
// Listen for sidebar opened
document.addEventListener('bs-sidebar:opened', (event) => {
  console.log('Sidebar opened', event.detail.sidebar);
});

// Listen for sidebar closed
document.addEventListener('bs-sidebar:closed', (event) => {
  console.log('Sidebar closed', event.detail.sidebar);
});
```

---

## Testing

The Sidebar component includes comprehensive tests covering:

- Default options and variants
- Position and dimension options
- Collapsed state management
- Overlay and backdrop behavior
- Mobile responsive behavior
- Header and footer rendering
- Custom classes and attributes
- Configuration defaults
- Stimulus controller integration

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/SidebarTest.php
```

---

## Related Components

- **Navbar** (`bs:navbar`) - Top navigation bar
- **Offcanvas** (`bs:offcanvas`) - Similar slide-in panel
- **Nav** (`bs:nav`) - Navigation components
- **Breadcrumbs** (`bs:breadcrumbs`) - Breadcrumb navigation
- **Avatar** (`bs:avatar`) - User avatars in sidebar footer

---

## References

- [Bootstrap Documentation](https://getbootstrap.com/)
- [Symfony UX TwigComponent Documentation](https://symfony.com/bundles/ux-twig-component/current/index.html)
- [Stimulus Handbook](https://stimulus.hotwired.dev/)
- [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)

---

## Browser Support

The Sidebar component supports all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## License

Part of the NeuralGlitch UX Bootstrap Bundle. See [LICENSE](../LICENSE) for details.

