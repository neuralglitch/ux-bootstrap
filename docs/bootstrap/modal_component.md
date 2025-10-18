# Modal Component

## Overview

The Modal component provides a flexible dialog system for creating lightboxes, user notifications, and custom content overlays. It implements Bootstrap 5.3's modal component with full configuration support.

**Component Tag:** `<twig:bs:modal>`  
**PHP Class:** `NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Modal`  
**Template:** `templates/components/bootstrap/modal.html.twig`

## Basic Usage

### Simple Modal

```twig
<twig:bs:modal id="exampleModal" title="Modal Title">
    This is the modal body content.
</twig:bs:modal>

<!-- Trigger button -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch Modal
</button>
```

### Modal with Custom Blocks

```twig
<twig:bs:modal id="customModal">
    {% block header %}
        <h1 class="modal-title fs-5">Custom Header</h1>
    {% endblock %}
    
    {% block content %}
        <p>Custom body content goes here.</p>
    {% endblock %}
    
    {% block footer %}
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Save</button>
    {% endblock %}
</twig:bs:modal>
```

## Component Props

### Required Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | - | **Required.** Unique identifier for the modal (used for targeting with data-bs-target) |

### Content Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string\|null | null | Modal title (displayed in header if no custom header block) |

### Size Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string\|null | null | Modal size: `'sm'`, `'lg'`, `'xl'`, or null for default |
| `fullscreen` | bool\|string | false | Fullscreen modal: `true` (always) or breakpoint (`'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'`) |

### Layout Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `centered` | bool | false | Vertically center the modal |
| `scrollable` | bool | false | Enable scrollable modal body |

### Behavior Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `backdrop` | bool\|string | true | Include backdrop: `true`, `false`, or `'static'` (doesn't close on click) |
| `keyboard` | bool | true | Close modal when escape key is pressed |
| `focus` | bool | true | Put focus on modal when opened |

### Animation

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `animation` | bool | true | Enable fade animation |

### Visibility Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showHeader` | bool | true | Show modal header |
| `showFooter` | bool | true | Show modal footer |
| `showCloseButton` | bool | true | Show close button in header |

### Button Labels

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `closeLabel` | string | 'Close' | Label for default close button |
| `saveLabel` | string | 'Save changes' | Label for default save button |

### Extensibility

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | string\|null | null | Additional CSS classes for modal wrapper |
| `attr` | array | [] | Additional HTML attributes for modal wrapper |

## Examples

### Small Modal

```twig
<twig:bs:modal id="smallModal" title="Small Modal" size="sm">
    This is a small modal.
</twig:bs:modal>
```

### Large Modal

```twig
<twig:bs:modal id="largeModal" title="Large Modal" size="lg">
    This is a large modal with more content.
</twig:bs:modal>
```

### Extra Large Modal

```twig
<twig:bs:modal id="xlModal" title="Extra Large Modal" size="xl">
    This modal is extra large.
</twig:bs:modal>
```

### Fullscreen Modal

```twig
<twig:bs:modal id="fullscreenModal" title="Fullscreen Modal" :fullscreen="true">
    This modal is always fullscreen.
</twig:bs:modal>
```

### Fullscreen Below Breakpoint

```twig
<twig:bs:modal id="responsiveModal" title="Responsive Modal" fullscreen="md">
    This modal is fullscreen below the 'md' breakpoint (medium devices and smaller).
</twig:bs:modal>
```

### Vertically Centered Modal

```twig
<twig:bs:modal id="centeredModal" title="Centered Modal" :centered="true">
    This modal is vertically centered in the viewport.
</twig:bs:modal>
```

### Scrollable Modal

```twig
<twig:bs:modal id="scrollableModal" title="Scrollable Modal" :scrollable="true">
    <p>Long content that will scroll within the modal body...</p>
    <p>More content...</p>
    <p>Even more content...</p>
</twig:bs:modal>
```

### Static Backdrop

```twig
<twig:bs:modal id="staticModal" title="Static Backdrop" backdrop="static" :keyboard="false">
    Click outside or press ESC - the modal won't close!
</twig:bs:modal>
```

### Modal Without Animation

```twig
<twig:bs:modal id="noAnimationModal" title="No Animation" :animation="false">
    This modal appears instantly without fade effect.
</twig:bs:modal>
```

### Modal Without Header or Footer

```twig
<twig:bs:modal id="minimalModal" :showHeader="false" :showFooter="false">
    Just the content, no header or footer.
</twig:bs:modal>
```

### Custom Footer Buttons

```twig
<twig:bs:modal id="customButtonsModal" title="Custom Buttons">
    {% block content %}
        <p>Do you want to proceed?</p>
    {% endblock %}
    
    {% block footer %}
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmBtn">Confirm</button>
    {% endblock %}
</twig:bs:modal>
```

### Form Inside Modal

```twig
<twig:bs:modal id="formModal" title="User Registration">
    {% block content %}
        <form id="registrationForm">
            <div class="mb-3">
                <label for="userName" class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" required>
            </div>
        </form>
    {% endblock %}
    
    {% block footer %}
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="registrationForm" class="btn btn-primary">Register</button>
    {% endblock %}
</twig:bs:modal>
```

### Nested Content

```twig
<twig:bs:modal id="nestedModal" title="Product Details">
    {% block content %}
        <div class="row">
            <div class="col-md-6">
                <img src="/product.jpg" class="img-fluid" alt="Product">
            </div>
            <div class="col-md-6">
                <h5>Product Name</h5>
                <p>Product description goes here...</p>
                <p class="text-success fw-bold">$99.99</p>
            </div>
        </div>
    {% endblock %}
    
    {% block footer %}
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Add to Cart</button>
    {% endblock %}
</twig:bs:modal>
```

### Combined Options

```twig
<twig:bs:modal 
    id="advancedModal" 
    title="Advanced Modal"
    size="lg"
    :centered="true"
    :scrollable="true"
    backdrop="static"
    :keyboard="false"
    class="custom-modal">
    
    {% block content %}
        <p>This modal combines multiple options:</p>
        <ul>
            <li>Large size</li>
            <li>Vertically centered</li>
            <li>Scrollable body</li>
            <li>Static backdrop</li>
            <li>Keyboard close disabled</li>
        </ul>
    {% endblock %}
</twig:bs:modal>
```

## Triggering Modals

### Data Attributes (Recommended)

```html
<!-- Button trigger -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Launch Modal
</button>

<!-- Link trigger -->
<a href="#myModal" data-bs-toggle="modal">Open Modal</a>
```

### JavaScript API

```javascript
// Get modal instance
const myModal = new bootstrap.Modal(document.getElementById('myModal'));

// Show modal
myModal.show();

// Hide modal
myModal.hide();

// Toggle modal
myModal.toggle();
```

### With Options

```javascript
const myModal = new bootstrap.Modal('#myModal', {
    backdrop: 'static',
    keyboard: false
});
```

## Accessibility

### ARIA Attributes

The component automatically includes:
- `role="dialog"` on the modal
- `aria-labelledby` pointing to the title (when title is provided)
- `aria-hidden="true"` when modal is closed
- `tabindex="-1"` for keyboard navigation

### Keyboard Navigation

- **ESC**: Close modal (if `keyboard` prop is true)
- **TAB**: Cycle through focusable elements within modal
- Focus is automatically trapped within the modal

### Screen Readers

```twig
<twig:bs:modal id="accessibleModal" title="Accessible Modal">
    {% block content %}
        <p>This modal is fully accessible to screen readers.</p>
    {% endblock %}
</twig:bs:modal>
```

If you don't provide a title, add `aria-label`:

```twig
<twig:bs:modal id="customModal" :attr="{'aria-label': 'Custom Modal Dialog'}">
    Content without a title...
</twig:bs:modal>
```

## JavaScript Events

Bootstrap Modal fires several events you can listen to:

```javascript
const modalEl = document.getElementById('myModal');

// Before modal shows
modalEl.addEventListener('show.bs.modal', (event) => {
    console.log('Modal is about to show');
});

// After modal is shown
modalEl.addEventListener('shown.bs.modal', (event) => {
    console.log('Modal is visible');
});

// Before modal hides
modalEl.addEventListener('hide.bs.modal', (event) => {
    console.log('Modal is about to hide');
    // Can prevent with: event.preventDefault();
});

// After modal is hidden
modalEl.addEventListener('hidden.bs.modal', (event) => {
    console.log('Modal is hidden');
});

// When backdrop is clicked (static backdrop)
modalEl.addEventListener('hidePrevented.bs.modal', (event) => {
    console.log('Hide prevented - backdrop is static');
});
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  modal:
    # Size options
    size: null                  # null | 'sm' | 'lg' | 'xl'
    fullscreen: false           # false | true | 'sm' | 'md' | 'lg' | 'xl' | 'xxl'
    
    # Layout
    centered: false             # Vertically center modal
    scrollable: false           # Scrollable modal body
    
    # Behavior
    backdrop: true              # true | false | 'static'
    keyboard: true              # Close on escape key
    focus: true                 # Focus on modal when opened
    
    # Animation
    animation: true             # Fade animation
    
    # Visibility
    show_header: true
    show_footer: true
    show_close_button: true
    
    # Labels
    close_label: 'Close'
    save_label: 'Save changes'
    
    class: null
    attr: {  }
```

### Customizing Defaults

```yaml
# config/packages/ux_bootstrap.yaml
neuralglitch_ux_bootstrap:
  modal:
    size: 'lg'                  # All modals are large by default
    centered: true              # All modals vertically centered
    animation: false            # Disable fade animation globally
    close_label: 'Dismiss'      # Custom close button label
    save_label: 'Submit'        # Custom save button label
```

## Testing

Run tests for the Modal component:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/ModalTest.php
```

The test suite covers:
- Default options
- All size variations (sm, lg, xl)
- Fullscreen modes (true and breakpoint-based)
- Layout options (centered, scrollable)
- Behavior options (backdrop, keyboard, focus)
- Animation toggle
- Title and ARIA attributes
- Visibility options (header, footer, close button)
- Custom labels
- Custom classes and attributes
- Combined options
- Configuration defaults

## Best Practices

### DO:
- Always provide a unique `id` for each modal
- Use meaningful `title` for accessibility
- Provide custom footer when default buttons don't fit your use case
- Use `backdrop="static"` for important actions that require user confirmation
- Test keyboard navigation and screen reader compatibility

### DON'T:
- Don't nest modals within modals (not supported by Bootstrap)
- Don't use same `id` for multiple modals
- Don't forget to include a way to close the modal (close button or dismiss button)
- Don't make modal content too long without using `scrollable` option
- Don't override focus management without good reason

## Common Patterns

### Confirmation Dialog

```twig
<twig:bs:modal 
    id="confirmDelete" 
    title="Confirm Delete"
    :centered="true"
    backdrop="static">
    
    {% block content %}
        <p>Are you sure you want to delete this item? This action cannot be undone.</p>
    {% endblock %}
    
    {% block footer %}
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    {% endblock %}
</twig:bs:modal>
```

### Loading Modal

```twig
<twig:bs:modal 
    id="loadingModal" 
    :showHeader="false"
    :showFooter="false"
    :centered="true"
    backdrop="static"
    :keyboard="false">
    
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Please wait...</p>
    </div>
</twig:bs:modal>
```

### Image Gallery

```twig
<twig:bs:modal 
    id="imageModal" 
    :showFooter="false"
    size="xl"
    :centered="true">
    
    {% block header %}
        <h5 class="modal-title">Image Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    {% endblock %}
    
    {% block content %}
        <img src="/gallery-image.jpg" class="img-fluid" alt="Gallery Image">
    {% endblock %}
</twig:bs:modal>
```

## Related Components

- **Alert** (`bs:alert`) - For inline notifications
- **Toast** (`bs:toast`) - For non-blocking notifications
- **Offcanvas** - For slide-in panels
- **Collapse** - For expandable content

## References

- [Bootstrap 5.3 Modal Documentation](https://getbootstrap.com/docs/5.3/components/modal/)
- [Bootstrap Modal JavaScript API](https://getbootstrap.com/docs/5.3/components/modal/#via-javascript)
- [ARIA Dialog Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/dialog-modal/)

