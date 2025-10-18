# Placeholder Component

## Overview

The Placeholder component provides loading placeholders (skeleton loaders) to indicate content that may still be loading. Built only with HTML and CSS, placeholders require no JavaScript and can be easily customized with utility classes.

**Tag**: `<twig:bs:placeholder />`

**Bootstrap Documentation**: [Placeholders](https://getbootstrap.com/docs/5.3/components/placeholders/)

## Features

- ✅ Pure HTML/CSS - no JavaScript required
- ✅ Grid-based width control
- ✅ Color variants (Bootstrap theme colors)
- ✅ Multiple sizing options (lg, sm, xs)
- ✅ Animation effects (glow, wave)
- ✅ Custom width support
- ✅ Accessible by default (aria-hidden)
- ✅ Highly customizable

## Basic Usage

### Simple Placeholder

```twig
<twig:bs:placeholder col="6" />
```

**Rendered HTML**:
```html
<span class="placeholder col-6" aria-hidden="true">&nbsp;</span>
```

### With Color

```twig
<twig:bs:placeholder col="12" variant="primary" />
```

### With Animation

```twig
<twig:bs:placeholder col="12" animation="glow" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `col` | `?string` | `null` | Grid column width class (e.g., '6', '12') |
| `size` | `?string` | `null` | Size modifier: 'lg', 'sm', 'xs', or null |
| `animation` | `?string` | `null` | Animation type: 'glow', 'wave', or null |
| `variant` | `?string` | `null` | Color variant: 'primary', 'secondary', etc. |
| `width` | `?string` | `null` | Custom width (e.g., '75%', '100px') |
| `tag` | `string` | `'span'` | HTML tag to use |
| `ariaHidden` | `bool` | `true` | Hide from screen readers |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Width Control

#### Grid Columns

```twig
{# 50% width #}
<twig:bs:placeholder col="6" />

{# Full width #}
<twig:bs:placeholder col="12" />
```

#### Custom Width

```twig
{# Percentage #}
<twig:bs:placeholder width="75%" />

{# Pixels #}
<twig:bs:placeholder width="200px" />
```

### Color Variants

```twig
{# Default (currentColor) #}
<twig:bs:placeholder col="12" />

{# Primary color #}
<twig:bs:placeholder col="12" variant="primary" />

{# Success color #}
<twig:bs:placeholder col="12" variant="success" />

{# Danger color #}
<twig:bs:placeholder col="12" variant="danger" />
```

### Sizing

```twig
{# Large #}
<twig:bs:placeholder col="12" size="lg" />

{# Default #}
<twig:bs:placeholder col="12" />

{# Small #}
<twig:bs:placeholder col="12" size="sm" />

{# Extra small #}
<twig:bs:placeholder col="12" size="xs" />
```

### Animation

#### Glow Effect

```twig
<twig:bs:placeholder col="12" animation="glow" />
```

#### Wave Effect

```twig
<twig:bs:placeholder col="12" animation="wave" />
```

### Card Loading Example

```twig
<div class="card">
  <img src="..." class="card-img-top" alt="...">
  
  <div class="card-body">
    <h5 class="card-title">
      <twig:bs:placeholder col="6" animation="glow" />
    </h5>
    
    <p class="card-text">
      <twig:bs:placeholder col="7" animation="glow" />
      <twig:bs:placeholder col="4" animation="glow" />
      <twig:bs:placeholder col="4" animation="glow" />
      <twig:bs:placeholder col="6" animation="glow" />
      <twig:bs:placeholder col="8" animation="glow" />
    </p>
    
    <twig:bs:placeholder 
      col="6" 
      tag="a" 
      :attr="{'class': 'btn btn-primary disabled', 'aria-disabled': 'true'}" 
    />
  </div>
</div>
```

### List Loading Example

```twig
<ul class="list-group">
  {% for i in 1..5 %}
    <li class="list-group-item">
      <twig:bs:placeholder col="7" animation="glow" />
    </li>
  {% endfor %}
</ul>
```

### Table Loading Example

```twig
<table class="table">
  <thead>
    <tr>
      <th><twig:bs:placeholder col="6" /></th>
      <th><twig:bs:placeholder col="6" /></th>
      <th><twig:bs:placeholder col="6" /></th>
    </tr>
  </thead>
  <tbody>
    {% for i in 1..3 %}
      <tr>
        <td><twig:bs:placeholder col="8" animation="glow" /></td>
        <td><twig:bs:placeholder col="6" animation="glow" /></td>
        <td><twig:bs:placeholder col="7" animation="glow" /></td>
      </tr>
    {% endfor %}
  </tbody>
</table>
```

### Button Placeholder

```twig
<twig:bs:placeholder 
  col="4" 
  tag="a" 
  :attr="{
    'class': 'btn btn-primary disabled',
    'tabindex': '-1',
    'aria-disabled': 'true'
  }" 
/>
```

### Custom Element

```twig
<twig:bs:placeholder 
  tag="div" 
  col="12" 
  variant="secondary" 
  size="lg"
/>
```

## Accessibility

### ARIA Hidden

By default, placeholders are hidden from screen readers using `aria-hidden="true"`:

```twig
<twig:bs:placeholder col="6" />
{# Renders: <span class="placeholder col-6" aria-hidden="true">&nbsp;</span> #}
```

To make placeholders visible to screen readers (not recommended):

```twig
<twig:bs:placeholder col="6" :ariaHidden="false" />
```

### Loading States

When using placeholders to indicate loading:

1. **Use proper ARIA attributes** on the container
2. **Update ARIA live regions** when content loads
3. **Consider screen reader announcements**

Example:

```twig
<div aria-live="polite" aria-busy="true">
  {% if loading %}
    <twig:bs:placeholder col="12" animation="glow" />
  {% else %}
    <p>{{ actualContent }}</p>
  {% endif %}
</div>
```

### JavaScript Toggle Pattern

```javascript
// Show placeholder
container.setAttribute('aria-busy', 'true');
placeholder.classList.remove('d-none');

// Hide placeholder and show content
fetch('/api/data')
  .then(response => response.json())
  .then(data => {
    placeholder.classList.add('d-none');
    content.innerHTML = data.html;
    container.setAttribute('aria-busy', 'false');
  });
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  placeholder:
    col: null                   # Grid column width (e.g., '6', '12')
    size: null                  # null (default) | 'lg' | 'sm' | 'xs'
    animation: null             # null | 'glow' | 'wave'
    variant: null               # null | 'primary' | 'secondary' | etc.
    width: null                 # Custom width (e.g., '75%', '100px')
    tag: 'span'                 # HTML tag (default: 'span')
    aria_hidden: true           # Hide from screen readers (default: true)
    class: null
    attr: {}
```

### Customizing Defaults

```yaml
neuralglitch_ux_bootstrap:
  placeholder:
    animation: 'glow'           # Default to glow animation
    variant: 'secondary'        # Default to secondary color
    col: '12'                   # Default to full width
    class: 'my-placeholder'     # Add custom class to all placeholders
```

## Advanced Usage

### Multiple Placeholders in Container

```twig
<div class="placeholder-glow">
  <twig:bs:placeholder col="7" />
  <twig:bs:placeholder col="4" />
  <twig:bs:placeholder col="6" />
  <twig:bs:placeholder col="8" />
</div>
```

**Note**: Animation classes (`placeholder-glow`, `placeholder-wave`) should be applied to the parent container, not individual placeholders.

### Combining with Other Components

```twig
{# Badge placeholder #}
<twig:bs:placeholder 
  col="3" 
  :attr="{'class': 'badge bg-primary'}"
/>

{# Avatar placeholder #}
<twig:bs:placeholder 
  :attr="{
    'class': 'rounded-circle bg-secondary',
    'style': 'width: 50px; height: 50px;'
  }"
/>
```

### Responsive Widths

```twig
{# Custom responsive width #}
<twig:bs:placeholder 
  :attr="{'class': 'col-12 col-md-6 col-lg-4'}"
/>
```

## Testing

### Running Component Tests

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/PlaceholderTest.php
```

### Test Coverage

The component includes comprehensive tests for:
- ✅ Default options
- ✅ Grid column widths
- ✅ All size variants (lg, sm, xs)
- ✅ Animation effects (glow, wave)
- ✅ Color variants
- ✅ Custom widths
- ✅ Custom tags
- ✅ ARIA attributes
- ✅ Combined options
- ✅ Custom classes and attributes
- ✅ Configuration defaults

## Common Use Cases

### 1. Loading Card Content

```twig
{% if article is null %}
  <div class="card">
    <div class="card-body placeholder-glow">
      <h5 class="card-title">
        <twig:bs:placeholder col="8" />
      </h5>
      <p class="card-text">
        <twig:bs:placeholder col="12" />
        <twig:bs:placeholder col="12" />
        <twig:bs:placeholder col="7" />
      </p>
    </div>
  </div>
{% else %}
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ article.title }}</h5>
      <p class="card-text">{{ article.content }}</p>
    </div>
  </div>
{% endif %}
```

### 2. Loading User Profile

```twig
<div class="d-flex align-items-center">
  <twig:bs:placeholder 
    :attr="{
      'class': 'rounded-circle bg-secondary me-3',
      'style': 'width: 64px; height: 64px;'
    }"
  />
  <div class="flex-grow-1 placeholder-glow">
    <twig:bs:placeholder col="6" size="lg" />
    <twig:bs:placeholder col="8" size="sm" />
  </div>
</div>
```

### 3. Loading Data Table

```twig
{% if data is empty %}
  <table class="table">
    <tbody>
      {% for i in 1..5 %}
        <tr>
          <td><twig:bs:placeholder col="3" animation="glow" /></td>
          <td><twig:bs:placeholder col="8" animation="glow" /></td>
          <td><twig:bs:placeholder col="5" animation="glow" /></td>
        </tr>
      {% endfor %}
    </tbody>
  </table>
{% else %}
  {# Actual table content #}
{% endif %}
```

### 4. Loading Form

```twig
<div class="placeholder-glow">
  <div class="mb-3">
    <twig:bs:placeholder col="3" tag="label" class="form-label d-block" />
    <twig:bs:placeholder col="12" tag="div" class="form-control" />
  </div>
  <div class="mb-3">
    <twig:bs:placeholder col="4" tag="label" class="form-label d-block" />
    <twig:bs:placeholder col="12" tag="div" class="form-control" />
  </div>
  <twig:bs:placeholder col="3" tag="button" class="btn btn-primary disabled" />
</div>
```

## Related Components

- [**Spinner**](spinner_component.md) - For inline loading indicators
- [**Progress**](progress_component.md) - For determinate progress indication
- [**Card**](card_component.md) - Often used with placeholder content
- [**List Group**](list_group_component.md) - Can display placeholder items

## Best Practices

### DO:
- ✅ Use placeholders for content that's actively loading
- ✅ Match placeholder dimensions to actual content
- ✅ Use `aria-hidden="true"` to hide from screen readers
- ✅ Apply animation to parent container for better performance
- ✅ Use appropriate color variants to match your design
- ✅ Consider using with AJAX/Fetch for dynamic content

### DON'T:
- ❌ Don't use placeholders for static content
- ❌ Don't forget to update ARIA live regions when content loads
- ❌ Don't apply animation directly to individual placeholders (use parent)
- ❌ Don't leave placeholders visible indefinitely
- ❌ Don't make placeholders keyboard-focusable

## Browser Support

Placeholders are supported in all modern browsers that support Bootstrap 5.3:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## References

- [Bootstrap 5.3 Placeholders Documentation](https://getbootstrap.com/docs/5.3/components/placeholders/)
- [ARIA Live Regions](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/ARIA_Live_Regions)
- [Skeleton Screen Pattern](https://uxdesign.cc/what-you-should-know-about-skeleton-screens-a820c45a571a)

