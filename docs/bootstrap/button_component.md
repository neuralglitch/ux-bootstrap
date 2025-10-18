# Button Component

The `bs:button` component provides enhanced buttons with icons, tooltips, popovers, and all Bootstrap 5.3 button features.

## Basic Usage

```twig
{# Simple button #}
<twig:bs:button variant="primary" label="Click Me" />

{# Button with content #}
<twig:bs:button variant="success">
  Save Changes
</twig:bs:button>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `outline` | `bool` | `false` | Use outline style |
| `size` | `?string` | `null` | Button size: `'sm'`, `'lg'` |
| `block` | `bool` | `false` | Full-width button (adds `w-100`) |
| `disabled` | `bool` | `false` | Disable button |
| `active` | `bool` | `false` | Active state |
| `href` | `?string` | `null` | URL for link button (changes tag to `<a>`) |
| `type` | `string` | `'button'` | Button type: `'button'`, `'submit'`, `'reset'` |
| `label` | `?string` | `null` | Button text (alternative to content block) |
| `iconStart` | `?string` | `null` | Icon at start (UX Icon name) |
| `iconEnd` | `?string` | `null` | Icon at end (UX Icon name) |
| `iconOnly` | `bool` | `false` | Icon-only button (no text) |
| `iconSize` | `?string` | `null` | Icon size override |
| `iconGap` | `int` | `2` | Gap between icon and text |
| `tooltip` | `?string` | `null` | Tooltip text |
| `popover` | `?array` | `null` | Popover configuration |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Variants #}
<twig:bs:button variant="primary">Primary</twig:bs:button>
<twig:bs:button variant="success" :outline="true">Outline Success</twig:bs:button>

{# Sizes #}
<twig:bs:button variant="primary" size="sm">Small</twig:bs:button>
<twig:bs:button variant="primary" size="lg">Large</twig:bs:button>

{# With icons #}
<twig:bs:button variant="primary" iconStart="bi:download">Download</twig:bs:button>
<twig:bs:button variant="danger" iconEnd="bi:trash">Delete</twig:bs:button>

{# Link button #}
<twig:bs:button variant="primary" href="/dashboard">Dashboard</twig:bs:button>

{# With tooltip #}
<twig:bs:button variant="info" tooltip="Click for more information">
  Info
</twig:bs:button>
```

## References

- [Bootstrap 5.3 Buttons Documentation](https://getbootstrap.com/docs/5.3/components/buttons/)
