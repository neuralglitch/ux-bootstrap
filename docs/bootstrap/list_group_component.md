# List Group Component

The `bs:list-group` component provides a flexible and powerful way to display series of content based on Bootstrap 5.3's list group component.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [List Group Props](#list-group-props)
- [List Group Item Props](#list-group-item-props)
- [Examples](#examples)
  - [Basic List](#basic-list)
  - [Active Items](#active-items)
  - [Links and Buttons](#links-and-buttons)
  - [Flush Style](#flush-style)
  - [Numbered Lists](#numbered-lists)
  - [Horizontal Layout](#horizontal-layout)
  - [Color Variants](#color-variants)
  - [With Badges](#with-badges)
  - [Custom Content](#custom-content)
  - [Disabled Items](#disabled-items)
  - [Tab Behavior](#tab-behavior)
- [Accessibility](#accessibility)
- [Configuration](#configuration)
- [Testing](#testing)

## Overview

The list-group component consists of two components:
- **`bs:list-group`**: The container component
- **`bs:list-group-item`**: Individual list items

The components support all Bootstrap 5.3 list group features including:
- Basic lists with `<ul>`/`<li>` or `<div>` elements
- Action items with `<a>` or `<button>` elements
- Active and disabled states
- Color variants
- Flush style (no borders/rounded corners)
- Numbered lists
- Horizontal layouts (responsive)
- Custom content with complex HTML
- Full accessibility support

## Basic Usage

```twig
{# Simple list #}
<twig:bs:list-group>
  <twig:bs:list-group-item>An item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>
```

## Component Structure

### Parent Component: `bs:list-group`

The container that wraps all list items.

### Child Component: `bs:list-group-item`

Individual items within the list. Can be:
- Static list items (`<li>`)
- Action items (`<a>` or `<button>`)

## List Group Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `flush` | `bool` | `false` | Remove borders and rounded corners |
| `numbered` | `bool` | `false` | Add numbers to list items (auto-sets tag to `ol`) |
| `horizontal` | `?string` | `null` | Make horizontal at breakpoint: `null`, `'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'`, or `true` (always) |
| `tag` | `?string` | `'ul'` | HTML tag: `'ul'`, `'ol'`, or `'div'` (auto-detected for numbered lists) |
| `id` | `?string` | `null` | Unique identifier for the list group |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## List Group Item Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `tag` | `?string` | `'li'` | HTML tag: `'li'`, `'a'`, or `'button'` (auto-detected from `href` or `action`) |
| `href` | `?string` | `null` | URL for link items (auto-sets tag to `'a'`) |
| `target` | `?string` | `null` | Link target: `'_blank'`, `'_self'`, etc. |
| `rel` | `?string` | `null` | Link relationship: `'noopener'`, `'noreferrer'`, etc. |
| `action` | `bool` | `false` | Add hover/focus styles (auto-enabled for links/buttons) |
| `active` | `bool` | `false` | Mark as active/current item |
| `disabled` | `bool` | `false` | Disable the item |
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `label` | `?string` | `null` | Text content (alternative to content block) |
| `ariaLabel` | `?string` | `null` | Accessible label |
| `ariaCurrent` | `?string` | `'true'` | ARIA current value (auto-set to `'true'` for active items) |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Basic List

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item>An item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A fourth item</twig:bs:list-group-item>
  <twig:bs:list-group-item>And a fifth one</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Active Items

Use the `active` prop to highlight the current selection:

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item :active="true">An active item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Links and Buttons

Create actionable list items with links or buttons:

```twig
{# Links #}
<twig:bs:list-group>
  <twig:bs:list-group-item href="#" :active="true">
    The current link item
  </twig:bs:list-group-item>
  <twig:bs:list-group-item href="#">A second link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#">A third link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#" :disabled="true">A disabled link item</twig:bs:list-group-item>
</twig:bs:list-group>

{# Buttons #}
<twig:bs:list-group>
  <twig:bs:list-group-item tag="button" :active="true">
    The current button
  </twig:bs:list-group-item>
  <twig:bs:list-group-item tag="button">A second button item</twig:bs:list-group-item>
  <twig:bs:list-group-item tag="button">A third button item</twig:bs:list-group-item>
  <twig:bs:list-group-item tag="button" :disabled="true">A disabled button item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Flush Style

Remove borders and rounded corners for edge-to-edge display:

```twig
<twig:bs:list-group :flush="true">
  <twig:bs:list-group-item>An item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Numbered Lists

Add automatic numbering to list items:

```twig
<twig:bs:list-group :numbered="true">
  <twig:bs:list-group-item>A list item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A list item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A list item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Horizontal Layout

Make the list display horizontally at specific breakpoints:

```twig
{# Always horizontal #}
<twig:bs:list-group :horizontal="true">
  <twig:bs:list-group-item>An item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>

{# Horizontal at medium breakpoint and up #}
<twig:bs:list-group horizontal="md">
  <twig:bs:list-group-item>An item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Color Variants

Apply contextual color variants to items:

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item>Default item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="primary">Primary item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="secondary">Secondary item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="success">Success item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="danger">Danger item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="warning">Warning item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="info">Info item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="light">Light item</twig:bs:list-group-item>
  <twig:bs:list-group-item variant="dark">Dark item</twig:bs:list-group-item>
</twig:bs:list-group>
```

Variants also work with action items:

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item href="#" variant="primary">Primary link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#" variant="success">Success link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#" variant="danger">Danger link item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### With Badges

Combine with the `bs:badge` component for counts or status:

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item class="d-flex justify-content-between align-items-center">
    Inbox
    <twig:bs:badge variant="primary" :pill="true">14</twig:bs:badge>
  </twig:bs:list-group-item>
  <twig:bs:list-group-item class="d-flex justify-content-between align-items-center">
    Updates
    <twig:bs:badge variant="primary" :pill="true">2</twig:bs:badge>
  </twig:bs:list-group-item>
  <twig:bs:list-group-item class="d-flex justify-content-between align-items-center">
    Messages
    <twig:bs:badge variant="primary" :pill="true">1</twig:bs:badge>
  </twig:bs:list-group-item>
</twig:bs:list-group>
```

### Custom Content

List items can contain complex HTML:

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item href="#" :active="true">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">List group item heading</h5>
      <small>3 days ago</small>
    </div>
    <p class="mb-1">Some placeholder content in a paragraph.</p>
    <small>And some small print.</small>
  </twig:bs:list-group-item>
  <twig:bs:list-group-item href="#">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">List group item heading</h5>
      <small class="text-body-secondary">3 days ago</small>
    </div>
    <p class="mb-1">Some placeholder content in a paragraph.</p>
    <small class="text-body-secondary">And some muted small print.</small>
  </twig:bs:list-group-item>
</twig:bs:list-group>
```

### Numbered with Custom Content

```twig
<twig:bs:list-group :numbered="true">
  <twig:bs:list-group-item class="d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Subheading</div>
      Content for list item
    </div>
    <twig:bs:badge variant="primary" :pill="true">14</twig:bs:badge>
  </twig:bs:list-group-item>
  <twig:bs:list-group-item class="d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Subheading</div>
      Content for list item
    </div>
    <twig:bs:badge variant="primary" :pill="true">14</twig:bs:badge>
  </twig:bs:list-group-item>
</twig:bs:list-group>
```

### Disabled Items

```twig
<twig:bs:list-group>
  <twig:bs:list-group-item :disabled="true">A disabled item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A second item</twig:bs:list-group-item>
  <twig:bs:list-group-item>A third item</twig:bs:list-group-item>
</twig:bs:list-group>

{# For action items #}
<twig:bs:list-group>
  <twig:bs:list-group-item href="#" :disabled="true">A disabled link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#">A second link item</twig:bs:list-group-item>
  <twig:bs:list-group-item href="#">A third link item</twig:bs:list-group-item>
</twig:bs:list-group>
```

### Tab Behavior

Use with Bootstrap's tab JavaScript to create tabbed interfaces:

```twig
<div class="row">
  <div class="col-4">
    <twig:bs:list-group id="list-tab" role="tablist">
      <twig:bs:list-group-item 
        href="#list-home" 
        :active="true"
        :attr="{
          'data-bs-toggle': 'list',
          'role': 'tab',
          'aria-controls': 'list-home'
        }">
        Home
      </twig:bs:list-group-item>
      <twig:bs:list-group-item 
        href="#list-profile"
        :attr="{
          'data-bs-toggle': 'list',
          'role': 'tab',
          'aria-controls': 'list-profile'
        }">
        Profile
      </twig:bs:list-group-item>
      <twig:bs:list-group-item 
        href="#list-messages"
        :attr="{
          'data-bs-toggle': 'list',
          'role': 'tab',
          'aria-controls': 'list-messages'
        }">
        Messages
      </twig:bs:list-group-item>
    </twig:bs:list-group>
  </div>
  <div class="col-8">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="list-home" role="tabpanel">
        Home content...
      </div>
      <div class="tab-pane fade" id="list-profile" role="tabpanel">
        Profile content...
      </div>
      <div class="tab-pane fade" id="list-messages" role="tabpanel">
        Messages content...
      </div>
    </div>
  </div>
</div>
```

## Accessibility

The list-group component follows accessibility best practices:

### Semantic HTML
- Uses appropriate semantic elements (`<ul>`, `<ol>`, `<li>`, `<a>`, `<button>`)
- Auto-selects correct tag based on props

### ARIA Attributes
- **Active items**: Automatically adds `aria-current="true"` to active items
- **Disabled items**: Adds appropriate `disabled` attribute for buttons or `aria-disabled="true"` for links
- **Tab behavior**: Support for `role`, `aria-controls`, etc. through `attr` prop

### Keyboard Navigation
- **Links**: Navigable via Tab key, activated with Enter
- **Buttons**: Navigable via Tab key, activated with Enter or Space
- **Tab interfaces**: Support full keyboard navigation when using Bootstrap's tab JavaScript

### Screen Readers
- Semantic HTML elements announce correctly
- ARIA attributes provide additional context
- Active/disabled states are announced properly

### Best Practices
1. Use semantic elements (`<a>` for links, `<button>` for actions)
2. Always provide meaningful link text (avoid "Click here")
3. For tab interfaces, include proper ARIA roles
4. Use `ariaLabel` prop when visual text isn't sufficient
5. For custom content, ensure color isn't the only indicator (use icons or text)

## Configuration

Default values can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  list_group:
    flush: false
    numbered: false
    horizontal: null
    tag: 'ul'
    id: null
    class: null
    attr: {  }

  list_group_item:
    tag: 'li'
    action: false
    active: false
    disabled: false
    variant: null
    target: null
    rel: null
    class: null
    attr: {  }
```

Example configuration:

```yaml
neuralglitch_ux_bootstrap:
  list_group:
    class: 'shadow-sm'  # Add shadow to all list groups by default

  list_group_item:
    target: '_blank'    # Open all link items in new tab by default
    rel: 'noopener noreferrer'
```

## Testing

### Run Tests

```bash
# Run all tests
bin/php-in-docker vendor/bin/phpunit

# Run only list-group tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/ListGroupTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/ListGroupItemTest.php
```

### Test Coverage

The test suite covers:
- All prop variations and combinations
- Auto-detection of tags based on props
- Active/disabled states
- Color variants
- Horizontal layouts
- Custom classes and attributes
- Configuration defaults
- ARIA attribute generation

## Related Components

- **[Badge](BADGE_COMPONENT.md)**: Use with list items for counts/status
- **[Accordion](ACCORDION_COMPONENT.md)**: Similar collapsible component
- **[Card](CARD_COMPONENT.md)**: Can contain list groups

## References

- [Bootstrap 5.3 List Group Documentation](https://getbootstrap.com/docs/5.3/components/list-group/)
- [MDN: `<ul>` Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ul)
- [MDN: `<ol>` Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ol)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

