# Progress Component

## Overview

The `bs:progress` component provides a visual representation of progress, supporting all Bootstrap 5.3 progress bar features including variants, labels, striped appearances, animations, and custom heights.

## Basic Usage

### Simple Progress Bar

```twig
<twig:bs:progress :value="50" />
```

### With Label

```twig
{# Automatic percentage label #}
<twig:bs:progress :value="75" :showLabel="true" />

{# Custom label #}
<twig:bs:progress :value="60" label="3 of 5 files uploaded" />

{# Label via content block #}
<twig:bs:progress :value="80">
    80% Complete
</twig:bs:progress>
```

### With Variants

```twig
<twig:bs:progress :value="25" variant="success" />
<twig:bs:progress :value="50" variant="info" />
<twig:bs:progress :value="75" variant="warning" />
<twig:bs:progress :value="100" variant="danger" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | `int\|float` | `0` | Current progress value |
| `min` | `int\|float` | `0` | Minimum value |
| `max` | `int\|float` | `100` | Maximum value |
| `label` | `?string` | `null` | Custom label text to display |
| `showLabel` | `bool` | `false` | If true, shows percentage as label |
| `height` | `?string` | `null` | Custom height (e.g., '1px', '20px') |
| `variant` | `?string` | `null` | Bootstrap color variant (primary, success, info, warning, danger, etc.) |
| `striped` | `bool` | `false` | If true, applies striped appearance |
| `animated` | `bool` | `false` | If true, applies animated stripes (requires `striped=true`) |
| `ariaLabel` | `?string` | `null` | Accessible label for screen readers |
| `class` | `string` | `''` | Additional CSS classes for the wrapper |
| `attr` | `array` | `[]` | Additional HTML attributes for the wrapper |

## Examples

### Bar Sizing

#### Width

The width is automatically calculated based on the `value`, `min`, and `max` props:

```twig
<twig:bs:progress :value="0" />
<twig:bs:progress :value="25" />
<twig:bs:progress :value="50" />
<twig:bs:progress :value="75" />
<twig:bs:progress :value="100" />
```

#### Height

Set custom height using the `height` prop:

```twig
<twig:bs:progress :value="25" height="1px" />
<twig:bs:progress :value="25" height="20px" />
<twig:bs:progress :value="25" height="30px" />
```

### Labels

#### Show Percentage

```twig
<twig:bs:progress :value="25" :showLabel="true" />
```

Output: `25%`

#### Custom Label

```twig
<twig:bs:progress :value="65" label="Processing..." />
<twig:bs:progress :value="80" label="80% (4/5 complete)" />
```

#### Label via Content Block

```twig
<twig:bs:progress :value="50">
    <strong>50%</strong> Complete
</twig:bs:progress>
```

### Backgrounds (Variants)

Use the `variant` prop to change the progress bar color:

```twig
<twig:bs:progress :value="25" variant="success" :showLabel="true" />
<twig:bs:progress :value="50" variant="info" :showLabel="true" />
<twig:bs:progress :value="75" variant="warning" :showLabel="true" />
<twig:bs:progress :value="100" variant="danger" :showLabel="true" />
```

### Striped Progress Bars

Add the `striped` prop for a striped appearance:

```twig
<twig:bs:progress :value="10" :striped="true" />
<twig:bs:progress :value="25" :striped="true" variant="success" />
<twig:bs:progress :value="50" :striped="true" variant="info" />
<twig:bs:progress :value="75" :striped="true" variant="warning" />
<twig:bs:progress :value="100" :striped="true" variant="danger" />
```

### Animated Stripes

Add both `striped` and `animated` props to animate the stripes:

```twig
<twig:bs:progress :value="75" :striped="true" :animated="true" />
```

### Custom Min/Max Values

By default, progress ranges from 0 to 100, but you can customize this:

```twig
{# Progress from 0 to 10, currently at 5 (50%) #}
<twig:bs:progress :value="5" :min="0" :max="10" :showLabel="true" />

{# Progress from 1 to 5, currently at 3 (50%) #}
<twig:bs:progress :value="3" :min="1" :max="5" label="Step 3 of 5" />
```

### Multiple/Stacked Progress Bars

For stacked progress bars, use multiple progress components together:

```twig
<div class="progress-stacked">
    <twig:bs:progress :value="15" />
    <twig:bs:progress :value="30" variant="success" />
    <twig:bs:progress :value="20" variant="info" />
</div>
```

**Note:** For proper stacked bars, the width styling must be applied to the progress wrapper. See Bootstrap documentation for advanced stacked bar examples.

## Accessibility

The component automatically includes proper ARIA attributes:

- `role="progressbar"` on the wrapper
- `aria-valuenow` set to current value
- `aria-valuemin` set to minimum value
- `aria-valuemax` set to maximum value
- Optional `aria-label` via the `ariaLabel` prop

### Best Practices

1. **Always provide an accessible label** using the `ariaLabel` prop for screen readers:
   ```twig
   <twig:bs:progress :value="50" ariaLabel="File upload progress" />
   ```

2. **Use visible labels** when possible for better UX:
   ```twig
   <twig:bs:progress :value="75" :showLabel="true" ariaLabel="Installation progress" />
   ```

3. **Don't rely on color alone** to convey meaning. Use labels or surrounding text:
   ```twig
   <p>Upload Status:</p>
   <twig:bs:progress :value="60" variant="success" label="60% uploaded" />
   ```

## Configuration

Default settings can be configured in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  progress:
    value: 0                    # Default value
    min: 0                      # Default minimum
    max: 100                    # Default maximum
    show_label: false           # Show percentage by default
    height: null                # Default height
    variant: null               # Default variant
    striped: false              # Striped by default
    animated: false             # Animated by default
    aria_label: null            # Default ARIA label
    class: null                 # Additional classes
    attr: {  }                  # Additional attributes
```

### Example Configuration

```yaml
neuralglitch_ux_bootstrap:
  progress:
    show_label: true            # Show labels by default
    variant: 'primary'          # Use primary variant by default
    height: '20px'              # Default height
    class: 'mb-3'               # Add margin bottom
```

## Advanced Examples

### Dynamic Progress with Controller

```php
// In your controller
$uploadProgress = 65;

return $this->render('template.html.twig', [
    'uploadProgress' => $uploadProgress,
]);
```

```twig
{# In your template #}
<twig:bs:progress 
    :value="uploadProgress" 
    variant="success" 
    :showLabel="true"
    ariaLabel="File upload progress"
/>
```

### Conditional Variants

```twig
{% set progress = 75 %}
{% set variant = progress < 30 ? 'danger' : (progress < 70 ? 'warning' : 'success') %}

<twig:bs:progress 
    :value="progress" 
    :variant="variant" 
    :showLabel="true"
/>
```

### Progress with Context

```twig
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Installation Progress</h5>
        <p class="card-text">Installing dependencies...</p>
        <twig:bs:progress 
            :value="installProgress" 
            variant="primary"
            :striped="true"
            :animated="true"
            :showLabel="true"
            height="25px"
            ariaLabel="Installation progress"
        />
        <small class="text-muted">
            {{ installedPackages }} of {{ totalPackages }} packages installed
        </small>
    </div>
</div>
```

### Small Progress Indicator

```twig
{# Thin progress bar for subtle progress indication #}
<twig:bs:progress 
    :value="readingProgress" 
    height="3px"
    variant="primary"
    class="position-fixed top-0 start-0 w-100"
    ariaLabel="Reading progress"
/>
```

## Testing

The Progress component includes comprehensive tests covering:

- Default options and rendering
- Value normalization (min/max bounds)
- Percentage calculation with custom min/max
- Label options (automatic percentage, custom text, content block)
- Variant, striped, and animated options
- Custom height and accessibility attributes
- Configuration defaults
- Edge cases (0%, 100%, float values)

Run the tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/ProgressTest.php
```

## Related Components

- **Alert** - For displaying progress messages
- **Spinner** - For indeterminate loading states
- **Toast** - For progress notifications

## Browser Support

The Progress component works in all modern browsers and supports:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## References

- [Bootstrap 5.3 Progress Documentation](https://getbootstrap.com/docs/5.3/components/progress/)
- [MDN: ARIA progressbar role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/progressbar_role)
- [WAI-ARIA Authoring Practices - Progress Bar](https://www.w3.org/WAI/ARIA/apg/patterns/meter/)

