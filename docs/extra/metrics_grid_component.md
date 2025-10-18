# Metrics Grid Component

## Overview

The **Metrics Grid** component (`bs:metrics-grid`) is an enhanced Extra component designed to display multiple metrics or KPIs in a responsive grid layout. It extends the functionality of the individual `bs:stat` component by providing a structured grid container with optional sparkline visualizations for each metric.

**Key Features:**
- Responsive grid layout (1-6 columns)
- Support for multiple metrics with consistent styling
- Optional inline sparkline charts for trend visualization
- Flexible configuration for icons, trends, and descriptions
- Equal height cards for uniform appearance
- Full responsive control over breakpoints

**Component Type:** Extra Component  
**Tag:** `<twig:bs:metrics-grid />`  
**Namespace:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra`

---

## Basic Usage

### Simple Metrics Grid

```twig
<twig:bs:metrics-grid
    :columns="4"
    :metrics="[
        {
            value: '1,234',
            label: 'Total Users',
            variant: 'primary'
        },
        {
            value: '567',
            label: 'Active Sessions',
            variant: 'success'
        },
        {
            value: '89',
            label: 'Pending Tasks',
            variant: 'warning'
        },
        {
            value: '$12,345',
            label: 'Revenue',
            variant: 'info'
        }
    ]"
/>
```

### With Trends and Changes

```twig
<twig:bs:metrics-grid
    :columns="3"
    :metrics="[
        {
            value: '2,456',
            label: 'Sales',
            variant: 'success',
            trend: 'up',
            change: '+12%',
            icon: '💰'
        },
        {
            value: '98%',
            label: 'Uptime',
            variant: 'primary',
            trend: 'neutral',
            change: '±0%',
            icon: '⚡'
        },
        {
            value: '34',
            label: 'Issues',
            variant: 'danger',
            trend: 'down',
            change: '-8%',
            icon: '🐛'
        }
    ]"
/>
```

### With Sparklines

```twig
<twig:bs:metrics-grid
    :columns="4"
    :showSparklines="true"
    sparklineColor="primary"
    :sparklineHeight="40"
    :metrics="[
        {
            value: '1,234',
            label: 'Total Users',
            variant: 'primary',
            sparkline: [100, 150, 120, 180, 200, 190, 220]
        },
        {
            value: '567',
            label: 'Active Sessions',
            variant: 'success',
            sparkline: [50, 60, 55, 70, 80, 75, 85]
        },
        {
            value: '$12,345',
            label: 'Revenue',
            variant: 'info',
            sparkline: [1000, 1200, 1100, 1500, 1600, 1400, 1700]
        },
        {
            value: '89%',
            label: 'Performance',
            variant: 'warning',
            sparkline: [85, 87, 84, 88, 90, 89, 92]
        }
    ]"
/>
```

---

## Component Props

### Grid Layout Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `columns` | `int` | `4` | Number of columns in desktop view (1-6) |
| `gap` | `string` | `'4'` | Bootstrap gap spacing between cards (0-5) |
| `equalHeight` | `bool` | `true` | Make all cards equal height using `h-100` |

### Metrics Data Prop

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `metrics` | `array` | `[]` | Array of metric objects (see Metric Object Structure below) |

### Global Styling Props

Applied to all metric cards:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `cardVariant` | `string\|null` | `null` | Bootstrap color variant for card borders |
| `cardBorder` | `bool` | `false` | Show card border |
| `cardShadow` | `bool` | `false` | Add shadow to cards |
| `size` | `string\|null` | `'default'` | Card size: `'sm'`, `'default'`, `'lg'` |
| `textAlign` | `string\|null` | `'start'` | Text alignment: `'start'`, `'center'`, `'end'` |

### Sparkline Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showSparklines` | `bool` | `false` | Enable sparkline charts for metrics |
| `sparklineColor` | `string` | `'primary'` | Bootstrap color for sparkline stroke |
| `sparklineHeight` | `int` | `40` | Height of sparkline in pixels |

### Responsive Columns Props

Override column count at specific breakpoints:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `columnsSm` | `int\|null` | `null` | Columns for small devices (≥576px) |
| `columnsMd` | `int\|null` | `null` | Columns for medium devices (≥768px), defaults to 2 |
| `columnsLg` | `int\|null` | `null` | Columns for large devices (≥992px), defaults to `columns` |
| `columnsXl` | `int\|null` | `null` | Columns for extra large devices (≥1200px) |
| `columnsXxl` | `int\|null` | `null` | Columns for extra extra large devices (≥1400px) |

### Standard Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `string\|null` | `null` | Additional CSS classes for container |
| `attr` | `array` | `[]` | Additional HTML attributes for container |

---

## Metric Object Structure

Each item in the `metrics` array should be an associative array with the following keys:

```php
[
    'value'        => string|int|float,  // Required: The metric value
    'label'        => string,             // Required: The metric label
    'variant'      => string|null,        // Optional: Bootstrap color variant
    'icon'         => string|null,        // Optional: Icon/emoji HTML
    'iconPosition' => string,             // Optional: 'start', 'end', 'top' (default: 'start')
    'trend'        => string|null,        // Optional: 'up', 'down', 'neutral'
    'change'       => string|null,        // Optional: Change text (e.g., '+12%')
    'description'  => string|null,        // Optional: Additional description text
    'sparkline'    => array|null,         // Optional: Array of numeric values for sparkline
]
```

### Metric Properties

- **`value`** (required): The primary value to display (can be formatted string like `'1,234'` or `'$12,345'`)
- **`label`** (required): The label/description of the metric
- **`variant`**: Bootstrap color variant (`'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`)
- **`icon`**: HTML or emoji to display as an icon
- **`iconPosition`**: Where to position the icon relative to the value
- **`trend`**: Trend direction (`'up'` = green ↑, `'down'` = red ↓, `'neutral'` = gray →)
- **`change`**: Percentage or numeric change to display with trend
- **`description`**: Additional descriptive text below the label
- **`sparkline`**: Array of numeric values to create an inline chart (requires `showSparklines="true"`)

---

## Examples

### Dashboard KPIs

```twig
<twig:bs:metrics-grid
    :columns="4"
    gap="3"
    :cardShadow="true"
    :metrics="[
        {
            value: '12,345',
            label: 'Total Revenue',
            variant: 'success',
            icon: '💰',
            trend: 'up',
            change: '+15.3%',
            description: 'vs last month'
        },
        {
            value: '1,234',
            label: 'New Customers',
            variant: 'primary',
            icon: '👥',
            trend: 'up',
            change: '+8.2%'
        },
        {
            value: '567',
            label: 'Active Orders',
            variant: 'info',
            icon: '📦',
            trend: 'neutral',
            change: '±0%'
        },
        {
            value: '23',
            label: 'Support Tickets',
            variant: 'warning',
            icon: '🎫',
            trend: 'down',
            change: '-12%'
        }
    ]"
/>
```

### Analytics Dashboard with Sparklines

```twig
<twig:bs:metrics-grid
    :columns="3"
    gap="4"
    :showSparklines="true"
    sparklineColor="primary"
    :sparklineHeight="50"
    size="lg"
    :cardBorder="true"
    :metrics="[
        {
            value: '45,231',
            label: 'Page Views',
            variant: 'primary',
            sparkline: [3000, 3500, 3200, 4000, 4200, 3800, 4500],
            trend: 'up',
            change: '+23%'
        },
        {
            value: '2,345',
            label: 'Unique Visitors',
            variant: 'success',
            sparkline: [200, 250, 220, 280, 300, 270, 320],
            trend: 'up',
            change: '+18%'
        },
        {
            value: '3:45',
            label: 'Avg. Session Duration',
            variant: 'info',
            sparkline: [180, 200, 190, 220, 240, 210, 225],
            trend: 'up',
            change: '+12%'
        }
    ]"
/>
```

### Responsive Grid

```twig
<twig:bs:metrics-grid
    :columns="4"
    :columnsSm="2"
    :columnsMd="3"
    :columnsLg="4"
    :columnsXl="6"
    gap="3"
    :metrics="metricsData"
/>
```

### Compact View

```twig
<twig:bs:metrics-grid
    :columns="6"
    gap="2"
    size="sm"
    :metrics="[
        {value: '234', label: 'Users', variant: 'primary'},
        {value: '567', label: 'Sessions', variant: 'success'},
        {value: '89', label: 'Errors', variant: 'danger'},
        {value: '12', label: 'Warnings', variant: 'warning'},
        {value: '456', label: 'Events', variant: 'info'},
        {value: '78%', label: 'Success', variant: 'secondary'}
    ]"
/>
```

### Centered Display

```twig
<twig:bs:metrics-grid
    :columns="3"
    textAlign="center"
    :cardShadow="true"
    :equalHeight="true"
    :metrics="[
        {
            value: '99.9%',
            label: 'Uptime',
            variant: 'success',
            icon: '✅',
            iconPosition: 'top',
            description: 'Last 30 days'
        },
        {
            value: '< 100ms',
            label: 'Response Time',
            variant: 'primary',
            icon: '⚡',
            iconPosition: 'top',
            description: 'Average'
        },
        {
            value: '0',
            label: 'Critical Issues',
            variant: 'success',
            icon: '🎯',
            iconPosition: 'top',
            description: 'All time low'
        }
    ]"
/>
```

---

## Accessibility

The Metrics Grid component follows accessibility best practices:

1. **Semantic HTML**: Uses proper `<div>` structure with Bootstrap's card components
2. **Readable Values**: Metric values are presented as plain text for screen readers
3. **Color Independence**: Trends use both color and symbols (↑, ↓, →) to convey information
4. **Responsive Design**: Adapts to different screen sizes for better usability
5. **ARIA Attributes**: Custom attributes can be added via the `attr` prop

### Recommended Practices

```twig
<twig:bs:metrics-grid
    :columns="4"
    :attr="{
        'role': 'region',
        'aria-label': 'Dashboard Metrics'
    }"
    :metrics="metricsData"
/>
```

---

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  metrics_grid:
    # Grid layout
    columns: 4                    # Number of columns in desktop view (1-6)
    gap: '4'                      # Bootstrap gap spacing (0-5)
    equal_height: true            # Make all cards equal height
    
    # Global card styling (applied to all metrics)
    card_variant: null            # null | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info'
    card_border: false
    card_shadow: false
    size: 'default'               # 'sm' | 'default' | 'lg'
    text_align: 'start'           # 'start' | 'center' | 'end'
    
    # Sparklines
    show_sparklines: false
    sparkline_color: 'primary'
    sparkline_height: 40
    
    # Responsive columns (optional)
    columns_sm: null              # Small devices (≥576px)
    columns_md: null              # Medium devices (≥768px) - defaults to 2
    columns_lg: null              # Large devices (≥992px) - defaults to 'columns' value
    columns_xl: null              # Extra large devices (≥1200px)
    columns_xxl: null             # Extra extra large devices (≥1400px)
    
    class: null
    attr: {  }
```

### Customization Example

```yaml
neuralglitch_ux_bootstrap:
  metrics_grid:
    columns: 3
    gap: '5'
    card_shadow: true
    show_sparklines: true
    sparkline_color: 'success'
```

---

## Testing

### Unit Tests

The component includes comprehensive unit tests covering:

- Default options and configuration
- Grid column calculations (1-6 columns)
- Responsive breakpoint handling
- Metric data processing
- Trend indicators and icons
- Sparkline data processing
- Custom classes and attributes
- Edge cases (empty metrics, invalid columns)

### Running Tests

```bash
# Run all metrics grid tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/MetricsGridTest.php

# Run specific test
bin/php-in-docker vendor/bin/phpunit --filter testMetricsDataProcessing
```

### Test Coverage

The component maintains ≥80% code coverage as required by project guidelines.

---

## Related Components

- **`bs:stat`**: Individual statistic component (used as a reference for metric styling)
- **`bs:card`**: Bootstrap card component (used internally for each metric)
- **`bs:badge`**: Used for trend indicators

---

## Advanced Usage

### Dynamic Metrics from Controller

```php
// In your Symfony controller
public function dashboard(): Response
{
    $metrics = [
        [
            'value' => $this->statsService->getTotalUsers(),
            'label' => 'Total Users',
            'variant' => 'primary',
            'trend' => 'up',
            'change' => '+' . $this->statsService->getUserGrowth() . '%',
        ],
        // ... more metrics
    ];
    
    return $this->render('dashboard/index.html.twig', [
        'metrics' => $metrics,
    ]);
}
```

```twig
{# In your template #}
<twig:bs:metrics-grid
    :columns="4"
    :metrics="metrics"
    :showSparklines="true"
/>
```

### Custom Styling

```twig
<twig:bs:metrics-grid
    :columns="4"
    class="my-custom-metrics"
    :attr="{
        'data-controller': 'metrics',
        'data-metrics-refresh-url': '/api/metrics'
    }"
    :metrics="metricsData"
/>
```

---

## Browser Support

The Metrics Grid component is compatible with all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

**Note:** Sparklines use inline SVG, which is supported in all modern browsers.

---

## Performance Considerations

1. **Metric Count**: While the component can handle any number of metrics, consider pagination or filtering for large datasets (>50 metrics)
2. **Sparklines**: Sparkline rendering is client-side and performant, but avoid very large arrays (>100 data points per sparkline)
3. **Responsive Images**: When using custom icons, ensure they are optimized for web
4. **CSS Grid**: The component uses Bootstrap's grid system for optimal performance

---

## References

- [Bootstrap 5.3 Grid System](https://getbootstrap.com/docs/5.3/layout/grid/)
- [Bootstrap 5.3 Cards](https://getbootstrap.com/docs/5.3/components/card/)
- [Bootstrap 5.3 Badges](https://getbootstrap.com/docs/5.3/components/badge/)
- [Symfony UX TwigComponent](https://symfony.com/bundles/ux-twig-component/current/index.html)

---

## Changelog

### v1.0.0 (Unreleased)
- Initial release
- Support for responsive grid layouts
- Trend indicators with icons
- Optional sparkline visualizations
- Full configuration support
- Comprehensive test coverage

