# Dropdown Multi Component

## Overview

The **Dropdown Multi** component (`bs:dropdown-multi`) is an Extra component that provides a multi-select dropdown interface with checkboxes. It's perfect for filtering, selecting permissions, choosing categories, or picking multiple tags. The component features search functionality, bulk actions (select all/clear), and customizable display options.

## Basic Usage

### Simple Multi-Select

```twig
<twig:bs:dropdown-multi
    label="Select Categories"
    name="categories"
    :options="[
        {value: '1', label: 'Technology', selected: false},
        {value: '2', label: 'Business', selected: true},
        {value: '3', label: 'Design', selected: false},
        {value: '4', label: 'Marketing', selected: false}
    ]"
/>
```

### With Search

```twig
<twig:bs:dropdown-multi
    label="Select Permissions"
    name="permissions"
    :searchable="true"
    searchPlaceholder="Search permissions..."
    :options="permissionOptions"
/>
```

### Filters with Apply Button

```twig
<twig:bs:dropdown-multi
    label="Filter Products"
    placeholder="All products"
    variant="outline-primary"
    :showApply="true"
    :options="filterOptions"
/>
```

## Component Props

### Label and Display

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `?string` | `'Select options'` | Button label |
| `placeholder` | `?string` | `null` | Placeholder when nothing selected (defaults to label) |

### Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `options` | `array` | `[]` | Array of options (see Options Array Structure below) |

**Options Array Structure:**
```php
[
    [
        'value' => 'unique-id',      // Required: The value
        'label' => 'Display Text',   // Required: Display label
        'selected' => false,         // Optional: Initially selected?
        'disabled' => false,         // Optional: Disabled option?
        'description' => 'Details'   // Optional: Additional description
    ]
]
```

### Button Styling

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `'secondary'` | Bootstrap color variant |
| `outline` | `bool` | `false` | Outline button style |
| `size` | `?string` | `null` | Button size: `'sm'`, `'lg'` |

### Dropdown Behavior

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `direction` | `?string` | `null` | Direction: `'dropup'`, `'dropend'`, `'dropstart'`, `'dropup-center'`, `'dropdown-center'` |
| `menuAlign` | `?string` | `null` | Menu alignment: `'end'`, responsive like `'lg-end'` |
| `dark` | `bool` | `false` | Dark dropdown menu |
| `autoClose` | `?string` | `'outside'` | Auto-close behavior: `'true'`, `'false'`, `'inside'`, `'outside'` |

### Search Functionality

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `searchable` | `bool` | `false` | Enable search/filter |
| `searchPlaceholder` | `?string` | `'Search...'` | Search input placeholder |
| `searchMinChars` | `int` | `0` | Minimum characters before filtering |

### Action Buttons

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showSelectAll` | `bool` | `true` | Show "Select All" button |
| `showClear` | `bool` | `true` | Show "Clear" button |
| `showApply` | `bool` | `false` | Show "Apply" button (selections only apply when clicked) |
| `selectAllLabel` | `?string` | `'Select All'` | Label for select all button |
| `clearLabel` | `?string` | `'Clear'` | Label for clear button |
| `applyLabel` | `?string` | `'Apply'` | Label for apply button |

### Display Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showCount` | `bool` | `true` | Show count in button label |
| `countFormat` | `?string` | `'{count} selected'` | Format for count display |
| `showChecks` | `bool` | `true` | Show checkmarks in menu |
| `maxDisplay` | `int` | `3` | Max items to show in button label before showing count |

### Form Integration

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `?string` | `null` | Form field name (automatically appends `[]`) |
| `required` | `bool` | `false` | Mark as required field |

### Styling

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `toggleClass` | `?string` | `null` | Additional classes for toggle button |
| `menuClass` | `?string` | `null` | Additional classes for dropdown menu |
| `maxHeight` | `?string` | `'300px'` | Max height of options list |
| `menuAttr` | `array` | `[]` | Additional attributes for menu |
| `class` | `?string` | `null` | Additional wrapper classes |
| `attr` | `array` | `[]` | Additional wrapper attributes |

## Examples

### Use Case: Filters

**Product filtering with multiple categories:**

```twig
<twig:bs:dropdown-multi
    label="Categories"
    placeholder="All categories"
    variant="outline-secondary"
    name="category_filter"
    :searchable="true"
    :maxDisplay="2"
    :options="[
        {value: 'electronics', label: 'Electronics', selected: false},
        {value: 'clothing', label: 'Clothing', selected: true},
        {value: 'books', label: 'Books', selected: false},
        {value: 'home', label: 'Home & Garden', selected: false},
        {value: 'sports', label: 'Sports & Outdoors', selected: false}
    ]"
/>
```

### Use Case: Permissions Selection

**User role permissions with descriptions:**

```twig
<twig:bs:dropdown-multi
    label="Permissions"
    name="user_permissions"
    variant="primary"
    :searchable="true"
    searchPlaceholder="Search permissions..."
    :showApply="true"
    :options="[
        {
            value: 'users.view',
            label: 'View Users',
            description: 'Can view user profiles',
            selected: true
        },
        {
            value: 'users.edit',
            label: 'Edit Users',
            description: 'Can modify user profiles',
            selected: true
        },
        {
            value: 'users.delete',
            label: 'Delete Users',
            description: 'Can remove users',
            selected: false,
            disabled: true
        },
        {
            value: 'content.publish',
            label: 'Publish Content',
            description: 'Can publish posts and pages',
            selected: false
        }
    ]"
/>
```

### Use Case: Tag Selection

**Article tagging system:**

```twig
<twig:bs:dropdown-multi
    label="Tags"
    placeholder="Select tags..."
    name="article_tags"
    variant="outline-success"
    size="sm"
    :searchable="true"
    :showApply="false"
    :maxDisplay="5"
    countFormat="{count} tags"
    :options="tags"
/>
```

### Use Case: Category Selection

**Multi-level category selection:**

```twig
<twig:bs:dropdown-multi
    label="Product Categories"
    name="product_categories"
    :searchable="true"
    searchPlaceholder="Find category..."
    :showSelectAll="false"
    :options="categoryTree"
/>
```

### Advanced: Conditional Display

```twig
{% set statusFilters = [
    {value: 'draft', label: 'Draft', selected: false},
    {value: 'published', label: 'Published', selected: true},
    {value: 'archived', label: 'Archived', selected: false}
] %}

<twig:bs:dropdown-multi
    label="Status"
    name="status[]"
    variant="info"
    :options="statusFilters"
    :showApply="true"
    applyLabel="Filter"
    maxHeight="200px"
/>
```

### With Custom Styling

```twig
<twig:bs:dropdown-multi
    label="Custom Dropdown"
    variant="dark"
    :dark="true"
    toggleClass="shadow"
    menuClass="border-primary"
    class="mb-3"
    :attr="{
        'data-analytics': 'filter-dropdown'
    }"
    :options="customOptions"
/>
```

## JavaScript API

The component includes a Stimulus controller (`bs-dropdown-multi`) with a public API:

### Methods

```javascript
// Get the controller instance
const dropdown = document.querySelector('[data-controller="bs-dropdown-multi"]');
const controller = this.application.getControllerForElementAndIdentifier(dropdown, 'bs-dropdown-multi');

// Set selected values programmatically
controller.setSelected(['value1', 'value2', 'value3']);

// Get currently selected values
const selected = controller.getSelected(); // Returns: ['value1', 'value2']

// Clear all selections
controller.clear();

// Get selected count
const count = controller.getSelectedCount(); // Returns: 2
```

### Events

The component dispatches custom events:

```javascript
// Listen for selection changes
dropdown.addEventListener('bs-dropdown-multi:change', (event) => {
    console.log('Selected values:', event.detail.selected);
    console.log('Count:', event.detail.count);
});
```

**Event Detail:**
```javascript
{
    selected: ['value1', 'value2'],  // Array of selected values
    count: 2                         // Number of selections
}
```

### Example: Form Integration

```twig
<form method="post" action="/filter">
    <twig:bs:dropdown-multi
        label="Categories"
        name="categories"
        :options="categories"
        :attr="{'data-action': 'bs-dropdown-multi:change->form#autoSubmit'}"
    />
</form>

<script>
// Auto-submit form on selection change
document.querySelector('[data-controller="bs-dropdown-multi"]')
    .addEventListener('bs-dropdown-multi:change', (event) => {
        // Optionally wait for "Apply" button or auto-submit
        if (!event.target.dataset.bsDropdownMultiShowApplyValue) {
            event.target.closest('form').submit();
        }
    });
</script>
```

## Accessibility

The component follows Bootstrap's accessibility guidelines:

- **Keyboard Navigation**: Full keyboard support with arrow keys, Enter, and Escape
- **ARIA Attributes**: Proper `aria-expanded`, `aria-labelledby` attributes
- **Screen Reader Support**: Labels and descriptions are properly associated
- **Focus Management**: Focus is managed when dropdown opens/closes

### Best Practices

1. **Provide Clear Labels**: Use descriptive labels for the button and options
2. **Use Descriptions**: Add descriptions for complex options to aid understanding
3. **Limit Options**: For long lists, enable search to help users find items quickly
4. **Visual Feedback**: The component shows selected items in the button label
5. **Required Fields**: Mark required fields and provide validation feedback

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  dropdown_multi:
    label: 'Select options'
    placeholder: null
    variant: 'secondary'
    outline: false
    size: null
    direction: null
    menu_align: null
    dark: false
    auto_close: 'outside'
    searchable: false
    search_placeholder: 'Search...'
    search_min_chars: 0
    show_select_all: true
    show_clear: true
    show_apply: false
    select_all_label: 'Select All'
    clear_label: 'Clear'
    apply_label: 'Apply'
    show_count: true
    count_format: '{count} selected'
    show_checks: true
    max_display: 3
    name: null
    required: false
    toggle_class: null
    menu_class: null
    max_height: '300px'
    menu_attr: {}
    class: null
    attr: {}
    stimulus_controller: 'bs-dropdown-multi'
```

## Testing

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/DropdownMultiTest.php
```

Test coverage includes:
- Default options rendering
- Label generation with different selection counts
- Search functionality
- Apply button behavior
- Form integration
- Custom styling and attributes
- All configuration options

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Requires Bootstrap 5.3+ JavaScript
- Stimulus 3.x

## Related Components

- **Dropdown** (`bs:dropdown`) - Single-select dropdown
- **Button Group** (`bs:button-group`) - Button groups
- **Form Select** - Native select element for simple dropdowns

## References

- [Bootstrap Dropdowns Documentation](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [Bootstrap Forms Documentation](https://getbootstrap.com/docs/5.3/forms/overview/)
- [Stimulus Documentation](https://stimulus.hotwired.dev/)

## Tips & Tricks

### Dynamic Options from Controller

```php
// In your Symfony controller
public function index(): Response
{
    $categories = $this->categoryRepository->findAll();
    
    $categoryOptions = array_map(fn($cat) => [
        'value' => (string) $cat->getId(),
        'label' => $cat->getName(),
        'selected' => $cat->isDefault(),
        'disabled' => !$cat->isActive(),
    ], $categories);
    
    return $this->render('page/index.html.twig', [
        'categoryOptions' => $categoryOptions,
    ]);
}
```

### Styling Selected Items

The component automatically updates the button label, but you can customize the appearance:

```css
/* Highlight the dropdown button when items are selected */
[data-bs-dropdown-multi-target="toggle"]:has(+ .show) {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Custom checkbox styling */
.dropdown-menu .form-check-input:checked {
    background-color: var(--bs-success);
    border-color: var(--bs-success);
}
```

### Performance with Large Lists

For lists with 100+ items:

1. Enable `searchable` to help users find items
2. Set reasonable `maxHeight` (e.g., `300px`)
3. Consider lazy-loading options via AJAX for very large datasets
4. Use `searchMinChars` to delay filtering until user types enough characters

### Validation

```twig
<form method="post">
    <twig:bs:dropdown-multi
        label="Required Categories"
        name="categories"
        :required="true"
        :options="categories"
    />
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
// Custom validation
document.querySelector('form').addEventListener('submit', (e) => {
    const controller = // get controller instance
    const selected = controller.getSelected();
    
    if (selected.length === 0) {
        e.preventDefault();
        alert('Please select at least one category');
    }
});
</script>
```

