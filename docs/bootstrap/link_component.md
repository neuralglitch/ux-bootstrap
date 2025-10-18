# Link Component

The `bs:link` component provides enhanced links with underline control, tooltips, popovers, and Bootstrap 5.3 link utilities.

## Basic Usage

```twig
{# Simple link #}
<twig:bs:link href="/about" label="About Us" />

{# Link with content #}
<twig:bs:link href="/contact">
  Contact Us
</twig:bs:link>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | `string` | `'#'` | Link URL |
| `label` | `?string` | `null` | Link text (alternative to content block) |
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `target` | `?string` | `'_self'` | Link target: `'_blank'`, `'_self'`, etc. |
| `rel` | `?string` | `null` | Link relationship: `'noopener'`, `'noreferrer'`, etc. |
| `underline` | `?string` | `null` | Underline style: `'always'`, `'never'`, `'hover'` |
| `underlineOpacity` | `?int` | `null` | Underline opacity: 0-100 |
| `underlineOpacityHover` | `?int` | `null` | Underline opacity on hover: 0-100 |
| `offset` | `?int` | `null` | Underline offset: 1-3 |
| `stretched` | `bool` | `false` | Make link stretch to fill container |
| `block` | `bool` | `false` | Display as block element |
| `active` | `bool` | `false` | Active state |
| `disabled` | `bool` | `false` | Disabled state (href becomes `javascript:void(0)`) |
| `iconStart` | `?string` | `null` | Icon at start (UX Icon name) |
| `iconEnd` | `?string` | `null` | Icon at end (UX Icon name) |
| `tooltip` | `?string` | `null` | Tooltip text |
| `popover` | `?array` | `null` | Popover configuration |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Colored links #}
<twig:bs:link href="#" variant="primary">Primary link</twig:bs:link>
<twig:bs:link href="#" variant="danger">Danger link</twig:bs:link>

{# Underline control #}
<twig:bs:link href="#" underline="never">No underline</twig:bs:link>
<twig:bs:link href="#" underline="always">Always underline</twig:bs:link>
<twig:bs:link href="#" underline="hover">Underline on hover</twig:bs:link>

{# Underline opacity #}
<twig:bs:link href="#" :underlineOpacity="25">25% opacity</twig:bs:link>
<twig:bs:link href="#" :underlineOpacity="50" :underlineOpacityHover="100">
  Opacity changes on hover
</twig:bs:link>

{# External link #}
<twig:bs:link 
  href="https://example.com" 
  target="_blank" 
  rel="noopener noreferrer">
  External Site
</twig:bs:link>

{# Stretched link (in card) #}
<div class="card position-relative">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Card description.</p>
    <twig:bs:link href="/details" :stretched="true">Go somewhere</twig:bs:link>
  </div>
</div>
```

## References

- [Bootstrap 5.3 Link Utilities](https://getbootstrap.com/docs/5.3/helpers/colored-links/)
- [Bootstrap 5.3 Text Utilities](https://getbootstrap.com/docs/5.3/utilities/text/)
