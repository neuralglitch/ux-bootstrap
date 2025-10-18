# Breadcrumbs Component

The `bs:breadcrumbs` component provides automatic breadcrumb navigation generation with auto-collapse support based on Bootstrap 5.3.

## Basic Usage

```twig
{# Auto-generated breadcrumbs #}
<twig:bs:breadcrumbs />

{# Manual breadcrumbs #}
<twig:bs:breadcrumbs :items="[
  {label: 'Home', url: '/'},
  {label: 'Products', url: '/products'},
  {label: 'Category', url: null, active: true}
]" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | `?array` | `null` | Manual breadcrumb items array |
| `autoGenerate` | `bool` | `true` | Auto-generate from current route |
| `showHome` | `bool` | `true` | Include home link |
| `homeLabel` | `?string` | `'Home'` | Home link text |
| `homeRoute` | `?string` | `'default'` | Home route name |
| `homeRouteParams` | `?array` | `[]` | Home route parameters |
| `divider` | `string` | `'/'` | Breadcrumb divider character |
| `autoCollapse` | `bool` | `false` | Enable collapse for long breadcrumbs |
| `collapseThreshold` | `int` | `4` | Number of items before collapse |
| `stimulusController` | `string` | `'bs-breadcrumbs'` | Stimulus controller |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Custom divider #}
<twig:bs:breadcrumbs divider=">" />

{# With auto-collapse #}
<twig:bs:breadcrumbs :autoCollapse="true" :collapseThreshold="3" />

{# Disable home link #}
<twig:bs:breadcrumbs :showHome="false" />
```

## References

- [Bootstrap 5.3 Breadcrumb Documentation](https://getbootstrap.com/docs/5.3/components/breadcrumb/)
