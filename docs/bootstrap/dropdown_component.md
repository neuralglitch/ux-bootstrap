# Dropdown Component

## Overview

The Dropdown component provides Bootstrap 5.3 dropdown menus with a clean, component-based API. It supports all Bootstrap dropdown features including split buttons, various directions, menu alignment, dark mode, and flexible auto-close behavior.

## Basic Usage

### Simple Dropdown

```twig
<twig:bs:dropdown label="Actions">
    <twig:bs:dropdown-item label="Action" href="#" />
    <twig:bs:dropdown-item label="Another action" href="#" />
    <twig:bs:dropdown-item label="Something else" href="#" />
</twig:bs:dropdown>
```

### Split Button Dropdown

```twig
<twig:bs:dropdown 
    label="Action" 
    :split="true" 
    variant="primary">
    <twig:bs:dropdown-item label="Action" href="#" />
    <twig:bs:dropdown-item label="Another action" href="#" />
    <twig:bs:dropdown-divider />
    <twig:bs:dropdown-item label="Separated link" href="#" />
</twig:bs:dropdown>
```

## Component Props

### Dropdown Component (`bs:dropdown`)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `string` | `'Dropdown'` | Label for the dropdown toggle button |
| `variant` | `string` | `'secondary'` | Bootstrap color variant (primary, secondary, success, etc.) |
| `outline` | `bool` | `false` | Use outline button style |
| `size` | `string\|null` | `null` | Button size: `'sm'` or `'lg'` |
| `direction` | `string\|null` | `null` | Direction: `'dropup'`, `'dropend'`, `'dropstart'`, `'dropup-center'`, `'dropdown-center'` |
| `menuAlign` | `string\|null` | `null` | Menu alignment: `'end'` or responsive like `'lg-end'` |
| `dark` | `bool` | `false` | Use dark dropdown menu style |
| `split` | `bool` | `false` | Create a split button dropdown |
| `splitLabel` | `string\|null` | `null` | Label for main button in split mode (defaults to `label`) |
| `autoClose` | `string\|null` | `null` | Auto-close behavior: `'true'`, `'false'`, `'inside'`, `'outside'` |
| `toggleClass` | `string\|null` | `null` | Additional CSS classes for toggle button |
| `menuClass` | `string\|null` | `null` | Additional CSS classes for dropdown menu |
| `menuAttr` | `array` | `[]` | Additional HTML attributes for dropdown menu |
| `class` | `string\|null` | `null` | Additional CSS classes for wrapper |
| `attr` | `array` | `[]` | Additional HTML attributes for wrapper |

### DropdownItem Component (`bs:dropdown-item`)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `string\|null` | `null` | Item text (alternative to content block) |
| `href` | `string\|null` | `null` | Link URL (auto-detects tag as `<a>`) |
| `tag` | `string\|null` | `null` | HTML tag: `'a'` or `'button'` (auto-detected) |
| `active` | `bool` | `false` | Mark item as active/current |
| `disabled` | `bool` | `false` | Disable the item |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### DropdownHeader Component (`bs:dropdown-header`)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `string\|null` | `null` | Header text (alternative to content block) |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### DropdownDivider Component (`bs:dropdown-divider`)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### All Button Variants

```twig
{# Primary dropdown #}
<twig:bs:dropdown label="Primary" variant="primary">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Danger dropdown #}
<twig:bs:dropdown label="Danger" variant="danger">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Success outline #}
<twig:bs:dropdown label="Success" variant="success" :outline="true">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>
```

### Button Sizes

```twig
{# Large dropdown #}
<twig:bs:dropdown label="Large" size="lg">
    <twig:bs:dropdown-item label="Action" />
</twig:bs:dropdown>

{# Small dropdown #}
<twig:bs:dropdown label="Small" size="sm">
    <twig:bs:dropdown-item label="Action" />
</twig:bs:dropdown>
```

### Directions

```twig
{# Dropup #}
<twig:bs:dropdown label="Dropup" direction="dropup">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Dropend #}
<twig:bs:dropdown label="Dropend" direction="dropend">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Dropstart #}
<twig:bs:dropdown label="Dropstart" direction="dropstart">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Centered #}
<twig:bs:dropdown label="Centered" direction="dropdown-center">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>
```

### Menu Alignment

```twig
{# Right-aligned menu #}
<twig:bs:dropdown label="Right aligned" menuAlign="end">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>

{# Responsive alignment (right-aligned on lg and above) #}
<twig:bs:dropdown label="Responsive" menuAlign="lg-end">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
</twig:bs:dropdown>
```

### Dark Dropdown

```twig
<twig:bs:dropdown label="Dark menu" :dark="true">
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
    <twig:bs:dropdown-item label="Something else" />
</twig:bs:dropdown>
```

### Menu with Headers and Dividers

```twig
<twig:bs:dropdown label="Menu">
    <twig:bs:dropdown-header label="Section 1" />
    <twig:bs:dropdown-item label="Action" />
    <twig:bs:dropdown-item label="Another action" />
    
    <twig:bs:dropdown-divider />
    
    <twig:bs:dropdown-header label="Section 2" />
    <twig:bs:dropdown-item label="More actions" />
    <twig:bs:dropdown-item label="Even more" />
</twig:bs:dropdown>
```

### Active and Disabled Items

```twig
<twig:bs:dropdown label="Status">
    <twig:bs:dropdown-item label="Active item" :active="true" />
    <twig:bs:dropdown-item label="Regular item" />
    <twig:bs:dropdown-item label="Disabled item" :disabled="true" />
</twig:bs:dropdown>
```

### Auto-Close Behavior

```twig
{# Default: closes on any click #}
<twig:bs:dropdown label="Default">
    <twig:bs:dropdown-item label="Item 1" />
    <twig:bs:dropdown-item label="Item 2" />
</twig:bs:dropdown>

{# Closes only when clicking inside #}
<twig:bs:dropdown label="Close inside" autoClose="inside">
    <twig:bs:dropdown-item label="Item 1" />
    <twig:bs:dropdown-item label="Item 2" />
</twig:bs:dropdown>

{# Closes only when clicking outside #}
<twig:bs:dropdown label="Close outside" autoClose="outside">
    <twig:bs:dropdown-item label="Item 1" />
    <twig:bs:dropdown-item label="Item 2" />
</twig:bs:dropdown>

{# Manual close only #}
<twig:bs:dropdown label="Manual" autoClose="false">
    <twig:bs:dropdown-item label="Item 1" />
    <twig:bs:dropdown-item label="Item 2" />
</twig:bs:dropdown>
```

### Using Content Blocks

```twig
<twig:bs:dropdown label="Actions">
    <twig:bs:dropdown-item href="/edit">
        <i class="bi bi-pencil"></i> Edit
    </twig:bs:dropdown-item>
    
    <twig:bs:dropdown-item href="/delete">
        <i class="bi bi-trash"></i> Delete
    </twig:bs:dropdown-item>
    
    <twig:bs:dropdown-divider />
    
    <twig:bs:dropdown-item href="/archive">
        <i class="bi bi-archive"></i> Archive
    </twig:bs:dropdown-item>
</twig:bs:dropdown>
```

### Split Button with Different Labels

```twig
<twig:bs:dropdown 
    label="Action" 
    splitLabel="Save" 
    :split="true" 
    variant="success">
    <twig:bs:dropdown-item label="Save as draft" />
    <twig:bs:dropdown-item label="Save and continue" />
    <twig:bs:dropdown-item label="Save and close" />
</twig:bs:dropdown>
```

### Custom Classes and Attributes

```twig
<twig:bs:dropdown 
    label="Dropdown" 
    class="my-custom-wrapper"
    toggleClass="my-custom-toggle"
    menuClass="my-custom-menu"
    :attr="{'data-test': 'dropdown'}"
    :menuAttr="{'data-boundary': 'viewport'}">
    <twig:bs:dropdown-item label="Action" />
</twig:bs:dropdown>
```

## Accessibility

The Dropdown component follows Bootstrap's accessibility best practices:

- **ARIA Attributes**: Automatic `aria-expanded` on toggle button
- **Keyboard Navigation**:
  - `Space`/`Enter`: Opens dropdown
  - `Esc`: Closes dropdown
  - Arrow keys: Navigate through items
- **Active State**: Active items include `aria-current="true"`
- **Disabled State**: Disabled items have appropriate `aria-disabled` or `disabled` attributes
- **Screen Readers**: Visual-only toggle indicators use `visually-hidden` class

### Improving Accessibility

```twig
{# Add descriptive label #}
<twig:bs:dropdown 
    label="User actions"
    :attr="{'aria-label': 'User account menu'}">
    <twig:bs:dropdown-item label="Profile" href="/profile" />
    <twig:bs:dropdown-item label="Settings" href="/settings" />
    <twig:bs:dropdown-item label="Logout" href="/logout" />
</twig:bs:dropdown>
```

## Configuration

You can set global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  dropdown:
    label: 'Dropdown'
    variant: 'secondary'
    outline: false
    size: null
    direction: null
    menu_align: null
    dark: false
    split: false
    split_label: null
    auto_close: null
    toggle_class: null
    menu_class: null
    menu_attr: {}
    class: null
    attr: {}

  dropdown_item:
    label: null
    href: null
    tag: null
    active: false
    disabled: false
    class: null
    attr: {}

  dropdown_header:
    label: null
    class: null
    attr: {}

  dropdown_divider:
    class: null
    attr: {}
```

## Testing

Run the dropdown component tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/DropdownTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/DropdownItemTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/DropdownDividerTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/DropdownHeaderTest.php
```

## Related Components

- **Button**: Single action buttons
- **ButtonGroup**: Group multiple buttons
- **Nav**: Navigation components with dropdowns

## References

- [Bootstrap 5.3 Dropdowns Documentation](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [Popper.js](https://popper.js.org/) - Used for positioning
- [ARIA Menu Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/menu/) - Accessibility guidelines

## Advanced Usage

### Dropdown in Navbar

```twig
<twig:bs:navbar brand="My Site">
    <twig:bs:nav>
        <twig:bs:nav-item label="Home" href="/" />
        
        {# Dropdown in navbar #}
        <li class="nav-item">
            <twig:bs:dropdown 
                label="More" 
                variant="link"
                toggleClass="nav-link">
                <twig:bs:dropdown-item label="Action" />
                <twig:bs:dropdown-item label="Another" />
            </twig:bs:dropdown>
        </li>
    </twig:bs:nav>
</twig:bs:navbar>
```

### Form in Dropdown

```twig
<twig:bs:dropdown label="Login" autoClose="false">
    <form class="px-4 py-3" style="min-width: 280px;">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
    
    <twig:bs:dropdown-divider />
    
    <twig:bs:dropdown-item label="New around here? Sign up" href="/register" />
</twig:bs:dropdown>
```

### Dropdowns in Button Groups

```twig
<div class="btn-group" role="group">
    <button type="button" class="btn btn-primary">Left</button>
    <button type="button" class="btn btn-primary">Middle</button>
    
    <twig:bs:dropdown label="Dropdown" variant="primary">
        <twig:bs:dropdown-item label="Action" />
        <twig:bs:dropdown-item label="Another" />
    </twig:bs:dropdown>
</div>
```

