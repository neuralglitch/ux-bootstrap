# Split Panes Component

The Split Panes component provides resizable split layouts for dividing content into multiple panes. Perfect for code editors, email clients, and documentation sites.

## Overview

- **Component**: `bs:split-panes`
- **Type**: Extra Component (Custom Pattern)
- **Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra\SplitPanes`
- **Template**: `templates/components/extra/split-panes.html.twig`
- **Stimulus Controller**: `bs-split-panes` (`assets/controllers/bs_split_panes_controller.js`)

## Use Cases

- **Code Editors**: Source code on left, preview on right
- **Email Clients**: Message list and message detail view
- **Documentation**: Table of contents and content
- **Admin Panels**: Sidebar navigation and main content
- **Data Comparison**: Side-by-side data views

## Basic Usage

### Horizontal Split (Left/Right)

```twig
<twig:bs:split-panes orientation="horizontal">
    <twig:block name="first">
        <div class="p-3">
            <h3>Left Pane</h3>
            <p>This is the left pane content.</p>
        </div>
    </twig:block>
    
    <twig:block name="second">
        <div class="p-3">
            <h3>Right Pane</h3>
            <p>This is the right pane content.</p>
        </div>
    </twig:block>
</twig:bs:split-panes>
```

### Vertical Split (Top/Bottom)

```twig
<twig:bs:split-panes orientation="vertical">
    <twig:block name="first">
        <div class="p-3">
            <h3>Top Pane</h3>
            <p>This is the top pane content.</p>
        </div>
    </twig:block>
    
    <twig:block name="second">
        <div class="p-3">
            <h3>Bottom Pane</h3>
            <p>This is the bottom pane content.</p>
        </div>
    </twig:block>
</twig:bs:split-panes>
```

## Component Props

| Property | Type | Default | Description |
|---|---|---|---|
| `orientation` | string | `'horizontal'` | Split orientation: `'horizontal'` (left/right) or `'vertical'` (top/bottom) |
| `initialSize` | string\|null | `'50%'` | Initial size of first pane (%, px) |
| `minSize` | string\|null | `'10%'` | Minimum size of first pane |
| `maxSize` | string\|null | `'90%'` | Maximum size of first pane |
| `resizable` | bool | `true` | Enable resizing via divider |
| `collapsible` | bool | `false` | Enable collapsible panes |
| `persistent` | bool | `false` | Persist size to localStorage (requires `id`) |
| `id` | string\|null | `null` | Unique identifier (auto-generated if `persistent` is true) |
| `dividerSize` | int | `4` | Divider size in pixels |
| `snapThreshold` | int | `50` | Snap threshold in pixels for collapse |
| `collapsed` | string\|null | `null` | Initial collapsed pane: `null`, `'first'`, or `'second'` |
| `class` | string\|null | `null` | Additional CSS classes |
| `attr` | array | `[]` | Additional HTML attributes |

## Examples

### Code Editor Layout

```twig
<div style="height: 600px;">
    <twig:bs:split-panes 
        orientation="horizontal"
        :initialSize="'40%'"
        :minSize="'20%'"
        :maxSize="'80%'"
        :persistent="true"
        id="code-editor">
        
        <twig:block name="first">
            <div class="h-100 p-3 bg-dark text-white">
                <h5>Code</h5>
                <pre><code>function hello() {
    console.log('Hello World');
}</code></pre>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-3">
                <h5>Preview</h5>
                <div id="preview-output">
                    <p>Output will appear here...</p>
                </div>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

### Email Client Layout

```twig
<div style="height: 600px;">
    <twig:bs:split-panes 
        orientation="horizontal"
        :initialSize="'30%'"
        :minSize="'200px'"
        :maxSize="'60%'"
        :persistent="true"
        id="email-client">
        
        <twig:block name="first">
            <div class="h-100 border-end">
                <div class="p-3 border-bottom">
                    <h5>Inbox</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">
                        <strong>John Doe</strong><br>
                        <small>Meeting Tomorrow</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action active">
                        <strong>Jane Smith</strong><br>
                        <small>Project Update</small>
                    </a>
                </div>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-3">
                <h4>Project Update</h4>
                <p class="text-muted">From: Jane Smith &lt;jane@example.com&gt;</p>
                <hr>
                <p>Message content goes here...</p>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

### Documentation Layout with Collapsible TOC

```twig
<div style="height: 600px;">
    <twig:bs:split-panes 
        orientation="horizontal"
        :initialSize="'250px'"
        :minSize="'200px'"
        :maxSize="'500px'"
        :collapsible="true"
        :snapThreshold="100"
        :persistent="true"
        id="docs-layout">
        
        <twig:block name="first">
            <div class="h-100 p-3 bg-light border-end">
                <h5>Table of Contents</h5>
                <nav class="nav flex-column">
                    <a class="nav-link" href="#intro">Introduction</a>
                    <a class="nav-link" href="#install">Installation</a>
                    <a class="nav-link" href="#usage">Usage</a>
                    <a class="nav-link" href="#api">API Reference</a>
                </nav>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-4 overflow-auto">
                <h1>Documentation</h1>
                <p>Main documentation content goes here...</p>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

### Vertical Split (Console Output)

```twig
<div style="height: 600px;">
    <twig:bs:split-panes 
        orientation="vertical"
        :initialSize="'70%'"
        :minSize="'30%'"
        :maxSize="'90%'"
        :persistent="true"
        id="console-split">
        
        <twig:block name="first">
            <div class="h-100 p-3">
                <h5>Editor</h5>
                <textarea class="form-control" rows="15">// Your code here</textarea>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-3 bg-dark text-white">
                <h6>Console Output</h6>
                <pre>$ npm run build
Building project...
Done!</pre>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

### Initially Collapsed Pane

```twig
<div style="height: 600px;">
    <twig:bs:split-panes 
        orientation="horizontal"
        :collapsible="true"
        collapsed="first">
        
        <twig:block name="first">
            <div class="h-100 p-3 bg-light">
                <h5>Sidebar (Initially Collapsed)</h5>
                <p>This pane starts collapsed.</p>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-3">
                <h5>Main Content</h5>
                <p>Drag the divider to reveal the sidebar.</p>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

### Non-Resizable Split (Fixed Layout)

```twig
<div style="height: 400px;">
    <twig:bs:split-panes 
        orientation="horizontal"
        :resizable="false"
        :initialSize="'200px'">
        
        <twig:block name="first">
            <div class="h-100 p-3 bg-primary text-white">
                <h5>Fixed Sidebar</h5>
                <p>Cannot be resized.</p>
            </div>
        </twig:block>
        
        <twig:block name="second">
            <div class="h-100 p-3">
                <h5>Content Area</h5>
                <p>The sidebar is fixed at 200px.</p>
            </div>
        </twig:block>
    </twig:bs:split-panes>
</div>
```

## Accessibility

The Split Panes component includes:

- **ARIA Roles**: Divider has `role="separator"` and appropriate `aria-orientation`
- **Keyboard Navigation**: 
  - `Arrow Left/Right` (horizontal) or `Arrow Up/Down` (vertical): Adjust split by 5%
  - `Home`: Collapse first pane (0%)
  - `End`: Collapse second pane (100%)
  - `Tab`: Navigate to divider
- **Screen Reader Support**: Aria attributes for current split position
- **Focus Indicators**: Visible focus ring on divider when focused

### Best Practices

1. **Set Container Height**: Split panes require a defined height on the parent container
2. **Unique IDs**: Use unique `id` props when using multiple split panes with persistence
3. **Min/Max Constraints**: Set reasonable min/max sizes to prevent unusable layouts
4. **Touch Support**: Divider is automatically larger on touch devices
5. **Semantic Content**: Use proper heading hierarchy within panes

## Stimulus Integration

### Controller: `bs-split-panes`

The component uses the `bs-split-panes` Stimulus controller for interactive behavior.

### Custom Events

```javascript
// Listen for resize events
document.getElementById('my-splitter').addEventListener('split-panes:resize', (event) => {
    console.log('New size:', event.detail.size);
});
```

### Values

- `orientation`: `'horizontal'` | `'vertical'`
- `resizable`: `boolean`
- `collapsible`: `boolean`
- `persistent`: `boolean`
- `storageKey`: Storage key for persistence
- `initialSize`: Initial size of first pane
- `minSize`: Minimum size constraint
- `maxSize`: Maximum size constraint
- `dividerSize`: Divider thickness in pixels
- `snapThreshold`: Collapse snap threshold
- `collapsed`: Initially collapsed pane

### Targets

- `firstPane`: First pane element
- `secondPane`: Second pane element
- `divider`: Resizable divider element

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  split_panes:
    orientation: 'horizontal'
    initial_size: '50%'
    min_size: '10%'
    max_size: '90%'
    resizable: true
    collapsible: false
    persistent: false
    divider_size: 4
    snap_threshold: 50
    collapsed: null
    class: null
    attr: {}
```

## Styling

The component includes these CSS classes:

- `.split-panes`: Main container
- `.split-panes-horizontal`: Horizontal layout
- `.split-panes-vertical`: Vertical layout
- `.split-panes-resizable`: Resizable indicator
- `.split-panes-collapsible`: Collapsible indicator
- `.split-panes-dragging`: Applied during drag
- `.split-pane`: Individual pane
- `.split-pane-first`: First pane
- `.split-pane-second`: Second pane
- `.split-divider`: Divider element
- `.split-divider-vertical`: Vertical divider (for horizontal split)
- `.split-divider-horizontal`: Horizontal divider (for vertical split)
- `.split-divider-handle`: Divider visual handle

### Custom Styling Example

```scss
// Custom divider color
.split-divider {
    background: var(--bs-primary);
    
    &:hover {
        background: var(--bs-primary-dark);
    }
}

// Custom pane background
.split-pane-first {
    background: var(--bs-light);
}
```

## Testing

Test file: `tests/Twig/Components/Extra/SplitPanesTest.php`

Run tests:
```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/SplitPanesTest.php
```

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Touch device support included
- Keyboard navigation
- LocalStorage for persistence

## Related Components

- **Offcanvas**: For overlaying content
- **Collapse**: For showing/hiding content
- **Sidebar**: For fixed navigation layouts
- **Tabs**: For switching between views

## References

- [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [Stimulus Documentation](https://stimulus.hotwired.dev/)
- [Split Pane Pattern (UX)](https://www.nngroup.com/articles/split-views/)

## Migration Notes

This is a new Extra component with no previous versions.

## Browser-Specific Notes

### Safari
- Works with standard behavior

### Mobile Browsers
- Divider is automatically larger for touch targets
- Swipe gestures supported
- May need viewport height units (`vh`) for full-screen layouts

### Accessibility Tools
- Works with screen readers
- Keyboard navigation fully supported
- Focus management included

