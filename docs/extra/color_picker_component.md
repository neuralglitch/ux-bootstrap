# ColorPicker Component

**Tag**: `<twig:bs:color-picker />`  
**Namespace**: Extra  
**Stimulus Controller**: `bs-color-picker`

## Overview

The ColorPicker component provides an intuitive interface for color selection with preset color swatches and custom color input. It combines preset color buttons, a hex input field, and the native HTML5 color picker for maximum flexibility.

**Key Features**:
- Preset color swatches with visual feedback
- Hex color input with validation
- Native color picker integration
- Fully configurable grid layout
- Inline and block display modes
- Form integration with validation support
- Responsive design with size variants
- Dark mode support

## Basic Usage

### Simple Color Picker

```twig
<twig:bs:color-picker
    name="theme_color"
    label="Theme Color"
/>
```

### With Presets

```twig
<twig:bs:color-picker
    name="brand_color"
    label="Brand Color"
    :presets="['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF']"
/>
```

### With Default Value

```twig
<twig:bs:color-picker
    name="accent_color"
    label="Accent Color"
    value="#FF5733"
    :presets="['#FF5733', '#C70039', '#900C3F', '#581845']"
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | `'color'` | Input field name |
| `value` | `string\|null` | `null` | Current color value (hex format) |
| `label` | `string\|null` | `null` | Label text |
| `required` | `bool` | `false` | Mark field as required |
| `disabled` | `bool` | `false` | Disable the input |
| `presets` | `array` | `[]` | Array of preset hex colors |
| `showPresets` | `bool` | `true` | Show preset color swatches |
| `showInput` | `bool` | `true` | Show text input field |
| `showHex` | `bool` | `true` | Show # prefix for hex input |
| `allowCustom` | `bool` | `true` | Show native color picker |
| `size` | `string` | `'default'` | Component size: `'sm'`, `'default'`, `'lg'` |
| `swatchSize` | `string` | `'default'` | Swatch size: `'sm'`, `'default'`, `'lg'` |
| `columns` | `int` | `6` | Number of columns in preset grid |
| `placeholder` | `string\|null` | `null` | Placeholder text for input |
| `helpText` | `string\|null` | `null` | Help text below input |
| `inline` | `bool` | `false` | Display inline (label and input on same line) |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes for wrapper |
| `inputAttr` | `array` | `[]` | Additional HTML attributes for input field |

## Examples

### Form Integration

```twig
<form method="post">
    <twig:bs:color-picker
        name="primary_color"
        label="Primary Color"
        value="#007bff"
        :presets="['#007bff', '#6c757d', '#28a745', '#dc3545', '#ffc107', '#17a2b8']"
        :required="true"
        helpText="Choose your primary brand color"
    />
    
    <twig:bs:color-picker
        name="secondary_color"
        label="Secondary Color"
        :presets="['#6c757d', '#adb5bd', '#dee2e6']"
    />
    
    <button type="submit" class="btn btn-primary">Save Colors</button>
</form>
```

### Material Design Presets

```twig
{% set materialColors = [
    '#F44336', '#E91E63', '#9C27B0', '#673AB7',
    '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4',
    '#009688', '#4CAF50', '#8BC34A', '#CDDC39',
    '#FFEB3B', '#FFC107', '#FF9800', '#FF5722',
    '#795548', '#9E9E9E', '#607D8B', '#000000'
] %}

<twig:bs:color-picker
    name="material_color"
    label="Material Color"
    :presets="materialColors"
    :columns="5"
    swatchSize="lg"
/>
```

### Bootstrap Theme Colors

```twig
{% set bootstrapColors = [
    '#0d6efd',  {# primary #}
    '#6c757d',  {# secondary #}
    '#198754',  {# success #}
    '#dc3545',  {# danger #}
    '#ffc107',  {# warning #}
    '#0dcaf0',  {# info #}
    '#f8f9fa',  {# light #}
    '#212529',  {# dark #}
] %}

<twig:bs:color-picker
    name="theme_color"
    label="Theme Color"
    :presets="bootstrapColors"
    :columns="4"
/>
```

### Size Variants

```twig
{# Small #}
<twig:bs:color-picker
    name="color_sm"
    label="Small"
    size="sm"
    swatchSize="sm"
    :presets="['#FF0000', '#00FF00', '#0000FF']"
/>

{# Default #}
<twig:bs:color-picker
    name="color_default"
    label="Default"
    size="default"
    :presets="['#FF0000', '#00FF00', '#0000FF']"
/>

{# Large #}
<twig:bs:color-picker
    name="color_lg"
    label="Large"
    size="lg"
    swatchSize="lg"
    :presets="['#FF0000', '#00FF00', '#0000FF']"
/>
```

### Inline Mode

```twig
<div class="d-flex gap-3">
    <twig:bs:color-picker
        name="text_color"
        label="Text Color"
        :inline="true"
        :presets="['#000000', '#212529', '#6c757d']"
    />
    
    <twig:bs:color-picker
        name="bg_color"
        label="Background"
        :inline="true"
        :presets="['#ffffff', '#f8f9fa', '#e9ecef']"
    />
</div>
```

### Presets Only (No Custom Input)

```twig
<twig:bs:color-picker
    name="preset_color"
    label="Select from Presets"
    :presets="['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF']"
    :showInput="false"
    :allowCustom="false"
/>
```

### Custom Colors Only (No Presets)

```twig
<twig:bs:color-picker
    name="custom_color"
    label="Choose Any Color"
    :showPresets="false"
    placeholder="Enter hex color"
/>
```

### Different Column Layouts

```twig
{# 3 columns #}
<twig:bs:color-picker
    name="color_3col"
    :presets="['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF']"
    :columns="3"
/>

{# 4 columns #}
<twig:bs:color-picker
    name="color_4col"
    :presets="['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF', '#000000', '#FFFFFF']"
    :columns="4"
/>

{# 12 columns (single row) #}
<twig:bs:color-picker
    name="color_row"
    :presets="['#FF0000', '#00FF00', '#0000FF', '#FFFF00']"
    :columns="12"
/>
```

### With Validation

```twig
<form method="post" class="needs-validation" novalidate>
    <twig:bs:color-picker
        name="required_color"
        label="Required Color"
        :required="true"
        :presets="['#FF0000', '#00FF00', '#0000FF']"
        helpText="This field is required"
    />
    
    <div class="invalid-feedback">
        Please select or enter a valid color.
    </div>
    
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
```

### With Custom Attributes

```twig
<twig:bs:color-picker
    name="custom_color"
    label="Custom Color"
    :presets="['#FF0000', '#00FF00', '#0000FF']"
    :attr="{
        'data-analytics': 'color-picker',
        'id': 'my-color-picker'
    }"
    :inputAttr="{
        'data-validate': 'color',
        'autocomplete': 'off'
    }"
/>
```

## Accessibility

The ColorPicker component follows accessibility best practices:

1. **Labels**: All inputs have associated labels with proper `for` attributes
2. **Required Fields**: Required fields are marked with `required` attribute and visual indicator (*)
3. **ARIA Attributes**: Swatches include `aria-label` or hidden text for screen readers
4. **Keyboard Navigation**: All interactive elements are keyboard accessible
5. **Color Contrast**: Active swatch indicators have sufficient contrast
6. **Help Text**: Uses `form-text` for additional context
7. **Validation**: Integrates with form validation feedback

### Best Practices

```twig
{# Good: Clear label and help text #}
<twig:bs:color-picker
    name="brand_color"
    label="Brand Color"
    helpText="Choose a color that represents your brand"
    :required="true"
/>

{# Good: Visual and textual indication for required fields #}
<twig:bs:color-picker
    name="theme_color"
    label="Theme Color *"
    :required="true"
/>
```

## Configuration

### Global Configuration

Set default values in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  color_picker:
    # Basic options
    name: 'color'
    value: null
    label: null
    required: false
    disabled: false
    
    # Preset colors
    presets:
      - '#FF0000'
      - '#00FF00'
      - '#0000FF'
      - '#FFFF00'
      - '#FF00FF'
      - '#00FFFF'
    show_presets: true
    columns: 6
    
    # Display options
    show_input: true
    show_hex: true
    allow_custom: true
    
    # Sizing
    size: 'default'
    swatch_size: 'default'
    
    # Additional options
    placeholder: 'Enter hex color'
    help_text: null
    inline: false
    
    # Extensibility
    class: null
    attr: {}
    input_attr: {}
```

### Per-Instance Configuration

Override defaults on a per-instance basis:

```twig
<twig:bs:color-picker
    name="custom_color"
    :presets="['#FF0000', '#00FF00']"
    :columns="2"
    size="lg"
/>
```

## Stimulus Controller

The ColorPicker component uses the `bs-color-picker` Stimulus controller for interactive behavior.

### Targets

- `input`: The hex text input field
- `picker`: The native color picker input
- `hiddenInput`: Hidden input for form submission
- `presets`: Container for preset swatches

### Values

- `value` (String): Current color value
- `showHex` (Boolean): Whether hex format is used
- `allowCustom` (Boolean): Whether custom colors are allowed

### Actions

- `selectColor`: Handle preset swatch selection
- `updateFromInput`: Update color from hex input
- `updateFromPicker`: Update color from native picker

### Custom Events

The controller dispatches a `bs-color-picker:change` event when the color changes:

```javascript
document.querySelector('[data-controller="bs-color-picker"]')
    .addEventListener('bs-color-picker:change', (event) => {
        console.log('New color:', event.detail.color);
    });
```

### JavaScript API

```javascript
// Get controller instance
const picker = this.application.getControllerForElementAndIdentifier(
    element,
    'bs-color-picker'
);

// Set color programmatically
picker.setValue('#FF0000');

// Listen for changes
picker.element.addEventListener('bs-color-picker:change', (e) => {
    console.log('Color changed to:', e.detail.color);
});
```

## Testing

The ColorPicker component has comprehensive test coverage (29 tests, 78 assertions):

```bash
# Run ColorPicker tests
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/ColorPickerTest.php
```

**Test Coverage Includes**:
- Default options
- Name, value, and label options
- Required and disabled states
- Preset colors and display options
- Size variants (component and swatches)
- Column layout configurations
- Placeholder and help text
- Inline mode
- Custom classes and attributes
- Configuration defaults
- Combined options
- Null values and empty presets
- Hex pattern validation

## Related Components

- **Form Components**: Use with Bootstrap form layouts
- **Button**: Trigger color selection in modals/dropdowns
- **Card**: Display color palette previews
- **Modal**: Show color picker in modal dialogs

## Browser Support

The ColorPicker component uses modern web APIs:

- **Hex Input**: All modern browsers
- **Native Color Picker**: Chrome 20+, Firefox 29+, Safari 12.1+, Edge 14+
- **Stimulus**: All modern browsers with ES6 support

For older browsers without native color picker support, the component gracefully degrades to hex input only.

## References

- [Bootstrap 5.3 Forms](https://getbootstrap.com/docs/5.3/forms/overview/)
- [Bootstrap 5.3 Input Groups](https://getbootstrap.com/docs/5.3/forms/input-group/)
- [MDN: input type="color"](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color)
- [Stimulus.js Documentation](https://stimulus.hotwired.dev/)

