# Collapse Component

## Overview

The Collapse component provides a way to toggle the visibility of content across your project. It uses Bootstrap 5.3's collapse functionality with smooth animations and supports both vertical (height) and horizontal (width) collapsing.

**Component Tag**: `<twig:bs:collapse>`

**Key Features**:
- Vertical and horizontal collapsing
- Smooth CSS transitions
- Accordion-like group management
- Highly configurable
- Accessibility built-in

## Basic Usage

### Simple Collapse

```twig
{# Trigger button #}
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#collapseExample" 
    aria-expanded="false" 
    aria-controls="collapseExample">
    Toggle Collapse
</button>

{# Collapsible content #}
<twig:bs:collapse id="collapseExample">
    <div class="card card-body">
        Some placeholder content for the collapse component. 
        This panel is hidden by default but revealed when the user activates the trigger.
    </div>
</twig:bs:collapse>
```

### Link Trigger

You can also use links as triggers:

```twig
<a 
    class="btn btn-primary" 
    data-bs-toggle="collapse" 
    href="#collapseExample" 
    role="button" 
    aria-expanded="false" 
    aria-controls="collapseExample">
    Link with href
</a>

<twig:bs:collapse id="collapseExample">
    <div class="card card-body">
        Some content to show/hide
    </div>
</twig:bs:collapse>
```

### Show by Default

```twig
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#shownCollapse" 
    aria-expanded="true" 
    aria-controls="shownCollapse">
    Toggle Collapse
</button>

<twig:bs:collapse id="shownCollapse" :show="true">
    <div class="card card-body">
        This content is visible by default.
    </div>
</twig:bs:collapse>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `?string` | `null` | The element ID (required for targeting from triggers) |
| `show` | `?bool` | `null` | Whether to show the collapse by default (uses config default if not set) |
| `horizontal` | `?bool` | `null` | Enable horizontal collapse (uses config default if not set) |
| `parent` | `?string` | `null` | Parent selector for accordion-like behavior |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Horizontal Collapse

The collapse plugin also supports horizontal collapsing. Add `:horizontal="true"` to transition the width instead of height:

```twig
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#collapseWidthExample" 
    aria-expanded="false" 
    aria-controls="collapseWidthExample">
    Toggle width collapse
</button>

<div style="min-height: 120px;">
    <twig:bs:collapse id="collapseWidthExample" :horizontal="true">
        <div class="card card-body" style="width: 300px;">
            This is some placeholder content for a horizontal collapse. 
            It's hidden by default and shown when triggered.
        </div>
    </twig:bs:collapse>
</div>
```

### Multiple Toggles and Targets

A button or link can show and hide multiple elements by referencing them with a CSS selector:

```twig
{# Toggles #}
<p class="d-inline-flex gap-1">
    <a 
        class="btn btn-primary" 
        data-bs-toggle="collapse" 
        href="#multiCollapseExample1" 
        role="button" 
        aria-expanded="false" 
        aria-controls="multiCollapseExample1">
        Toggle first element
    </a>
    <button 
        class="btn btn-primary" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#multiCollapseExample2" 
        aria-expanded="false" 
        aria-controls="multiCollapseExample2">
        Toggle second element
    </button>
    <button 
        class="btn btn-primary" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target=".multi-collapse" 
        aria-expanded="false" 
        aria-controls="multiCollapseExample1 multiCollapseExample2">
        Toggle both elements
    </button>
</p>

{# Collapsible elements #}
<div class="row">
    <div class="col">
        <twig:bs:collapse id="multiCollapseExample1" class="multi-collapse">
            <div class="card card-body">
                Some placeholder content for the first collapse component.
            </div>
        </twig:bs:collapse>
    </div>
    <div class="col">
        <twig:bs:collapse id="multiCollapseExample2" class="multi-collapse">
            <div class="card card-body">
                Some placeholder content for the second collapse component.
            </div>
        </twig:bs:collapse>
    </div>
</div>
```

### Accordion-like Behavior

Use the `parent` prop to create accordion-like group management where only one collapse is open at a time:

```twig
<div id="accordionExample">
    {# First item #}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button 
                class="accordion-button" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseOne" 
                aria-expanded="true" 
                aria-controls="collapseOne">
                Accordion Item #1
            </button>
        </h2>
        <twig:bs:collapse 
            id="collapseOne" 
            :show="true" 
            parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong>
            </div>
        </twig:bs:collapse>
    </div>

    {# Second item #}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button 
                class="accordion-button collapsed" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseTwo" 
                aria-expanded="false" 
                aria-controls="collapseTwo">
                Accordion Item #2
            </button>
        </h2>
        <twig:bs:collapse 
            id="collapseTwo" 
            parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong>
            </div>
        </twig:bs:collapse>
    </div>
</div>
```

**Note**: For full accordion functionality, consider using the `<twig:bs:accordion>` component instead.

### With Custom Classes

```twig
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#customCollapse" 
    aria-expanded="false" 
    aria-controls="customCollapse">
    Toggle
</button>

<twig:bs:collapse 
    id="customCollapse" 
    class="border border-primary rounded mt-2">
    <div class="p-3">
        Custom styled collapse content
    </div>
</twig:bs:collapse>
```

### With Custom Attributes

```twig
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#attrCollapse" 
    aria-expanded="false" 
    aria-controls="attrCollapse">
    Toggle
</button>

<twig:bs:collapse 
    id="attrCollapse" 
    :attr="{
        'data-custom': 'value',
        'aria-labelledby': 'headingOne'
    }">
    <div class="card card-body">
        Content with custom attributes
    </div>
</twig:bs:collapse>
```

## Accessibility

The Collapse component follows Bootstrap's accessibility guidelines:

### Trigger Requirements

1. **aria-expanded**: Add to the control element to convey current state
   - `aria-expanded="false"` when collapsed
   - `aria-expanded="true"` when expanded
   - Bootstrap's JavaScript automatically toggles this

2. **aria-controls**: Add to the control element with the collapse ID
   ```html
   aria-controls="collapseExample"
   ```

3. **role="button"**: Required for non-button elements (like links)
   ```html
   <a ... role="button">Toggle</a>
   ```

### Complete Example

```twig
{# Accessible button trigger #}
<button 
    class="btn btn-primary" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#accessibleCollapse" 
    aria-expanded="false" 
    aria-controls="accessibleCollapse">
    Toggle accessible content
</button>

{# Collapse with aria label #}
<twig:bs:collapse 
    id="accessibleCollapse"
    :attr="{'aria-labelledby': 'collapseButton'}">
    <div class="card card-body">
        Accessible collapse content
    </div>
</twig:bs:collapse>
```

### Keyboard Navigation

Bootstrap's collapse implements basic keyboard support:
- Triggers respect standard button/link keyboard behavior
- Focus management handled automatically

For advanced keyboard patterns (like accordion navigation), you may need custom JavaScript.

## Configuration

Default configuration can be set globally in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  collapse:
    show: false                 # Whether to show by default
    horizontal: false           # Horizontal collapse (width instead of height)
    parent: null                # Parent selector for accordion-like behavior
    class: null                 # Default additional classes
    attr: {}                    # Default additional attributes
```

### Example Configuration

```yaml
neuralglitch_ux_bootstrap:
  collapse:
    show: false
    horizontal: false
    parent: null
    class: 'my-collapse'        # Add custom class to all collapses
    attr:
      data-analytics: 'collapse'
```

## JavaScript API

Bootstrap provides a JavaScript API for programmatic control:

### Methods

```javascript
// Get collapse instance
const collapseEl = document.getElementById('myCollapse');
const collapse = new bootstrap.Collapse(collapseEl, {
    toggle: false
});

// Methods
collapse.show();      // Show the collapse
collapse.hide();      // Hide the collapse
collapse.toggle();    // Toggle the collapse
collapse.dispose();   // Destroy the collapse instance
```

### Events

```javascript
const collapseEl = document.getElementById('myCollapse');

collapseEl.addEventListener('show.bs.collapse', event => {
    console.log('Collapse is about to show');
});

collapseEl.addEventListener('shown.bs.collapse', event => {
    console.log('Collapse is now visible');
});

collapseEl.addEventListener('hide.bs.collapse', event => {
    console.log('Collapse is about to hide');
});

collapseEl.addEventListener('hidden.bs.collapse', event => {
    console.log('Collapse is now hidden');
});
```

## Testing

The Collapse component includes comprehensive tests. To run them:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/CollapseTest.php
```

### Test Coverage

The test suite covers:
- ✅ Default options
- ✅ Show option
- ✅ Horizontal option
- ✅ Combined options
- ✅ ID attribute
- ✅ Parent attribute
- ✅ Custom classes
- ✅ Custom attributes
- ✅ Config defaults
- ✅ Props overriding config
- ✅ Edge cases

## Common Patterns

### FAQ Accordion

```twig
<div id="faqAccordion">
    {% for item in faqs %}
        <div class="mb-2">
            <button 
                class="btn btn-link text-start w-100" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#faq{{ loop.index }}" 
                aria-expanded="{{ loop.first ? 'true' : 'false' }}" 
                aria-controls="faq{{ loop.index }}">
                {{ item.question }}
            </button>
            <twig:bs:collapse 
                id="faq{{ loop.index }}" 
                :show="loop.first" 
                parent="#faqAccordion">
                <div class="card card-body">
                    {{ item.answer }}
                </div>
            </twig:bs:collapse>
        </div>
    {% endfor %}
</div>
```

### Expandable Sections

```twig
<div class="card">
    <div class="card-header">
        <button 
            class="btn btn-link text-decoration-none" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#details" 
            aria-expanded="false" 
            aria-controls="details">
            <i class="bi bi-chevron-down"></i> Show Details
        </button>
    </div>
    <twig:bs:collapse id="details">
        <div class="card-body">
            Detailed information here...
        </div>
    </twig:bs:collapse>
</div>
```

### Sidebar Toggle

```twig
<button 
    class="btn btn-primary d-md-none" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#sidebar" 
    aria-expanded="false" 
    aria-controls="sidebar">
    Toggle Sidebar
</button>

<div class="row">
    <div class="col-md-3">
        <twig:bs:collapse id="sidebar" :show="true" :horizontal="true">
            <div class="bg-light p-3">
                Sidebar content...
            </div>
        </twig:bs:collapse>
    </div>
    <div class="col-md-9">
        Main content...
    </div>
</div>
```

## CSS Classes

The component applies these Bootstrap classes:

| Class | Applied When | Purpose |
|-------|-------------|---------|
| `.collapse` | Always | Base collapse class |
| `.show` | `show=true` | Makes content visible by default |
| `.collapse-horizontal` | `horizontal=true` | Enables horizontal collapsing |
| `.collapsing` | During transition | Applied automatically by Bootstrap JS |

## Related Components

- **[Accordion](accordion_component.md)** - Full accordion with built-in collapse management
- **[Card](card_component.md)** - Often used as collapse content containers
- **[Button](button_component.md)** - Common trigger for collapses
- **[Link](link_component.md)** - Alternative trigger for collapses

## Browser Compatibility

The Collapse component works in all modern browsers that Bootstrap 5.3 supports:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## References

- [Bootstrap 5.3 Collapse Documentation](https://getbootstrap.com/docs/5.3/components/collapse/)
- [Bootstrap Collapse JavaScript API](https://getbootstrap.com/docs/5.3/components/collapse/#methods)
- [ARIA Authoring Practices - Accordion Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/accordion/)

