# Comparison Table Component

The `bs:comparison-table` component provides feature comparison tables for pricing pages, product comparisons, and plan comparisons with multiple layout variants and responsive design.

## Basic Usage

```twig
{# Simple comparison table #}
<twig:bs:comparison-table
  title="Compare Plans"
  description="Choose the perfect plan for your needs"
  :columns="[
    {title: 'Free', price: '$0', period: 'month'},
    {title: 'Pro', price: '$29', period: 'month', badge: 'Popular', badge_variant: 'primary'},
    {title: 'Enterprise', price: '$99', period: 'month'}
  ]"
  :features="[
    {feature: 'Users', values: ['1', '10', 'Unlimited']},
    {feature: 'Storage', values: ['10GB', '100GB', '1TB']},
    {feature: 'Support', values: [true, true, true]},
    {feature: 'Advanced Analytics', values: [false, true, true]}
  ]" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'default'` | Layout variant: `'default'`, `'bordered'`, `'striped'`, `'cards'`, `'horizontal'` |
| `responsive` | `bool` | `true` | Enable responsive table wrapper |
| `container` | `string` | `'container'` | Container type: `'container'`, `'container-fluid'`, `'container-{breakpoint}'` |
| `columns` | `array` | `[]` | Array of column/product objects with title, price, etc. |
| `highlightColumn` | `int` | `-1` | Index of column to highlight (-1 = none) |
| `features` | `array` | `[]` | Array of feature objects with feature name and values |
| `showCheckmarks` | `bool` | `true` | Use checkmarks for boolean values |
| `checkIcon` | `?string` | `'✓'` | Icon for checked/true values |
| `uncheckIcon` | `?string` | `'✗'` | Icon for unchecked/false values |
| `sticky` | `bool` | `false` | Sticky header on scroll |
| `centered` | `bool` | `true` | Center-align values in cells |
| `hover` | `bool` | `true` | Hover effect on rows |
| `emptyText` | `?string` | `'—'` | Text for empty/null values |
| `title` | `?string` | `null` | Table title |
| `description` | `?string` | `null` | Table description |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Column Object Structure

```twig
{
  title: 'Plan Name',          // Required: Column/plan title
  price: '$29',                // Optional: Price to display
  period: 'month',             // Optional: Billing period
  badge: 'Popular',            // Optional: Badge text
  badge_variant: 'primary',    // Optional: Badge color variant
  variant: 'primary',          // Optional: Column header color
  cta_label: 'Get Started',    // Optional: CTA button text
  cta_href: '/signup',         // Optional: CTA button URL
  cta_variant: 'primary'       // Optional: CTA button variant
}
```

## Feature Object Structure

```twig
{
  feature: 'Feature Name',     // Required: Feature label
  values: [...],               // Required: Array of values (one per column)
  description: 'Details'       // Optional: Feature description/tooltip
}
```

## Variants

### 1. Default (Table)
Standard vertical table layout with features as rows.

```twig
<twig:bs:comparison-table
  variant="default"
  :columns="[
    {title: 'Basic', price: '$9', period: 'month'},
    {title: 'Pro', price: '$29', period: 'month', badge: 'Best Value'},
    {title: 'Enterprise', price: '$99', period: 'month'}
  ]"
  :features="[
    {feature: 'Projects', values: ['3', '10', 'Unlimited']},
    {feature: 'Team Members', values: ['1', '5', 'Unlimited']},
    {feature: 'Priority Support', values: [false, true, true]}
  ]" />
```

### 2. Bordered
Table with visible borders around all cells.

```twig
<twig:bs:comparison-table
  variant="bordered"
  :columns="[...]"
  :features="[...]" />
```

### 3. Striped
Table with alternating row colors for better readability.

```twig
<twig:bs:comparison-table
  variant="striped"
  :columns="[...]"
  :features="[...]" />
```

### 4. Cards (Mobile-Friendly)
Displays each plan as a card on smaller screens.

```twig
<twig:bs:comparison-table
  variant="cards"
  :columns="[
    {
      title: 'Starter',
      price: '$19',
      period: 'month',
      variant: 'primary',
      cta_label: 'Start Free Trial',
      cta_href: '/signup',
      cta_variant: 'primary'
    },
    {
      title: 'Business',
      price: '$49',
      period: 'month',
      badge: 'Popular',
      badge_variant: 'warning',
      variant: 'success',
      cta_label: 'Get Started',
      cta_href: '/signup',
      cta_variant: 'success'
    }
  ]"
  :features="[
    {feature: 'Users', values: ['5', '25']},
    {feature: 'Storage', values: ['50GB', '500GB']},
    {feature: 'API Access', values: [true, true]}
  ]" />
```

### 5. Horizontal
Features as columns, products as rows (inverted layout).

```twig
<twig:bs:comparison-table
  variant="horizontal"
  :columns="[...]"
  :features="[...]" />
```

## Advanced Features

### Highlighted Column
Emphasize a recommended plan with highlighting.

```twig
<twig:bs:comparison-table
  :highlightColumn="1"  {# Zero-indexed, highlights second column #}
  :columns="[
    {title: 'Basic', price: '$9'},
    {title: 'Pro', price: '$29', badge: 'Recommended'},
    {title: 'Enterprise', price: '$99'}
  ]"
  :features="[...]" />
```

### Custom Checkmarks
Customize the icons for boolean values.

```twig
<twig:bs:comparison-table
  :showCheckmarks="true"
  checkIcon="✔️"
  uncheckIcon="❌"
  :columns="[...]"
  :features="[
    {feature: 'Feature A', values: [true, true, false]},
    {feature: 'Feature B', values: [false, true, true]}
  ]" />
```

### Sticky Header
Keep the header visible when scrolling.

```twig
<twig:bs:comparison-table
  :sticky="true"
  :columns="[...]"
  :features="[...]" />
```

### Call-to-Action Buttons
Add CTA buttons for each plan.

```twig
<twig:bs:comparison-table
  :columns="[
    {
      title: 'Free',
      price: '$0',
      cta_label: 'Start Free',
      cta_href: '/signup/free',
      cta_variant: 'outline-primary'
    },
    {
      title: 'Pro',
      price: '$29',
      cta_label: 'Start Trial',
      cta_href: '/signup/pro',
      cta_variant: 'primary'
    }
  ]"
  :features="[...]" />
```

## Complete Example

```twig
<twig:bs:comparison-table
  title="Choose Your Plan"
  description="All plans include 14-day free trial"
  variant="striped"
  :highlightColumn="1"
  :sticky="true"
  :centered="true"
  :hover="true"
  container="container"
  :columns="[
    {
      title: 'Starter',
      price: '$19',
      period: 'month',
      cta_label: 'Start Free Trial',
      cta_href: '/signup/starter',
      cta_variant: 'outline-primary'
    },
    {
      title: 'Professional',
      price: '$49',
      period: 'month',
      badge: 'Most Popular',
      badge_variant: 'primary',
      cta_label: 'Get Started',
      cta_href: '/signup/pro',
      cta_variant: 'primary'
    },
    {
      title: 'Enterprise',
      price: '$99',
      period: 'month',
      cta_label: 'Contact Sales',
      cta_href: '/contact',
      cta_variant: 'outline-primary'
    }
  ]"
  :features="[
    {
      feature: 'Team Members',
      values: ['5', '25', 'Unlimited'],
      description: 'Number of users per account'
    },
    {
      feature: 'Storage',
      values: ['50GB', '500GB', '5TB']
    },
    {
      feature: 'Projects',
      values: ['10', '100', 'Unlimited']
    },
    {
      feature: 'API Access',
      values: [true, true, true]
    },
    {
      feature: 'Advanced Analytics',
      values: [false, true, true]
    },
    {
      feature: 'Priority Support',
      values: [false, true, true]
    },
    {
      feature: 'Custom Integrations',
      values: [false, false, true]
    },
    {
      feature: 'Dedicated Account Manager',
      values: [false, false, true]
    }
  ]"
  class="my-5"
  :attr="{id: 'pricing-comparison'}" />
```

## Accessibility

- Uses semantic `<table>`, `<thead>`, `<tbody>` elements
- Proper `scope` attributes on headers (`scope="col"` and `scope="row"`)
- Checkmarks include color and symbol for colorblind users
- Responsive design ensures usability on all devices
- Proper heading hierarchy for screen readers

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  comparison_table:
    variant: 'default'
    responsive: true
    container: 'container'
    highlight_column: -1
    show_checkmarks: true
    check_icon: '✓'
    uncheck_icon: '✗'
    empty_text: '—'
    sticky: false
    centered: true
    hover: true
    class: null
    attr: {}
```

## Testing

```php
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\ComparisonTable;

$table = new ComparisonTable($config);
$table->variant = 'striped';
$table->columns = [
    ['title' => 'Free', 'price' => '$0'],
    ['title' => 'Pro', 'price' => '$10']
];
$table->features = [
    ['feature' => 'Storage', 'values' => ['10GB', '100GB']]
];
$table->highlightColumn = 1;
$table->mount();

$options = $table->options();
// Test assertions...
```

## Related Components

- [Pricing Card](pricing_card_component.md) - Individual pricing cards
- [Card](../card_component.md) - Base card component
- [Button](../button_component.md) - CTA buttons

## References

- [Bootstrap Tables](https://getbootstrap.com/docs/5.3/content/tables/)
- [Bootstrap Utilities](https://getbootstrap.com/docs/5.3/utilities/)

