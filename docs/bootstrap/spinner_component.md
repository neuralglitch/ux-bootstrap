# Spinner Component

## Overview

The Spinner component displays animated loading indicators to show the loading state of a component or page. Built entirely with HTML and CSS (no JavaScript required), spinners use Bootstrap 5.3's spinner classes and can be easily customized with variants, sizes, and Bootstrap utilities.

**Component Name:** `bs:spinner`  
**Twig Tag:** `<twig:bs:spinner />`

## Basic Usage

### Border Spinner (Default)

```twig
<twig:bs:spinner />
```

This renders a default border spinner with the "Loading..." visually hidden label.

### Grow Spinner

```twig
<twig:bs:spinner type="grow" />
```

### Colored Spinner

```twig
<twig:bs:spinner variant="primary" />
<twig:bs:spinner variant="success" type="grow" />
```

### Small Spinner

```twig
<twig:bs:spinner size="sm" />
<twig:bs:spinner size="sm" type="grow" />
```

### Spinner in Button

```twig
<button class="btn btn-primary" type="button" disabled>
  <twig:bs:spinner size="sm" :attr="{'aria-hidden': 'true'}" />
  <span>Loading...</span>
</button>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `'border'` | Spinner type: `'border'` or `'grow'` |
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `size` | `?string` | `null` | Size: `'sm'` for small spinner, `null` for default |
| `label` | `string` | `'Loading...'` | Visually hidden label for screen readers |
| `role` | `string` | `'status'` | ARIA role attribute |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Border Spinner Variants

```twig
{# Default border spinner #}
<twig:bs:spinner />

{# Colored border spinners #}
<twig:bs:spinner variant="primary" />
<twig:bs:spinner variant="secondary" />
<twig:bs:spinner variant="success" />
<twig:bs:spinner variant="danger" />
<twig:bs:spinner variant="warning" />
<twig:bs:spinner variant="info" />
<twig:bs:spinner variant="light" />
<twig:bs:spinner variant="dark" />
```

### Grow Spinner Variants

```twig
{# Default grow spinner #}
<twig:bs:spinner type="grow" />

{# Colored grow spinners #}
<twig:bs:spinner type="grow" variant="primary" />
<twig:bs:spinner type="grow" variant="secondary" />
<twig:bs:spinner type="grow" variant="success" />
<twig:bs:spinner type="grow" variant="danger" />
<twig:bs:spinner type="grow" variant="warning" />
<twig:bs:spinner type="grow" variant="info" />
<twig:bs:spinner type="grow" variant="light" />
<twig:bs:spinner type="grow" variant="dark" />
```

### Size Variants

```twig
{# Small border spinner #}
<twig:bs:spinner size="sm" />

{# Small grow spinner #}
<twig:bs:spinner type="grow" size="sm" />

{# Default size (medium) #}
<twig:bs:spinner />
<twig:bs:spinner type="grow" />

{# Custom size using inline styles #}
<twig:bs:spinner :attr="{'style': 'width: 3rem; height: 3rem;'}" />
```

### Alignment

#### Margin Alignment

```twig
{# Using Bootstrap margin utilities #}
<twig:bs:spinner class="m-5" />
```

#### Flex Alignment

```twig
{# Center with flexbox #}
<div class="d-flex justify-content-center">
  <twig:bs:spinner />
</div>

{# Align items with text #}
<div class="d-flex align-items-center">
  <strong>Loading...</strong>
  <twig:bs:spinner class="ms-auto" :attr="{'aria-hidden': 'true'}" />
</div>
```

#### Float Alignment

```twig
<div class="clearfix">
  <twig:bs:spinner class="float-end" />
</div>
```

#### Text Alignment

```twig
<div class="text-center">
  <twig:bs:spinner />
</div>
```

### Spinners in Buttons

#### Icon-Only Button

```twig
<button class="btn btn-primary" type="button" disabled>
  <twig:bs:spinner size="sm" :attr="{'aria-hidden': 'true'}" />
  <span class="visually-hidden">Loading...</span>
</button>
```

#### Button with Text

```twig
<button class="btn btn-primary" type="button" disabled>
  <twig:bs:spinner size="sm" :attr="{'aria-hidden': 'true'}" />
  <span>Loading...</span>
</button>
```

#### Grow Spinner in Button

```twig
<button class="btn btn-primary" type="button" disabled>
  <twig:bs:spinner type="grow" size="sm" :attr="{'aria-hidden': 'true'}" />
  <span>Loading...</span>
</button>
```

### Custom Labels

```twig
{# Custom accessibility label #}
<twig:bs:spinner label="Please wait..." />

{# Processing indicator #}
<twig:bs:spinner label="Processing your request..." />

{# Saving indicator #}
<twig:bs:spinner label="Saving changes..." />
```

### Advanced Customization

#### Custom Classes

```twig
{# Add custom classes for styling #}
<twig:bs:spinner class="my-spinner custom-animation" />

{# Combine with Bootstrap utilities #}
<twig:bs:spinner class="text-center mx-auto my-4" />
```

#### Custom Attributes

```twig
{# Add data attributes #}
<twig:bs:spinner :attr="{
  'data-loading': 'true',
  'data-component': 'form-loader'
}" />

{# Add inline styles #}
<twig:bs:spinner :attr="{
  'style': 'width: 3rem; height: 3rem; border-width: 0.3em;'
}" />

{# Add ARIA attributes #}
<twig:bs:spinner :attr="{
  'aria-live': 'polite',
  'aria-busy': 'true'
}" />
```

## Accessibility

### Best Practices

1. **Always Include a Label**: The `label` prop provides a visually hidden message for screen readers
2. **Use Appropriate Roles**: The default `role="status"` is suitable for most loading indicators
3. **Hide Decorative Spinners**: When used in buttons with visible text, add `aria-hidden="true"` to the spinner
4. **Consider Motion Preferences**: The spinner respects the `prefers-reduced-motion` media query

### Examples

```twig
{# Standalone loading indicator #}
<twig:bs:spinner label="Loading content..." />

{# Spinner in button with visible text #}
<button class="btn btn-primary" type="button" disabled>
  <twig:bs:spinner size="sm" :attr="{'aria-hidden': 'true'}" />
  <span>Loading...</span>
</button>

{# Custom ARIA attributes for live regions #}
<twig:bs:spinner 
  label="Loading new messages..."
  :attr="{
    'aria-live': 'polite',
    'aria-atomic': 'true'
  }" />
```

## Configuration

### Global Defaults

Configure default spinner settings in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  spinner:
    type: 'border'              # 'border' | 'grow'
    variant: null               # null | 'primary' | 'secondary' | etc.
    size: null                  # null (default) | 'sm'
    label: 'Loading...'         # Visually hidden label
    role: 'status'              # ARIA role attribute
    class: null                 # Additional CSS classes
    attr: {}                    # Additional HTML attributes
```

### Configuration Examples

```yaml
# Use grow spinners by default
neuralglitch_ux_bootstrap:
  spinner:
    type: 'grow'
    variant: 'primary'
```

```yaml
# Small spinners with custom label
neuralglitch_ux_bootstrap:
  spinner:
    size: 'sm'
    label: 'Please wait...'
```

```yaml
# Add default classes to all spinners
neuralglitch_ux_bootstrap:
  spinner:
    class: 'my-spinner'
```

## Use Cases

### 1. Loading States

```twig
{# Page loading overlay #}
<div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 9999;">
  <twig:bs:spinner variant="primary" label="Loading page content..." />
</div>
```

### 2. Form Submission

```twig
<form id="myForm">
  {# Form fields #}
  
  <button type="submit" class="btn btn-primary" id="submitBtn">
    <span id="btnText">Submit</span>
    <twig:bs:spinner size="sm" class="d-none" id="btnSpinner" :attr="{'aria-hidden': 'true'}" />
  </button>
</form>

<script>
document.getElementById('myForm').addEventListener('submit', function(e) {
  document.getElementById('btnText').textContent = 'Submitting...';
  document.getElementById('btnSpinner').classList.remove('d-none');
  document.getElementById('submitBtn').disabled = true;
});
</script>
```

### 3. Content Loading

```twig
<div class="card">
  <div class="card-body">
    <div id="contentArea">
      {# Content will load here #}
      <div class="text-center py-5">
        <twig:bs:spinner variant="primary" label="Loading content..." />
      </div>
    </div>
  </div>
</div>
```

### 4. Infinite Scroll Indicator

```twig
<div id="scrollContainer">
  {# Items listed here #}
</div>

<div class="text-center py-4" id="loadMoreSpinner">
  <twig:bs:spinner variant="secondary" label="Loading more items..." />
</div>
```

### 5. Button States

```twig
{# Initial state #}
<button type="button" class="btn btn-primary" data-action="load-data">
  Load Data
</button>

{# Loading state #}
<button type="button" class="btn btn-primary" disabled>
  <twig:bs:spinner size="sm" :attr="{'aria-hidden': 'true'}" />
  Loading...
</button>

{# Success state #}
<button type="button" class="btn btn-success">
  <i class="bi bi-check-circle"></i>
  Loaded!
</button>
```

## Styling Tips

### Custom Colors

While the `variant` prop uses Bootstrap's text color utilities, you can override colors with custom CSS:

```css
/* Custom spinner color */
.my-spinner.spinner-border {
  color: #ff6b6b;
}

/* Custom spinner with gradient */
.gradient-spinner.spinner-border {
  border-color: transparent;
  border-right-color: #667eea;
}
```

### Custom Animation Speed

```css
/* Faster spinner */
.spinner-border.fast {
  animation-duration: 0.5s;
}

/* Slower spinner */
.spinner-border.slow {
  animation-duration: 1.5s;
}
```

### Custom Sizes

```twig
{# Using inline styles #}
<twig:bs:spinner :attr="{
  'style': 'width: 4rem; height: 4rem; border-width: 0.5em;'
}" />

{# Using CSS classes #}
<twig:bs:spinner class="spinner-xl" />
```

```css
.spinner-xl {
  width: 4rem;
  height: 4rem;
  border-width: 0.5em;
}
```

## Testing

### Test Examples

```php
public function testDefaultSpinner(): void
{
    $component = new Spinner($this->config);
    $component->mount();
    $options = $component->options();

    $this->assertStringContainsString('spinner-border', $options['classes']);
    $this->assertSame('Loading...', $options['label']);
}

public function testGrowSpinner(): void
{
    $component = new Spinner($this->config);
    $component->type = 'grow';
    $component->mount();
    $options = $component->options();

    $this->assertStringContainsString('spinner-grow', $options['classes']);
}

public function testColoredSpinner(): void
{
    $component = new Spinner($this->config);
    $component->variant = 'primary';
    $component->mount();
    $options = $component->options();

    $this->assertStringContainsString('text-primary', $options['classes']);
}
```

## Related Components

- **Button** (`bs:button`) - Can include spinners for loading states
- **Alert** (`bs:alert`) - Can show spinners during async operations
- **Modal** (`bs:modal`) - Can display spinners while loading content
- **Card** (`bs:card`) - Can use spinners as loading placeholders

## Browser Compatibility

The Spinner component works in all modern browsers that support:
- CSS animations
- Flexbox
- CSS custom properties (for Bootstrap 5.3)

The animation respects the user's `prefers-reduced-motion` setting for accessibility.

## References

- [Bootstrap 5.3 Spinners Documentation](https://getbootstrap.com/docs/5.3/components/spinners/)
- [Bootstrap Spinner Examples](https://getbootstrap.com/docs/5.3/components/spinners/#examples)
- [ARIA: status role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/status_role)
- [prefers-reduced-motion](https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion)

