# Feature Grid Component

The `bs:feature-grid` component provides a flexible grid layout for displaying features with icons and descriptions on landing pages.

## Basic Usage

```twig
{# Simple feature grid #}
<twig:bs:feature-grid
  heading="Our Features"
  subheading="Discover what makes us special"
  :features="[
    {
      icon: '<i class=\"bi bi-star\"></i>',
      title: 'Fast Performance',
      description: 'Lightning-fast load times and optimized code',
      variant: 'primary'
    },
    {
      icon: '<i class=\"bi bi-shield-check\"></i>',
      title: 'Secure',
      description: 'Enterprise-grade security built in',
      variant: 'success'
    },
    {
      icon: '<i class=\"bi bi-gear\"></i>',
      title: 'Customizable',
      description: 'Fully configurable to match your needs',
      variant: 'info'
    }
  ]" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `columns` | `int` | `3` | Number of columns: `2`, `3`, `4`, or `6` |
| `gap` | `string` | `'4'` | Gap between items (`'1'` to `'5'`) |
| `container` | `string` | `'container'` | Container type: `'container'`, `'container-fluid'`, `'container-lg'`, etc. |
| `variant` | `string` | `'default'` | Icon style variant: `'default'`, `'icon-lg'`, `'icon-box'`, `'icon-colored'`, `'bordered'`, `'shadow'` |
| `align` | `string` | `'start'` | Content alignment: `'start'`, `'center'`, `'end'` |
| `centered` | `bool` | `false` | Center all content (overrides `align`) |
| `features` | `array` | `[]` | Array of feature objects |
| `heading` | `?string` | `null` | Optional grid heading |
| `subheading` | `?string` | `null` | Optional grid subheading |
| `headingTag` | `string` | `'h2'` | HTML tag for heading |
| `headingAlign` | `string` | `'center'` | Heading alignment: `'start'`, `'center'`, `'end'` |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Feature Object Structure

Each feature in the `features` array can have:

```php
[
    'icon' => '<i class="bi bi-star"></i>',    // Icon HTML
    'title' => 'Feature Title',                // Required
    'description' => 'Feature description',    // Optional
    'variant' => 'primary',                    // Bootstrap color variant
    'link' => '/learn-more',                   // Optional link URL
    'linkText' => 'Learn more'                 // Optional link text
]
```

## Variants

### 1. Default

Simple icons with no background.

```twig
<twig:bs:feature-grid
  variant="default"
  :features="features" />
```

### 2. Icon Large

Larger icons for emphasis.

```twig
<twig:bs:feature-grid
  variant="icon-lg"
  :features="features" />
```

### 3. Icon Box

Icons in colored boxes with gradient backgrounds.

```twig
<twig:bs:feature-grid
  variant="icon-box"
  :features="features" />
```

### 4. Icon Colored

Colored icons without backgrounds.

```twig
<twig:bs:feature-grid
  variant="icon-colored"
  :features="features" />
```

### 5. Bordered

Icons with circular borders.

```twig
<twig:bs:feature-grid
  variant="bordered"
  :features="features" />
```

### 6. Shadow

Icons in light circles with shadow effects.

```twig
<twig:bs:feature-grid
  variant="shadow"
  :features="features" />
```

## Column Layouts

### 2 Columns

```twig
<twig:bs:feature-grid
  :columns="2"
  :features="features" />
```

Responsive: `col-md-6` (2 columns on medium screens and up)

### 3 Columns (Default)

```twig
<twig:bs:feature-grid
  :columns="3"
  :features="features" />
```

Responsive: `col-md-4` (3 columns on medium screens and up)

### 4 Columns

```twig
<twig:bs:feature-grid
  :columns="4"
  :features="features" />
```

Responsive: `col-md-6 col-lg-3` (2 columns on medium, 4 on large)

### 6 Columns

```twig
<twig:bs:feature-grid
  :columns="6"
  :features="features" />
```

Responsive: `col-sm-6 col-md-4 col-lg-2` (responsive multi-column layout)

## Examples

### Basic Feature Grid

```twig
<twig:bs:feature-grid
  heading="Why Choose Us"
  :features="[
    {
      icon: '<i class=\"bi bi-lightning\"></i>',
      title: 'Fast',
      description: 'Optimized for speed',
      variant: 'warning'
    },
    {
      icon: '<i class=\"bi bi-shield\"></i>',
      title: 'Secure',
      description: 'Bank-level security',
      variant: 'success'
    },
    {
      icon: '<i class=\"bi bi-heart\"></i>',
      title: 'Reliable',
      description: '99.9% uptime',
      variant: 'danger'
    }
  ]" />
```

### With Links

```twig
<twig:bs:feature-grid
  heading="Explore Our Features"
  :features="[
    {
      icon: '<i class=\"bi bi-graph-up\"></i>',
      title: 'Analytics',
      description: 'Track your performance',
      variant: 'primary',
      link: '/features/analytics',
      linkText: 'Learn more'
    },
    {
      icon: '<i class=\"bi bi-people\"></i>',
      title: 'Team Collaboration',
      description: 'Work together seamlessly',
      variant: 'info',
      link: '/features/collaboration',
      linkText: 'Learn more'
    }
  ]" />
```

### Centered Layout

```twig
<twig:bs:feature-grid
  heading="Core Features"
  :centered="true"
  variant="icon-box"
  :features="features" />
```

### 4-Column Layout with Custom Gap

```twig
<twig:bs:feature-grid
  :columns="4"
  gap="5"
  variant="bordered"
  :features="features" />
```

### Full-Width Container

```twig
<twig:bs:feature-grid
  container="container-fluid"
  :features="features" />
```

### Icon-Box Variant with Large Gap

```twig
<twig:bs:feature-grid
  heading="Premium Features"
  subheading="Everything you need to succeed"
  variant="icon-box"
  :columns="3"
  gap="5"
  :features="[
    {
      icon: '🚀',
      title: 'Launch Fast',
      description: 'Deploy in minutes, not hours',
      variant: 'primary'
    },
    {
      icon: '📊',
      title: 'Track Everything',
      description: 'Comprehensive analytics dashboard',
      variant: 'success'
    },
    {
      icon: '🔒',
      title: 'Stay Secure',
      description: 'Enterprise-grade encryption',
      variant: 'danger'
    }
  ]" />
```

### Custom Content (Advanced)

For complete customization, use the content block:

```twig
<twig:bs:feature-grid heading="Custom Features">
  {% block content %}
    <div class="col-md-4">
      <div class="feature-item text-center">
        <i class="bi bi-star text-warning" style="font-size: 3rem;"></i>
        <h3 class="h5 fw-bold mb-2 mt-3">Custom Feature</h3>
        <p class="text-muted">Your own HTML structure</p>
      </div>
    </div>
    <div class="col-md-4">
      {# More custom features #}
    </div>
  {% endblock %}
</twig:bs:feature-grid>
```

## Accessibility

- Each feature should have descriptive titles
- Use semantic HTML headings
- Icons should be decorative (ARIA hidden) or have proper labels
- Ensure adequate color contrast for text
- Links should have descriptive text

```twig
<twig:bs:feature-grid
  :features="[
    {
      icon: '<i class=\"bi bi-star\" aria-hidden=\"true\"></i>',
      title: 'Accessible Feature',
      description: 'Clear, descriptive text for all users'
    }
  ]" />
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  feature_grid:
    columns: 3
    gap: '4'
    container: 'container'
    variant: 'default'
    align: 'start'
    centered: false
    heading_tag: 'h2'
    heading_align: 'center'
    class: null
    attr: {}
```

## Testing

```php
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\FeatureGrid;

$component = new FeatureGrid($config);
$component->columns = 4;
$component->variant = 'icon-box';
$component->features = [
    [
        'icon' => '<i class="bi bi-check"></i>',
        'title' => 'Feature',
        'description' => 'Description',
        'variant' => 'success',
    ],
];
$component->mount();
$options = $component->options();

// Assertions
$this->assertSame(4, $options['columns']);
$this->assertSame('icon-box', $options['variant']);
$this->assertCount(1, $options['features']);
```

## Best Practices

1. **Keep descriptions concise** - 1-2 sentences max
2. **Use consistent icons** - Choose one icon family (e.g., Bootstrap Icons)
3. **Limit features** - 3-6 features work best for readability
4. **Choose appropriate variants** - Match your brand/design system
5. **Provide fallbacks** - Ensure icons degrade gracefully
6. **Use semantic colors** - Match variants to meaning (success = green, etc.)
7. **Test responsiveness** - Check all breakpoints

## Related Components

- `bs:hero` - Hero sections for landing pages
- `bs:card` - Content cards
- `bs:stat` - KPIs and metrics display
- `bs:icon` - Icon components

## References

- [Bootstrap 5.3 Grid System](https://getbootstrap.com/docs/5.3/layout/grid/)
- [Bootstrap 5.3 Utilities](https://getbootstrap.com/docs/5.3/utilities/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

