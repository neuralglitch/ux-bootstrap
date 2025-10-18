# Button Group Component

## Overview

The Button Group component (`bs:button-group`) groups a series of buttons together on a single line or stacks them vertically. It's a Bootstrap 5.3 component that provides a clean, grouped appearance for related button actions.

**Component Tag**: `<twig:bs:button-group>`

## Basic Usage

### Horizontal Button Group

```twig
<twig:bs:button-group ariaLabel="Basic button group">
    <twig:bs:button variant="primary">Left</twig:bs:button>
    <twig:bs:button variant="primary">Middle</twig:bs:button>
    <twig:bs:button variant="primary">Right</twig:bs:button>
</twig:bs:button-group>
```

### Vertical Button Group

```twig
<twig:bs:button-group :vertical="true" ariaLabel="Vertical button group">
    <twig:bs:button variant="primary">Button 1</twig:bs:button>
    <twig:bs:button variant="primary">Button 2</twig:bs:button>
    <twig:bs:button variant="primary">Button 3</twig:bs:button>
</twig:bs:button-group>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `vertical` | `bool` | `false` | Stack buttons vertically instead of horizontally |
| `size` | `?string` | `null` | Size variant: `'sm'`, `'lg'`, or `null` for default |
| `role` | `string` | `'group'` | ARIA role: typically `'group'` or `'toolbar'` |
| `ariaLabel` | `?string` | `null` | ARIA label for accessibility |
| `ariaLabelledby` | `?string` | `null` | ARIA labelledby reference (alternative to ariaLabel) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Mixed Button Styles

```twig
<twig:bs:button-group ariaLabel="Mixed styles">
    <twig:bs:button variant="danger">Left</twig:bs:button>
    <twig:bs:button variant="warning">Middle</twig:bs:button>
    <twig:bs:button variant="success">Right</twig:bs:button>
</twig:bs:button-group>
```

### Outlined Button Group

```twig
<twig:bs:button-group ariaLabel="Outlined button group">
    <twig:bs:button variant="primary" :outline="true">Left</twig:bs:button>
    <twig:bs:button variant="primary" :outline="true">Middle</twig:bs:button>
    <twig:bs:button variant="primary" :outline="true">Right</twig:bs:button>
</twig:bs:button-group>
```

### Large Button Group

```twig
<twig:bs:button-group size="lg" ariaLabel="Large button group">
    <twig:bs:button variant="primary">Left</twig:bs:button>
    <twig:bs:button variant="primary">Middle</twig:bs:button>
    <twig:bs:button variant="primary">Right</twig:bs:button>
</twig:bs:button-group>
```

### Small Button Group

```twig
<twig:bs:button-group size="sm" ariaLabel="Small button group">
    <twig:bs:button variant="primary">Left</twig:bs:button>
    <twig:bs:button variant="primary">Middle</twig:bs:button>
    <twig:bs:button variant="primary">Right</twig:bs:button>
</twig:bs:button-group>
```

### Button Toolbar

Combine multiple button groups into a toolbar:

```twig
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <twig:bs:button-group class="me-2" ariaLabel="First group">
        <twig:bs:button variant="primary">1</twig:bs:button>
        <twig:bs:button variant="primary">2</twig:bs:button>
        <twig:bs:button variant="primary">3</twig:bs:button>
        <twig:bs:button variant="primary">4</twig:bs:button>
    </twig:bs:button-group>
    
    <twig:bs:button-group class="me-2" ariaLabel="Second group">
        <twig:bs:button variant="secondary">5</twig:bs:button>
        <twig:bs:button variant="secondary">6</twig:bs:button>
        <twig:bs:button variant="secondary">7</twig:bs:button>
    </twig:bs:button-group>
    
    <twig:bs:button-group ariaLabel="Third group">
        <twig:bs:button variant="info">8</twig:bs:button>
    </twig:bs:button-group>
</div>
```

### With Links

Button groups can also contain links:

```twig
<twig:bs:button-group ariaLabel="Link button group">
    <twig:bs:link href="#" variant="primary" :active="true">Active link</twig:bs:link>
    <twig:bs:link href="#" variant="primary">Link</twig:bs:link>
    <twig:bs:link href="#" variant="primary">Link</twig:bs:link>
</twig:bs:button-group>
```

### Vertical with Mixed Sizes

```twig
<twig:bs:button-group :vertical="true" size="lg" ariaLabel="Vertical large group">
    <twig:bs:button variant="primary">Button 1</twig:bs:button>
    <twig:bs:button variant="primary">Button 2</twig:bs:button>
    <twig:bs:button variant="primary">Button 3</twig:bs:button>
</twig:bs:button-group>
```

### With Custom Attributes

```twig
<twig:bs:button-group 
    ariaLabel="Custom button group"
    :attr="{
        'id': 'my-button-group',
        'data-controller': 'button-group',
        'data-action': 'click->button-group#handleClick'
    }">
    <twig:bs:button variant="primary">Action 1</twig:bs:button>
    <twig:bs:button variant="primary">Action 2</twig:bs:button>
    <twig:bs:button variant="primary">Action 3</twig:bs:button>
</twig:bs:button-group>
```

## Accessibility

### ARIA Labels (Required)

Button groups **must** have an ARIA label for screen readers. Use either:

1. **`ariaLabel`** - Direct label text:
   ```twig
   <twig:bs:button-group ariaLabel="Button group with action buttons">
       {# buttons #}
   </twig:bs:button-group>
   ```

2. **`ariaLabelledby`** - Reference to another element:
   ```twig
   <h3 id="group-label">Actions</h3>
   <twig:bs:button-group ariaLabelledby="group-label">
       {# buttons #}
   </twig:bs:button-group>
   ```

### Role Attribute

- Use `role="group"` for button groups (default)
- Use `role="toolbar"` for button toolbars containing multiple groups

### Button Accessibility

Each button within the group should:
- Have descriptive text or an `aria-label`
- Use proper button semantics (`<button>` or `<a>` with appropriate roles)
- Be keyboard accessible

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  button_group:
    vertical: false
    size: null              # null | 'sm' | 'lg'
    role: 'group'           # 'group' | 'toolbar'
    aria_label: null
    aria_labelledby: null
    class: null
    attr: {  }
```

### Customizing Defaults

Override defaults for all button groups in your application:

```yaml
neuralglitch_ux_bootstrap:
  button_group:
    size: 'sm'              # All button groups default to small
    aria_label: 'Button group'  # Default ARIA label
    class: 'shadow-sm'      # Add shadow to all button groups
```

## Testing

The ButtonGroup component includes comprehensive tests covering:

- Default options
- Vertical orientation
- Size variants (sm, lg)
- ARIA labels and labelledby
- Role attributes
- Custom classes and attributes
- Config defaults
- Edge cases

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/ButtonGroupTest.php
```

## Best Practices

### DO:
- ✅ Always provide an `ariaLabel` or `ariaLabelledby`
- ✅ Use button groups for related actions
- ✅ Keep button text concise and descriptive
- ✅ Use consistent button variants within a group
- ✅ Consider size based on context (toolbar vs. primary actions)

### DON'T:
- ❌ Don't forget ARIA labels (accessibility requirement)
- ❌ Don't mix too many different button styles in one group
- ❌ Don't use button groups for unrelated actions
- ❌ Don't nest button groups without proper toolbar structure
- ❌ Don't use vertical groups in horizontal layouts (confusing UX)

## Related Components

- **[Button Component](button_component.md)** - Individual button component
- **[Link Component](link_component.md)** - Link component styled as button
- **Bootstrap Dropdown** - For dropdown menus in button groups (coming soon)

## References

- [Bootstrap 5.3 Button Group Documentation](https://getbootstrap.com/docs/5.3/components/button-group/)
- [ARIA: group role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/group_role)
- [ARIA: toolbar role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/toolbar_role)

## Examples in Action

### Navigation Actions

```twig
<twig:bs:button-group ariaLabel="Document navigation">
    <twig:bs:button variant="outline-secondary" :disabled="isPrevDisabled">
        Previous
    </twig:bs:button>
    <twig:bs:button variant="outline-secondary" :disabled="isNextDisabled">
        Next
    </twig:bs:button>
</twig:bs:button-group>
```

### Filter Actions

```twig
<twig:bs:button-group ariaLabel="Filter options">
    <twig:bs:button variant="outline-primary" :active="filter == 'all'">
        All
    </twig:bs:button>
    <twig:bs:button variant="outline-primary" :active="filter == 'active'">
        Active
    </twig:bs:button>
    <twig:bs:button variant="outline-primary" :active="filter == 'archived'">
        Archived
    </twig:bs:button>
</twig:bs:button-group>
```

### CRUD Actions

```twig
<twig:bs:button-group ariaLabel="Record actions">
    <twig:bs:button variant="success" iconStart="bi:pencil">
        Edit
    </twig:bs:button>
    <twig:bs:button variant="danger" iconStart="bi:trash">
        Delete
    </twig:bs:button>
    <twig:bs:button variant="secondary" iconStart="bi:files">
        Duplicate
    </twig:bs:button>
</twig:bs:button-group>
```

