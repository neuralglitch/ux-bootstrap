# Navbar Component

The `bs:navbar` component provides powerful navigation headers with multiple collapse types, sticky behavior, and mega menu support based on Bootstrap 5.3.

## Basic Usage

```twig
{# Simple navbar #}
<twig:bs:navbar brand="My Site" brandHref="/">
  {% block content %}
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
    </ul>
  {% endblock %}
</twig:bs:navbar>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `brand` | `?string` | `null` | Brand text or HTML |
| `brandHref` | `?string` | `'#'` | Brand link URL |
| `brandImg` | `?string` | `null` | Brand image URL |
| `brandImgAlt` | `?string` | `''` | Brand image alt text |
| `brandIcon` | `?string` | `null` | Brand icon (UX Icon name) |
| `bg` | `?string` | `'body-tertiary'` | Background color |
| `theme` | `?string` | `null` | Theme: `'light'`, `'dark'` |
| `expand` | `?string` | `'lg'` | Expand breakpoint: `'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'` |
| `container` | `string` | `'container-fluid'` | Container type |
| `placement` | `?string` | `null` | Position: `'fixed-top'`, `'fixed-bottom'`, `'sticky-top'` |
| `borderBottom` | `bool` | `false` | Show bottom border |
| `collapseId` | `string` | `'navbarSupportedContent'` | Collapse container ID |
| `collapseType` | `string` | `'standard'` | Collapse type: `'standard'`, `'offcanvas'`, `'fullscreen'`, `'mega-menu'` |
| `stickyBehavior` | `bool` | `false` | Enable sticky scroll behavior |
| `shrinkOnScroll` | `bool` | `false` | Shrink navbar on scroll |
| `autoHide` | `bool` | `false` | Auto-hide on scroll down |
| `megaMenu` | `bool` | `false` | Enable mega menu support |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Dark navbar #}
<twig:bs:navbar 
  brand="My Site" 
  bg="dark" 
  theme="dark" 
  expand="lg">
  {% block content %}
    {# Navigation items #}
  {% endblock %}
</twig:bs:navbar>

{# Fixed top navbar #}
<twig:bs:navbar 
  brand="My Site" 
  placement="fixed-top">
  {% block content %}
    {# Navigation items #}
  {% endblock %}
</twig:bs:navbar>

{# Navbar with sticky behavior #}
<twig:bs:navbar 
  brand="My Site"
  :stickyBehavior="true"
  :shrinkOnScroll="true"
  :shadowOnScroll="true">
  {% block content %}
    {# Navigation items #}
  {% endblock %}
</twig:bs:navbar>

{# Offcanvas navbar #}
<twig:bs:navbar 
  brand="My Site"
  collapseType="offcanvas"
  offcanvasPlacement="start">
  {% block content %}
    {# Navigation items #}
  {% endblock %}
</twig:bs:navbar>
```

## Collapse Types

1. **Standard** - Classic Bootstrap collapse
2. **Offcanvas** - Slide-in sidebar menu
3. **Fullscreen** - Full-screen overlay menu
4. **Mega Menu** - Dropdown mega menu support

## Stimulus Controllers

The navbar component can use multiple Stimulus controllers:

- `bs-navbar-sticky` - Sticky scroll behavior
- `bs-navbar-fullscreen` - Fullscreen overlay
- `bs-navbar-mega-menu` - Mega menu functionality

## References

- [Bootstrap 5.3 Navbar Documentation](https://getbootstrap.com/docs/5.3/components/navbar/)
