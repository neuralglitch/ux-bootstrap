# Theme Component

The `bs:theme` component provides a theme toggle for switching between light, dark, and auto themes with multiple display modes.

## Basic Usage

```twig
{# Simple icon toggle #}
<twig:bs:theme mode="button-icon" />

{# Dropdown menu #}
<twig:bs:theme mode="dropdown-text" variant="secondary" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | `?string` | `null` | Display mode (see below) |
| `variant` | `?string` | `null` | Button variant: `'primary'`, `'secondary'`, etc. |
| `initial` | `?string` | `null` | Initial theme: `'light'`, `'dark'`, `'auto'` |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Display Modes

### Button Modes
- **`button-icon`** - Icon-only button (default)
- **`button-icon-toggle`** - Toggle button with icon
- **`button-text`** - Text-only button
- **`button-icon-text`** - Button with icon and text

### Dropdown Modes
- **`dropdown-text`** - Dropdown menu with text labels
- **`dropdown-icon`** - Dropdown menu with icons

### Link Modes
- **`link`** - Simple text link
- **`link-icon`** - Link with icon

### Form Modes
- **`form-select`** - Select dropdown
- **`form-switch`** - Toggle switch
- **`form-check`** - Radio buttons

## Examples

```twig
{# Icon button in navbar #}
<nav class="navbar">
  <div class="container-fluid">
    <span class="navbar-brand">My Site</span>
    <twig:bs:theme mode="button-icon" variant="outline-secondary" />
  </div>
</nav>

{# Dropdown menu #}
<twig:bs:theme 
  mode="dropdown-text" 
  variant="secondary" 
  initial="auto" />

{# Toggle switch in settings #}
<div class="form-group">
  <label>Theme Preference</label>
  <twig:bs:theme mode="form-switch" />
</div>

{# Radio buttons #}
<twig:bs:theme mode="form-check" class="d-flex gap-3" />

{# Link in footer #}
<footer>
  <twig:bs:theme mode="link-icon" />
</footer>
```

## Initial Theme

Set the initial theme to match user preference:

```twig
{# Start with dark theme #}
<twig:bs:theme initial="dark" />

{# Start with system preference #}
<twig:bs:theme initial="auto" />

{# Start with light theme (default if not specified) #}
<twig:bs:theme initial="light" />
```

## Stimulus Controller

The theme component uses the `bs-theme` Stimulus controller.

**Controller:** `assets/controllers/bs_theme_controller.js`

**Features:**
- Persists theme preference in localStorage
- Applies theme via `data-bs-theme` attribute on `<html>`
- Auto-detects system preference for `'auto'` mode
- Smooth theme transitions

**Data Attributes:**
- `data-controller="bs-theme"` - Activates controller (auto-added)
- Theme state stored in `localStorage` as `theme`

## Customization

```twig
{# Custom button variant #}
<twig:bs:theme mode="button-icon" variant="primary" />

{# With custom classes #}
<twig:bs:theme mode="dropdown-text" class="ms-auto" />

{# With custom attributes #}
<twig:bs:theme 
  mode="button-icon" 
  :attr="{
    'data-bs-toggle': 'tooltip',
    'title': 'Toggle theme'
  }" />
```

## Integration with Bootstrap

The theme toggle works with Bootstrap 5.3's color mode feature:

```html
<!-- Bootstrap automatically applies theme colors -->
<html data-bs-theme="dark">
  <!-- All Bootstrap components automatically switch to dark mode -->
</html>
```

## References

- [Bootstrap 5.3 Color Modes](https://getbootstrap.com/docs/5.3/customize/color-modes/)
- [Bootstrap Dark Mode Documentation](https://getbootstrap.com/docs/5.3/customize/color-modes/#building-with-sass)
- [Stimulus Handbook](https://stimulus.hotwired.dev/)
