# Stat Component

## Overview

The **Stat** component (`bs:stat`) is an Extra component designed to display statistics, KPIs (Key Performance Indicators), metrics, and analytics data in a visually appealing card format. Perfect for dashboards, admin panels, and analytics displays.

**Component Type**: Extra (Custom feature component)  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag**: `<twig:bs:stat>`

## Basic Usage

### Simple Stat

```twig
<twig:bs:stat
    value="1,250"
    label="Total Users"
/>
```

### Stat with Variant

```twig
<twig:bs:stat
    value="$52,430"
    label="Total Revenue"
    variant="success"
/>
```

### Stat with Trend

```twig
<twig:bs:stat
    value="98.7%"
    label="Customer Satisfaction"
    variant="primary"
    trend="up"
    change="+5.2%"
/>
```

### Stat with Icon

```twig
<twig:bs:stat
    value="342"
    label="New Orders"
    variant="info"
    icon="📦"
    trend="up"
    change="+12%"
    description="vs. last week"
/>
```

## Component Props

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `value` | `string\|int\|float` | `'0'` | The main statistic value to display |
| `label` | `string` | `'Statistic'` | Label describing what the statistic represents |
| `variant` | `?string` | `null` | Bootstrap color variant (`primary`, `success`, `danger`, etc.) |
| `icon` | `?string` | `null` | Icon HTML (emoji, SVG, or icon font markup) |
| `iconPosition` | `string` | `'start'` | Icon position: `'start'`, `'end'`, or `'top'` |
| `trend` | `?string` | `null` | Trend indicator: `'up'`, `'down'`, or `'neutral'` |
| `change` | `?string` | `null` | Change amount/percentage (e.g., `'+12%'`, `'-5%'`) |
| `description` | `?string` | `null` | Additional descriptive text below the label |
| `size` | `string` | `'default'` | Size: `'sm'`, `'default'`, or `'lg'` |
| `border` | `bool` | `false` | Add visible border to the card |
| `shadow` | `bool` | `false` | Add shadow effect to the card |
| `textAlign` | `string` | `'start'` | Text alignment: `'start'`, `'center'`, or `'end'` |
| `class` | `?string` | `null` | Additional CSS classes for the card |
| `attr` | `array` | `[]` | Additional HTML attributes for the card |

## Examples

### Dashboard Stats Row

```twig
<div class="row g-3">
    <div class="col-md-3">
        <twig:bs:stat
            value="2,547"
            label="Total Users"
            variant="primary"
            icon="👥"
            trend="up"
            change="+12%"
            description="vs. last month"
            :border="true"
        />
    </div>
    
    <div class="col-md-3">
        <twig:bs:stat
            value="$52,430"
            label="Revenue"
            variant="success"
            icon="💰"
            trend="up"
            change="+18.3%"
            description="vs. last month"
            :border="true"
        />
    </div>
    
    <div class="col-md-3">
        <twig:bs:stat
            value="342"
            label="New Orders"
            variant="info"
            icon="📦"
            trend="neutral"
            change="0%"
            description="vs. last month"
            :border="true"
        />
    </div>
    
    <div class="col-md-3">
        <twig:bs:stat
            value="23"
            label="Support Tickets"
            variant="warning"
            icon="🎫"
            trend="down"
            change="-5%"
            description="vs. last month"
            :border="true"
        />
    </div>
</div>
```

### Large Stat Card

```twig
<twig:bs:stat
    value="98.7%"
    label="Uptime"
    variant="success"
    icon="⚡"
    iconPosition="top"
    size="lg"
    textAlign="center"
    :border="true"
    :shadow="true"
    description="Last 30 days"
/>
```

### Small Stats in Sidebar

```twig
<twig:bs:stat
    value="145"
    label="Active Sessions"
    variant="info"
    size="sm"
    icon="🌐"
/>

<twig:bs:stat
    value="23"
    label="Pending Tasks"
    variant="warning"
    size="sm"
    icon="✓"
/>
```

### Stat with Custom Icon (SVG)

```twig
<twig:bs:stat
    value="12.4K"
    label="Downloads"
    variant="primary"
    icon='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>'
    trend="up"
    change="+25%"
/>
```

### Analytics Dashboard

```twig
<div class="container-fluid py-4">
    <h2 class="mb-4">Analytics Overview</h2>
    
    <div class="row g-4">
        {# Page Views #}
        <div class="col-lg-3 col-md-6">
            <twig:bs:stat
                value="45.2K"
                label="Page Views"
                variant="primary"
                icon="👁️"
                trend="up"
                change="+15.3%"
                description="Last 7 days"
                :shadow="true"
            />
        </div>
        
        {# Unique Visitors #}
        <div class="col-lg-3 col-md-6">
            <twig:bs:stat
                value="12.8K"
                label="Unique Visitors"
                variant="success"
                icon="👤"
                trend="up"
                change="+8.7%"
                description="Last 7 days"
                :shadow="true"
            />
        </div>
        
        {# Bounce Rate #}
        <div class="col-lg-3 col-md-6">
            <twig:bs:stat
                value="42.3%"
                label="Bounce Rate"
                variant="warning"
                icon="↩️"
                trend="down"
                change="-3.2%"
                description="Last 7 days"
                :shadow="true"
            />
        </div>
        
        {# Avg. Session Duration #}
        <div class="col-lg-3 col-md-6">
            <twig:bs:stat
                value="3m 24s"
                label="Avg. Session"
                variant="info"
                icon="⏱️"
                trend="up"
                change="+12s"
                description="Last 7 days"
                :shadow="true"
            />
        </div>
    </div>
</div>
```

### Icon Positions

```twig
{# Icon at start (default) #}
<twig:bs:stat
    value="1,250"
    label="Total Items"
    icon="📊"
    iconPosition="start"
/>

{# Icon at end #}
<twig:bs:stat
    value="1,250"
    label="Total Items"
    icon="📊"
    iconPosition="end"
/>

{# Icon at top (centered layout) #}
<twig:bs:stat
    value="1,250"
    label="Total Items"
    icon="📊"
    iconPosition="top"
    textAlign="center"
/>
```

### Size Variations

```twig
{# Small #}
<twig:bs:stat
    value="42"
    label="Notifications"
    size="sm"
/>

{# Default #}
<twig:bs:stat
    value="1,250"
    label="Total Users"
    size="default"
/>

{# Large #}
<twig:bs:stat
    value="$52K"
    label="Revenue"
    size="lg"
/>
```

### Trend Indicators

```twig
{# Positive trend (green) #}
<twig:bs:stat
    value="$52,430"
    label="Revenue"
    trend="up"
    change="+18.3%"
/>

{# Negative trend (red) #}
<twig:bs:stat
    value="23"
    label="Issues"
    trend="down"
    change="-12%"
/>

{# Neutral trend (gray) #}
<twig:bs:stat
    value="342"
    label="Pending"
    trend="neutral"
    change="0%"
/>
```

### Text Alignment

```twig
{# Left aligned (default) #}
<twig:bs:stat
    value="1,250"
    label="Total Users"
    textAlign="start"
/>

{# Center aligned #}
<twig:bs:stat
    value="98.7%"
    label="Uptime"
    textAlign="center"
/>

{# Right aligned #}
<twig:bs:stat
    value="$52,430"
    label="Revenue"
    textAlign="end"
/>
```

### With Custom Classes and Attributes

```twig
<twig:bs:stat
    value="1,250"
    label="Total Users"
    variant="primary"
    class="my-custom-stat hover-lift"
    :attr="{
        'data-analytics': 'user-count',
        'id': 'stat-users',
        'data-refresh': '30000'
    }"
/>
```

## Variants

Available color variants:

- `primary` - Blue (default Bootstrap primary color)
- `secondary` - Gray
- `success` - Green
- `danger` - Red
- `warning` - Yellow/Orange
- `info` - Cyan
- `light` - Light gray
- `dark` - Dark gray

When a variant is set:
- The card border uses the variant color
- The value text uses the variant color
- The icon uses the variant color (if provided)

## Trend Indicators

The `trend` prop adds a colored badge next to the value:

| Trend | Icon | Badge Color | Use Case |
|-------|------|-------------|----------|
| `up` | ↑ | Success (green) | Positive growth, increases |
| `down` | ↓ | Danger (red) | Negative changes, decreases |
| `neutral` | → | Secondary (gray) | No significant change |

Combine with the `change` prop to show the exact change amount.

## Icon Support

The `icon` prop accepts:
- **Emojis**: `icon="📊"`
- **SVG markup**: `icon='<svg>...</svg>'`
- **Icon fonts**: `icon='<i class="bi bi-graph-up"></i>'`
- **Any HTML**: The content is rendered as-is with `|raw` filter

## Size Options

| Size | Description | Value Font Size | Use Case |
|------|-------------|----------------|----------|
| `sm` | Small | `fs-4` | Compact displays, sidebars |
| `default` | Default | `fs-2` | Standard dashboard stats |
| `lg` | Large | `fs-1` | Featured metrics, hero stats |

## Styling Customization

### Custom CSS

Add your own styles targeting the stat card:

```scss
.stat-card {
    transition: transform 0.2s, box-shadow 0.2s;
    
    &:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }
}

.stat-value {
    font-family: 'Roboto', sans-serif;
    letter-spacing: -0.5px;
}
```

### Custom Animations

```scss
@keyframes pulse-stat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

.stat-card.animate-pulse {
    animation: pulse-stat 2s ease-in-out infinite;
}
```

## Accessibility

The Stat component follows accessibility best practices:

### Semantic HTML
- Uses proper heading hierarchy for the value
- Descriptive labels provide context
- Card structure is screen-reader friendly

### ARIA Attributes

For dynamic stats that update, add appropriate ARIA attributes:

```twig
<twig:bs:stat
    value="1,250"
    label="Total Users"
    :attr="{
        'role': 'status',
        'aria-live': 'polite',
        'aria-atomic': 'true'
    }"
/>
```

### Color Contrast

All variant colors meet WCAG AA contrast requirements. For custom colors, ensure sufficient contrast between text and background.

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  stat:
    value: '0'
    label: 'Statistic'
    variant: null                 # null | 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info'
    icon: null                    # Icon/emoji HTML
    icon_position: 'start'        # 'start' | 'end' | 'top'
    trend: null                   # null | 'up' | 'down' | 'neutral'
    change: null                  # e.g., '+12%' | '-5%'
    description: null             # Additional descriptive text
    size: 'default'               # 'sm' | 'default' | 'lg'
    border: false
    shadow: false
    text_align: 'start'           # 'start' | 'center' | 'end'
    class: null
    attr: {  }
```

## Testing

Run the Stat component tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/StatTest.php
```

The test suite includes:
- ✅ Default options rendering
- ✅ All property variations
- ✅ Variant color schemes
- ✅ Size options (sm, default, lg)
- ✅ Icon positioning (start, end, top)
- ✅ Trend indicators (up, down, neutral)
- ✅ Text alignment options
- ✅ Border and shadow options
- ✅ Custom classes and attributes
- ✅ Config defaults application
- ✅ Edge cases (null values, floats, etc.)

## Real-World Use Cases

### E-commerce Dashboard

```twig
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <twig:bs:stat
            value="${{ total_revenue|number_format(0) }}"
            label="Total Revenue"
            variant="success"
            icon="💰"
            trend="{{ revenue_trend }}"
            change="{{ revenue_change }}"
            description="This month"
            :shadow="true"
        />
    </div>
    
    <div class="col-xl-3 col-md-6">
        <twig:bs:stat
            value="{{ order_count|number_format(0) }}"
            label="Total Orders"
            variant="primary"
            icon="🛒"
            trend="{{ orders_trend }}"
            change="{{ orders_change }}"
            description="This month"
            :shadow="true"
        />
    </div>
    
    <div class="col-xl-3 col-md-6">
        <twig:bs:stat
            value="{{ avg_order_value|number_format(2) }}"
            label="Avg. Order Value"
            variant="info"
            icon="📊"
            trend="{{ aov_trend }}"
            change="{{ aov_change }}"
            description="This month"
            :shadow="true"
        />
    </div>
    
    <div class="col-xl-3 col-md-6">
        <twig:bs:stat
            value="{{ conversion_rate }}%"
            label="Conversion Rate"
            variant="warning"
            icon="🎯"
            trend="{{ conversion_trend }}"
            change="{{ conversion_change }}"
            description="This month"
            :shadow="true"
        />
    </div>
</div>
```

### System Monitoring

```twig
<div class="row g-3">
    <div class="col-md-4">
        <twig:bs:stat
            value="{{ cpu_usage }}%"
            label="CPU Usage"
            variant="{{ cpu_usage > 80 ? 'danger' : 'success' }}"
            size="sm"
        />
    </div>
    
    <div class="col-md-4">
        <twig:bs:stat
            value="{{ memory_usage }}%"
            label="Memory Usage"
            variant="{{ memory_usage > 80 ? 'warning' : 'success' }}"
            size="sm"
        />
    </div>
    
    <div class="col-md-4">
        <twig:bs:stat
            value="{{ disk_usage }}%"
            label="Disk Usage"
            variant="{{ disk_usage > 80 ? 'danger' : 'success' }}"
            size="sm"
        />
    </div>
</div>
```

## Related Components

- **Card** (`bs:card`) - For more complex content layouts
- **Badge** (`bs:badge`) - For smaller status indicators
- **Progress** (`bs:progress`) - For percentage-based metrics
- **Alert** (`bs:alert`) - For important notifications

## References

- [Bootstrap 5.3 Cards](https://getbootstrap.com/docs/5.3/components/card/)
- [Bootstrap 5.3 Badges](https://getbootstrap.com/docs/5.3/components/badge/)
- [Bootstrap 5.3 Utilities](https://getbootstrap.com/docs/5.3/utilities/api/)
- [WCAG Color Contrast](https://www.w3.org/WAI/WCAG21/Understanding/contrast-minimum.html)

