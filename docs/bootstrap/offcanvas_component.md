# Offcanvas Component

## Overview

The Offcanvas component (`bs:offcanvas`) is a Symfony UX TwigComponent wrapper around [Bootstrap's Offcanvas component](https://getbootstrap.com/docs/5.3/components/offcanvas/). It provides a sidebar component that can be toggled via JavaScript to appear from the left, right, top, or bottom edge of the viewport.

Offcanvas is commonly used for:
- **Navigation sidebars** - Mobile-friendly navigation menus
- **Shopping carts** - Side panel shopping carts
- **Settings panels** - Configuration and preference panels
- **Filters** - Search and filter sidebars
- **User profiles** - Quick access to profile information

## Features

- ✅ **Four placement options**: start, end, top, bottom
- ✅ **Backdrop control**: true, false, or static
- ✅ **Body scrolling**: Allow page scrolling while offcanvas is open
- ✅ **Keyboard support**: Close on escape key
- ✅ **Auto-generated IDs**: Automatic unique ID generation
- ✅ **Custom header/body classes**: Full styling control
- ✅ **Content blocks**: Flexible header, body, and footer blocks
- ✅ **Close button**: Optional dismiss button
- ✅ **Full Bootstrap 5.3 compatibility**

## Basic Usage

### Simple Offcanvas

```twig
{# Trigger button #}
<twig:bs:button 
    :attr="{
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#myOffcanvas'
    }">
    Open Offcanvas
</twig:bs:button>

{# Offcanvas panel #}
<twig:bs:offcanvas 
    id="myOffcanvas" 
    title="Offcanvas Title">
    Content for the offcanvas goes here. You can place just about any Bootstrap 
    component or custom elements here.
</twig:bs:offcanvas>
```

### With Link Trigger

```twig
{# Using a link instead of button #}
<twig:bs:link 
    href="#myOffcanvas" 
    :attr="{
        'data-bs-toggle': 'offcanvas',
        'role': 'button'
    }">
    Open with Link
</twig:bs:link>

<twig:bs:offcanvas id="myOffcanvas" title="Offcanvas">
    Your content here.
</twig:bs:offcanvas>
```

## Component Props

| Prop               | Type           | Default   | Description                                                    |
|--------------------|----------------|-----------|----------------------------------------------------------------|
| `id`               | string         | auto      | Unique identifier (auto-generated if not provided)             |
| `title`            | ?string        | null      | Title text displayed in header                                 |
| `placement`        | string         | 'start'   | Position: 'start', 'end', 'top', 'bottom'                      |
| `backdrop`         | bool\|string   | true      | Backdrop: true, false, or 'static'                             |
| `scroll`           | bool           | false     | Allow body scrolling when offcanvas is open                    |
| `keyboard`         | bool           | true      | Close offcanvas when escape key is pressed                     |
| `show`             | bool           | false     | Show offcanvas by default                                      |
| `showCloseButton`  | bool           | true      | Show close button in header                                    |
| `bodyClass`        | ?string        | null      | Additional CSS classes for offcanvas-body                      |
| `headerClass`      | ?string        | null      | Additional CSS classes for offcanvas-header                    |
| `class`            | ?string        | null      | Additional CSS classes for main offcanvas element              |
| `attr`             | array          | []        | Additional HTML attributes                                     |

## Examples

### Placement Variants

#### Left Sidebar (Start)

```twig
<twig:bs:offcanvas id="offcanvasStart" placement="start" title="Left Sidebar">
    This offcanvas slides in from the left.
</twig:bs:offcanvas>
```

#### Right Sidebar (End)

```twig
<twig:bs:offcanvas id="offcanvasEnd" placement="end" title="Right Sidebar">
    This offcanvas slides in from the right.
</twig:bs:offcanvas>
```

#### Top Panel

```twig
<twig:bs:offcanvas id="offcanvasTop" placement="top" title="Top Panel">
    This offcanvas slides down from the top.
</twig:bs:offcanvas>
```

#### Bottom Panel

```twig
<twig:bs:offcanvas id="offcanvasBottom" placement="bottom" title="Bottom Panel">
    This offcanvas slides up from the bottom.
</twig:bs:offcanvas>
```

### Backdrop Options

#### No Backdrop

```twig
<twig:bs:offcanvas 
    id="offcanvasNoBackdrop" 
    title="No Backdrop"
    :backdrop="false">
    No backdrop overlay. Page remains interactive.
</twig:bs:offcanvas>
```

#### Static Backdrop

```twig
<twig:bs:offcanvas 
    id="offcanvasStatic" 
    title="Static Backdrop"
    backdrop="static">
    Clicking outside won't close this offcanvas.
</twig:bs:offcanvas>
```

### Body Scrolling

```twig
<twig:bs:offcanvas 
    id="offcanvasScroll" 
    title="With Scrolling"
    :scroll="true"
    :backdrop="false">
    You can scroll the page while this offcanvas is open.
</twig:bs:offcanvas>
```

### Both Scrolling and Backdrop

```twig
<twig:bs:offcanvas 
    id="offcanvasBoth" 
    title="Scrolling + Backdrop"
    :scroll="true">
    Page scrolling enabled with backdrop visible.
</twig:bs:offcanvas>
```

### Without Close Button

```twig
<twig:bs:offcanvas 
    id="offcanvasNoClose" 
    title="No Close Button"
    :showCloseButton="false">
    Must be dismissed with button or programmatically.
    
    <twig:bs:button 
        :attr="{'data-bs-dismiss': 'offcanvas'}">
        Custom Close Button
    </twig:bs:button>
</twig:bs:offcanvas>
```

### Dark Offcanvas

```twig
<twig:bs:offcanvas 
    id="offcanvasDark" 
    title="Dark Offcanvas"
    class="text-bg-dark">
    
    <p>This is a dark offcanvas with custom styling.</p>
    
    <twig:bs:button 
        variant="light" 
        :attr="{'data-bs-dismiss': 'offcanvas'}">
        Close
    </twig:bs:button>
    
</twig:bs:offcanvas>
```

### Custom Header Block

```twig
<twig:bs:offcanvas id="offcanvasCustomHeader">
    
    {% block header %}
        <div class="offcanvas-header bg-primary text-white">
            <div>
                <h5 class="offcanvas-title mb-0">Custom Header</h5>
                <small>With subtitle</small>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    {% endblock %}
    
    {% block content %}
        Custom header styling with subtitle.
    {% endblock %}
    
</twig:bs:offcanvas>
```

### With Footer Block

```twig
<twig:bs:offcanvas id="offcanvasFooter" title="With Footer">
    
    {% block content %}
        <p>Main content goes here.</p>
        <p>You can add any Bootstrap components.</p>
    {% endblock %}
    
    {% block footer %}
        <div class="border-top pt-3 mt-3">
            <twig:bs:button 
                variant="primary" 
                class="w-100">
                Save Changes
            </twig:bs:button>
        </div>
    {% endblock %}
    
</twig:bs:offcanvas>
```

### Navigation Menu

```twig
<twig:bs:button 
    :attr="{
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#offcanvasNav'
    }">
    <twig:ux:icon name="bi:list" /> Menu
</twig:bs:button>

<twig:bs:offcanvas 
    id="offcanvasNav" 
    title="Navigation"
    placement="start">
    
    <twig:bs:nav variant="pills" vertical="true">
        <twig:bs:nav-item href="#home" active="true">Home</twig:bs:nav-item>
        <twig:bs:nav-item href="#about">About</twig:bs:nav-item>
        <twig:bs:nav-item href="#services">Services</twig:bs:nav-item>
        <twig:bs:nav-item href="#contact">Contact</twig:bs:nav-item>
    </twig:bs:nav>
    
    {% block footer %}
        <div class="mt-auto pt-3 border-top">
            <small class="text-muted">© 2024 Your Company</small>
        </div>
    {% endblock %}
    
</twig:bs:offcanvas>
```

### Shopping Cart

```twig
<twig:bs:button 
    variant="primary" 
    :attr="{
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#offcanvasCart'
    }">
    <twig:ux:icon name="bi:cart" /> Cart (3)
</twig:bs:button>

<twig:bs:offcanvas 
    id="offcanvasCart" 
    title="Shopping Cart"
    placement="end">
    
    {% block content %}
        <twig:bs:list-group flush="true">
            <twig:bs:list-group-item>
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-0">Product 1</h6>
                        <small class="text-muted">$19.99</small>
                    </div>
                    <button class="btn btn-sm btn-link text-danger">Remove</button>
                </div>
            </twig:bs:list-group-item>
            <twig:bs:list-group-item>
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-0">Product 2</h6>
                        <small class="text-muted">$29.99</small>
                    </div>
                    <button class="btn btn-sm btn-link text-danger">Remove</button>
                </div>
            </twig:bs:list-group-item>
        </twig:bs:list-group>
    {% endblock %}
    
    {% block footer %}
        <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-3">
                <strong>Total:</strong>
                <strong>$49.98</strong>
            </div>
            <twig:bs:button variant="primary" class="w-100">
                Checkout
            </twig:bs:button>
        </div>
    {% endblock %}
    
</twig:bs:offcanvas>
```

### Filter Sidebar

```twig
<twig:bs:offcanvas 
    id="offcanvasFilters" 
    title="Filters"
    placement="start"
    :scroll="true">
    
    {% block content %}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select">
                <option>All Categories</option>
                <option>Electronics</option>
                <option>Clothing</option>
                <option>Books</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Price Range</label>
            <input type="range" class="form-range" min="0" max="1000">
            <div class="d-flex justify-content-between">
                <small>$0</small>
                <small>$1000</small>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Brand</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="brand1">
                <label class="form-check-label" for="brand1">Brand A</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="brand2">
                <label class="form-check-label" for="brand2">Brand B</label>
            </div>
        </div>
    {% endblock %}
    
    {% block footer %}
        <div class="border-top pt-3">
            <twig:bs:button variant="primary" class="w-100 mb-2">
                Apply Filters
            </twig:bs:button>
            <twig:bs:button variant="outline-secondary" class="w-100">
                Reset
            </twig:bs:button>
        </div>
    {% endblock %}
    
</twig:bs:offcanvas>
```

### Responsive Offcanvas

```twig
{# Show as offcanvas on mobile, regular sidebar on desktop #}
<div class="row">
    <div class="col-lg-3 d-none d-lg-block">
        {# Desktop sidebar #}
        <div class="sidebar">
            <h5>Navigation</h5>
            <nav><!-- links --></nav>
        </div>
    </div>
    
    <div class="col-lg-9">
        {# Mobile menu button #}
        <twig:bs:button 
            class="d-lg-none mb-3"
            :attr="{
                'data-bs-toggle': 'offcanvas',
                'data-bs-target': '#responsiveOffcanvas'
            }">
            Menu
        </twig:bs:button>
        
        {# Main content #}
        <div>Your content here</div>
    </div>
</div>

{# Offcanvas for mobile #}
<twig:bs:offcanvas 
    id="responsiveOffcanvas" 
    title="Navigation"
    class="d-lg-none">
    <nav><!-- same links as desktop sidebar --></nav>
</twig:bs:offcanvas>
```

## Accessibility

### ARIA Attributes

The component automatically adds required ARIA attributes:

```html
<div class="offcanvas offcanvas-start" 
     tabindex="-1" 
     id="myOffcanvas" 
     aria-labelledby="myOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="myOffcanvasLabel">Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">Content</div>
</div>
```

### Best Practices

1. **Always provide a title** for screen readers:
   ```twig
   <twig:bs:offcanvas id="menu" title="Main Menu">
   ```

2. **Use semantic HTML** inside offcanvas:
   ```twig
   <twig:bs:offcanvas id="nav" title="Navigation">
       <nav>
           <ul><!-- navigation items --></ul>
       </nav>
   </twig:bs:offcanvas>
   ```

3. **Ensure close button has aria-label**:
   - Automatically added when `showCloseButton` is true
   - For custom close buttons, add `aria-label="Close"`

4. **Keyboard navigation**:
   - Escape key closes offcanvas (when `keyboard` is true)
   - Tab key should cycle through focusable elements
   - Focus should be trapped within offcanvas when open

5. **Focus management**:
   - Focus moves to offcanvas when opened
   - Focus returns to trigger element when closed

## Configuration

### Global Defaults

Configure defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  offcanvas:
    placement: 'start'          # 'start' | 'end' | 'top' | 'bottom'
    backdrop: true              # true | false | 'static'
    scroll: false               # Allow body scrolling
    keyboard: true              # Close on escape key
    show: false                 # Show by default
    show_close_button: true     # Show close button in header
    body_class: null            # Additional classes for offcanvas-body
    header_class: null          # Additional classes for offcanvas-header
    class: null
    attr: {  }
```

### Per-Instance Configuration

Override defaults for specific instances:

```twig
<twig:bs:offcanvas 
    id="customOffcanvas"
    placement="end"
    backdrop="static"
    :scroll="true"
    bodyClass="p-4 bg-light"
    headerClass="bg-primary text-white">
    Custom configured offcanvas
</twig:bs:offcanvas>
```

## JavaScript API

### Via Data Attributes

#### Toggle

```html
<button type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#myOffcanvas">
    Open Offcanvas
</button>
```

#### Dismiss

From inside offcanvas:
```html
<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
```

From outside offcanvas:
```html
<button type="button" 
        data-bs-dismiss="offcanvas" 
        data-bs-target="#myOffcanvas">
    Close
</button>
```

### Via JavaScript

```javascript
// Get or create instance
const offcanvasElement = document.getElementById('myOffcanvas');
const offcanvas = new bootstrap.Offcanvas(offcanvasElement);

// Show
offcanvas.show();

// Hide
offcanvas.hide();

// Toggle
offcanvas.toggle();

// Dispose
offcanvas.dispose();
```

### Events

```javascript
const offcanvasElement = document.getElementById('myOffcanvas');

// Before show
offcanvasElement.addEventListener('show.bs.offcanvas', event => {
    console.log('About to show');
});

// After show
offcanvasElement.addEventListener('shown.bs.offcanvas', event => {
    console.log('Shown');
});

// Before hide
offcanvasElement.addEventListener('hide.bs.offcanvas', event => {
    console.log('About to hide');
});

// After hide
offcanvasElement.addEventListener('hidden.bs.offcanvas', event => {
    console.log('Hidden');
});

// When static backdrop is clicked
offcanvasElement.addEventListener('hidePrevented.bs.offcanvas', event => {
    console.log('Hide prevented - static backdrop clicked');
});
```

## Testing

### Unit Tests

```php
public function testOffcanvasPlacement(): void
{
    $component = new Offcanvas($this->config);
    $component->id = 'test';
    $component->placement = 'end';
    $component->mount();
    $options = $component->options();

    $this->assertStringContainsString('offcanvas-end', $options['classes']);
}
```

### Integration Tests

Test in your application:

```php
// Test offcanvas renders
$crawler = $client->request('GET', '/page-with-offcanvas');
$this->assertSelectorExists('#myOffcanvas.offcanvas');
$this->assertSelectorExists('[data-bs-toggle="offcanvas"]');

// Test offcanvas opens (requires JavaScript testing)
```

## Common Patterns

### Mobile Navigation

```twig
{# Navbar with offcanvas navigation #}
<twig:bs:navbar brand="My Site">
    <twig:bs:button 
        class="d-md-none"
        :attr="{
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#mobileNav'
        }">
        Menu
    </twig:bs:button>
</twig:bs:navbar>

<twig:bs:offcanvas 
    id="mobileNav" 
    title="Menu"
    class="d-md-none">
    {# Mobile navigation items #}
</twig:bs:offcanvas>
```

### Multi-Level Menu

```twig
<twig:bs:offcanvas id="mainMenu" title="Menu">
    <twig:bs:accordion>
        <twig:bs:accordion-item title="Products">
            <ul class="list-unstyled">
                <li><a href="#">Product 1</a></li>
                <li><a href="#">Product 2</a></li>
            </ul>
        </twig:bs:accordion-item>
        <twig:bs:accordion-item title="Services">
            <ul class="list-unstyled">
                <li><a href="#">Service 1</a></li>
                <li><a href="#">Service 2</a></li>
            </ul>
        </twig:bs:accordion-item>
    </twig:bs:accordion>
</twig:bs:offcanvas>
```

### User Profile Panel

```twig
<twig:bs:offcanvas 
    id="userProfile" 
    title="Profile"
    placement="end">
    
    <div class="text-center mb-3">
        <img src="/avatar.jpg" class="rounded-circle" width="80" height="80">
        <h6 class="mt-2 mb-0">John Doe</h6>
        <small class="text-muted">john@example.com</small>
    </div>
    
    <twig:bs:list-group flush="true">
        <twig:bs:list-group-item href="#" action="true">
            <twig:ux:icon name="bi:person" /> Edit Profile
        </twig:bs:list-group-item>
        <twig:bs:list-group-item href="#" action="true">
            <twig:ux:icon name="bi:gear" /> Settings
        </twig:bs:list-group-item>
        <twig:bs:list-group-item href="#" action="true" class="text-danger">
            <twig:ux:icon name="bi:box-arrow-right" /> Logout
        </twig:bs:list-group-item>
    </twig:bs:list-group>
    
</twig:bs:offcanvas>
```

## Troubleshooting

### Offcanvas doesn't open

1. **Check Bootstrap JavaScript is loaded**:
   ```twig
   {# In your layout #}
   {{ ux_controller('@hotwired/stimulus', { bootstrap: 'bootstrap' }) }}
   ```

2. **Verify trigger attributes**:
   ```html
   data-bs-toggle="offcanvas"
   data-bs-target="#yourOffcanvasId"
   ```

3. **Check ID matches**:
   ```twig
   <twig:bs:button :attr="{'data-bs-target': '#menu'}">Open</twig:bs:button>
   <twig:bs:offcanvas id="menu">...</twig:bs:offcanvas>
   ```

### Backdrop issues

- **No backdrop showing**: Set `backdrop` to `true`
- **Can't close by clicking backdrop**: Set `backdrop` to `true` (not `'static'`)
- **Backdrop but no overlay**: Check CSS is loaded correctly

### Scrolling issues

- **Page scrolls when offcanvas is open**: Set `scroll` to `false`
- **Can't scroll page**: Set `scroll` to `true`
- **Offcanvas content isn't scrollable**: Content is scrollable by default

## Related Components

- **[Modal](modal_component.md)**: Dialog boxes for important content
- **[Navbar](navbar_component.md)**: Navigation bars with offcanvas support
- **[Dropdown](dropdown_component.md)**: Contextual menus
- **[Collapse](collapse_component.md)**: Expandable content

## References

- [Bootstrap 5.3 Offcanvas Documentation](https://getbootstrap.com/docs/5.3/components/offcanvas/)
- [Bootstrap Offcanvas JavaScript API](https://getbootstrap.com/docs/5.3/components/offcanvas/#via-javascript)
- [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
- [Symfony UX TwigComponent](https://symfony.com/bundles/ux-twig-component/current/index.html)

