# Accordion Component

Bootstrap 5.3 Accordion component implementation for Symfony UX Bootstrap.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Props](#component-props)
- [Examples](#examples)
- [Configuration](#configuration)
- [Accessibility](#accessibility)

## Overview

The Accordion component provides a collapsible content area based on Bootstrap 5.3's accordion. It consists of two components:

- `<twig:bs:accordion>` - Container component
- `<twig:bs:accordion-item>` - Individual accordion items

The accordion uses Bootstrap's collapse JavaScript plugin internally to handle the expand/collapse functionality.

## Basic Usage

### Simple Accordion

```twig
<twig:bs:accordion>
    <twig:bs:accordion-item 
        title="Accordion Item #1" 
        :show="true"
        :parentId="'accordionExample'">
        <strong>This is the first item's accordion body.</strong> 
        It is shown by default.
    </twig:bs:accordion-item>
    
    <twig:bs:accordion-item 
        title="Accordion Item #2"
        :parentId="'accordionExample'">
        <strong>This is the second item's accordion body.</strong>
        It is hidden by default.
    </twig:bs:accordion-item>
    
    <twig:bs:accordion-item 
        title="Accordion Item #3"
        :parentId="'accordionExample'">
        <strong>This is the third item's accordion body.</strong>
        It is hidden by default.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### Flush Accordion

Add `:flush="true"` to remove borders and rounded corners for an edge-to-edge design:

```twig
<twig:bs:accordion :flush="true" id="accordionFlush">
    <twig:bs:accordion-item 
        title="Flush Item #1"
        :parentId="'accordionFlush'">
        Content for flush accordion item.
    </twig:bs:accordion-item>
    
    <twig:bs:accordion-item 
        title="Flush Item #2"
        :parentId="'accordionFlush'">
        More content here.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### Always Open Accordion

By omitting the `parentId` prop, accordion items will stay open when another item is opened:

```twig
<twig:bs:accordion :alwaysOpen="true">
    <twig:bs:accordion-item title="Item #1" :show="true">
        This item is open by default.
    </twig:bs:accordion-item>
    
    <twig:bs:accordion-item title="Item #2">
        This item can be opened without closing the first.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

## Component Props

### Accordion (Container)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string\|null` | `null` | Accordion ID (auto-generated if not provided) |
| `flush` | `bool` | `false` | Removes borders and rounded corners |
| `alwaysOpen` | `bool` | `false` | Allow multiple items to stay open |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### AccordionItem

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string\|null` | `null` | Item header text (supports HTML) |
| `targetId` | `string\|null` | `null` | Collapse target ID (auto-generated if not provided) |
| `parentId` | `string\|null` | `null` | Parent accordion ID (for single-item-open behavior) |
| `show` | `bool` | `false` | Whether item is initially expanded |
| `collapsed` | `bool` | `true` | Whether button has collapsed class |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### With Custom ID

```twig
<twig:bs:accordion id="myAccordion">
    <twig:bs:accordion-item 
        title="Custom ID Item"
        targetId="customTarget"
        :parentId="'myAccordion'">
        Content with custom IDs.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### With Custom Classes

```twig
<twig:bs:accordion class="shadow-sm">
    <twig:bs:accordion-item 
        title="Styled Item"
        class="my-custom-item"
        :parentId="'accordionExample'">
        Custom styled accordion item.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### With Custom Attributes

```twig
<twig:bs:accordion :attr="{'data-testid': 'main-accordion'}">
    <twig:bs:accordion-item 
        title="Item with Attributes"
        :attr="{'data-item': 'first'}"
        :parentId="'accordionExample'">
        Item with custom data attributes.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### Rich Content in Title

```twig
<twig:bs:accordion>
    <twig:bs:accordion-item 
        title="<span class='badge bg-primary me-2'>New</span> Featured Item"
        :parentId="'accordionExample'">
        The title prop supports HTML for rich content.
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

### Complex Body Content

```twig
<twig:bs:accordion>
    <twig:bs:accordion-item 
        title="Item with Complex Content"
        :parentId="'accordionExample'">
        <div class="row">
            <div class="col-md-6">
                <h5>Left Column</h5>
                <p>Some content here...</p>
            </div>
            <div class="col-md-6">
                <h5>Right Column</h5>
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                </ul>
            </div>
        </div>
        <twig:bs:button variant="primary">Action Button</twig:bs:button>
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

## Configuration

Configure default values globally in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  accordion:
    flush: false
    always_open: false
    id: null
    class: null
    attr: {  }

  accordion_item:
    show: false
    collapsed: true
    target_id: null
    class: null
    attr: {  }
```

### Override Defaults Per Instance

```twig
{# Uses global defaults #}
<twig:bs:accordion>
    ...
</twig:bs:accordion>

{# Overrides with flush variant #}
<twig:bs:accordion :flush="true">
    ...
</twig:bs:accordion>
```

## Accessibility

The accordion component follows Bootstrap's accessibility best practices:

### ARIA Attributes

- **`aria-expanded`**: Automatically set on accordion buttons (`true` when open, `false` when closed)
- **`aria-controls`**: Links button to the collapsible content it controls
- **`aria-labelledby`**: References the accordion header from the collapsible content

### Keyboard Navigation

- **Tab**: Navigate between accordion buttons
- **Enter** or **Space**: Toggle the focused accordion item
- **Arrow Keys**: Not implemented (Bootstrap default behavior)

### Screen Readers

- Accordion buttons announce their state (expanded/collapsed)
- Content is properly associated with headers via ARIA attributes
- Semantic HTML (`<h2>` for headers) provides document structure

### Best Practices

1. **Use descriptive titles**: Make sure accordion titles clearly describe the content
2. **Don't nest accordions**: Avoid placing accordions inside accordion items
3. **Provide context**: If the accordion is the main content, consider adding an `aria-label` to the container
4. **Test with screen readers**: Verify the experience with actual assistive technology

## Browser Support

Works in all browsers supported by Bootstrap 5.3:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- iOS Safari (latest)
- Chrome for Android (latest)

## Animation

The accordion uses Bootstrap's collapse transition:

- **Duration**: 0.35s (Bootstrap default)
- **Easing**: CSS transition timing
- **Respects `prefers-reduced-motion`**: Animations are disabled if user prefers reduced motion

## Related Components

- **Collapse** - Lower-level collapse functionality
- **Card** - Similar container component
- **Modal** - Alternative for hiding/showing content

## Troubleshooting

### Items don't close when opening another

**Problem**: All items stay open when clicking on a new one.

**Solution**: Make sure all items have the same `parentId` that matches the accordion's `id`:

```twig
<twig:bs:accordion id="myAccordion">
    <twig:bs:accordion-item :parentId="'myAccordion'">...</twig:bs:accordion-item>
    <twig:bs:accordion-item :parentId="'myAccordion'">...</twig:bs:accordion-item>
</twig:bs:accordion>
```

### Accordion not working

**Problem**: Accordion doesn't expand/collapse.

**Solution**: Ensure Bootstrap JavaScript is loaded:

```twig
{# templates/base.html.twig #}
{{ importmap('bootstrap') }}
```

### IDs are duplicated

**Problem**: Multiple accordions have the same ID.

**Solution**: Provide unique IDs or let the component auto-generate them:

```twig
<twig:bs:accordion id="accordion1">...</twig:bs:accordion>
<twig:bs:accordion id="accordion2">...</twig:bs:accordion>
```

## Examples from Bootstrap Documentation

The component is fully compatible with [Bootstrap 5.3 Accordion examples](https://getbootstrap.com/docs/5.3/components/accordion/).

Convert Bootstrap HTML to Twig components:

**Bootstrap HTML:**
```html
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" 
              data-bs-toggle="collapse" data-bs-target="#collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show">
      <div class="accordion-body">Content here</div>
    </div>
  </div>
</div>
```

**Twig Component:**
```twig
<twig:bs:accordion id="accordionExample">
    <twig:bs:accordion-item 
        title="Accordion Item #1" 
        targetId="collapseOne"
        :show="true"
        :parentId="'accordionExample'">
        Content here
    </twig:bs:accordion-item>
</twig:bs:accordion>
```

## See Also

- [Bootstrap 5.3 Accordion Documentation](https://getbootstrap.com/docs/5.3/components/accordion/)
- [Bootstrap Collapse Plugin](https://getbootstrap.com/docs/5.3/components/collapse/)
- [ARIA Accordion Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/accordion/)

