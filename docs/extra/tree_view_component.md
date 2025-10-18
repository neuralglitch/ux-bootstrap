# Tree View Component

## Overview

The **Tree View** component (`bs:tree-view`) provides a hierarchical, collapsible tree structure for displaying nested data. Perfect for file browsers, category trees, organization charts, and menu editors.

**Component Type**: Extra  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag**: `<twig:bs:tree-view>`  
**Template**: `templates/components/extra/tree-view.html.twig`  
**Stimulus Controller**: `bs-tree-view`

## Features

- ✅ Hierarchical tree structure with unlimited nesting
- ✅ Expand/collapse functionality with smooth animations
- ✅ Optional node selection (single or multiple)
- ✅ Keyboard navigation (arrow keys, Enter, Space, Home, End)
- ✅ Customizable icons for files, folders, and expand/collapse controls
- ✅ Connecting lines between nodes (optional)
- ✅ Compact and hoverable modes
- ✅ Event callbacks for clicks, expand/collapse, and selection
- ✅ Fully accessible with ARIA attributes
- ✅ Responsive and mobile-friendly

## Basic Usage

### Simple File Browser

```twig
{% set files = [
    {
        id: '1',
        label: 'Documents',
        children: [
            { id: '1-1', label: 'Resume.pdf' },
            { id: '1-2', label: 'Cover Letter.docx' }
        ]
    },
    {
        id: '2',
        label: 'Images',
        children: [
            { id: '2-1', label: 'Photo.jpg' },
            { id: '2-2', label: 'Screenshot.png' }
        ]
    },
    {
        id: '3',
        label: 'README.md'
    }
] %}

<twig:bs:tree-view :items="files" />
```

### Category Tree with Selection

```twig
{% set categories = [
    {
        id: 'electronics',
        label: 'Electronics',
        expanded: true,
        children: [
            { id: 'phones', label: 'Phones', badge: '12' },
            { id: 'laptops', label: 'Laptops', badge: '8' }
        ]
    },
    {
        id: 'clothing',
        label: 'Clothing',
        children: [
            { id: 'mens', label: "Men's", badge: '45' },
            { id: 'womens', label: "Women's", badge: '67' }
        ]
    }
] %}

<twig:bs:tree-view
    :items="categories"
    :selectable="true"
    :multi-select="false"
    :show-lines="true" />
```

### Organization Structure

```twig
{% set organization = [
    {
        id: 'ceo',
        label: 'CEO',
        icon: 'bi-person-badge',
        expanded: true,
        children: [
            {
                id: 'cto',
                label: 'CTO',
                icon: 'bi-person',
                children: [
                    { id: 'dev1', label: 'Senior Developer', icon: 'bi-code-slash' },
                    { id: 'dev2', label: 'Junior Developer', icon: 'bi-code-slash' }
                ]
            },
            {
                id: 'cfo',
                label: 'CFO',
                icon: 'bi-person',
                children: [
                    { id: 'acc1', label: 'Accountant', icon: 'bi-calculator' }
                ]
            }
        ]
    }
] %}

<twig:bs:tree-view
    :items="organization"
    :show-icons="true"
    :expand-all="false" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | `[]` | Tree data structure (see [Data Structure](#data-structure)) |
| `selectable` | bool | `false` | Enable node selection with checkboxes |
| `multiSelect` | bool | `false` | Allow multiple node selection |
| `showIcons` | bool | `true` | Display icons for nodes |
| `defaultIcon` | string | `'bi-file-earmark'` | Icon for leaf nodes |
| `folderIcon` | string | `'bi-folder'` | Icon for collapsed folders |
| `folderOpenIcon` | string | `'bi-folder-open'` | Icon for expanded folders |
| `showExpandIcons` | bool | `true` | Show expand/collapse chevrons |
| `expandIcon` | string | `'bi-chevron-right'` | Icon for collapsed nodes |
| `collapseIcon` | string | `'bi-chevron-down'` | Icon for expanded nodes |
| `expandAll` | bool | `false` | Expand all nodes by default |
| `collapseAll` | bool | `false` | Collapse all nodes by default |
| `keyboard` | bool | `true` | Enable keyboard navigation |
| `showLines` | bool | `false` | Show connecting lines |
| `compact` | bool | `false` | Compact mode (less padding) |
| `hoverable` | bool | `true` | Hover effect on nodes |
| `onItemClick` | string | `null` | JavaScript callback for item clicks |
| `onExpand` | string | `null` | JavaScript callback for node expansion |
| `onCollapse` | string | `null` | JavaScript callback for node collapse |
| `onSelectionChange` | string | `null` | JavaScript callback for selection changes |
| `selectedIds` | array | `[]` | Initially selected node IDs |
| `class` | string | `null` | Additional CSS classes |
| `attr` | array | `{}` | Additional HTML attributes |

## Data Structure

Each item in the `items` array should have:

```php
[
    'id' => 'unique-id',           // Required: Unique identifier
    'label' => 'Display text',      // Required: Text to display
    'children' => [],               // Optional: Array of child items
    'icon' => 'bi-custom',          // Optional: Custom icon class
    'expanded' => true,             // Optional: Initial expansion state
    'badge' => 'New',               // Optional: Badge text
]
```

### Example Data Structure

```twig
{% set data = [
    {
        id: 'root',
        label: 'Root Folder',
        expanded: true,
        children: [
            {
                id: 'folder1',
                label: 'Subfolder 1',
                icon: 'bi-folder',
                children: [
                    {
                        id: 'file1',
                        label: 'Document.pdf',
                        icon: 'bi-file-pdf',
                        badge: 'New'
                    }
                ]
            },
            {
                id: 'file2',
                label: 'Image.jpg',
                icon: 'bi-file-image'
            }
        ]
    }
] %}
```

## Examples

### 1. File Browser with Selection

```twig
<twig:bs:tree-view
    :items="fileTree"
    :selectable="true"
    :multi-select="true"
    :show-icons="true"
    default-icon="bi-file-text"
    folder-icon="bi-folder2"
    folder-open-icon="bi-folder2-open"
    :show-lines="true"
    :compact="false" />
```

### 2. Menu Editor

```twig
<twig:bs:tree-view
    :items="menuItems"
    :selectable="false"
    :show-icons="true"
    :hoverable="true"
    on-item-click="handleMenuItemClick"
    class="border rounded p-3" />
```

### 3. Category Tree with Lines

```twig
<twig:bs:tree-view
    :items="categories"
    :show-lines="true"
    :compact="true"
    :expand-all="false" />
```

### 4. Compact Mode

```twig
<twig:bs:tree-view
    :items="data"
    :compact="true"
    :show-icons="false" />
```

### 5. With Custom Icons

```twig
<twig:bs:tree-view
    :items="customTree"
    default-icon="fas fa-file"
    folder-icon="fas fa-folder"
    folder-open-icon="fas fa-folder-open"
    expand-icon="fas fa-plus"
    collapse-icon="fas fa-minus" />
```

### 6. With Selection and Callbacks

```twig
<twig:bs:tree-view
    :items="selectableTree"
    :selectable="true"
    :multi-select="true"
    :selected-ids="['node1', 'node2']"
    on-selection-change="handleSelectionChange"
    on-item-click="handleItemClick" />

<script>
function handleSelectionChange(data) {
    console.log('Selected items:', data.selectedItems);
    console.log('Changed item:', data.item);
    console.log('Checked:', data.checked);
}

function handleItemClick(data) {
    console.log('Clicked item:', data.item);
}
</script>
```

## JavaScript API

### Accessing the Controller

```javascript
const treeElement = document.querySelector('[data-controller="bs-tree-view"]');
const controller = this.application.getControllerForElementAndIdentifier(
    treeElement,
    'bs-tree-view'
);
```

### Public Methods

#### `expandAll()`

Expands all nodes in the tree.

```javascript
controller.expandAll();
```

#### `collapseAll()`

Collapses all nodes in the tree.

```javascript
controller.collapseAll();
```

#### `getSelectedIds()`

Returns an array of selected node IDs.

```javascript
const selectedIds = controller.getSelectedIds();
console.log(selectedIds); // ['node1', 'node2']
```

#### `clearSelection()`

Clears all selections.

```javascript
controller.clearSelection();
```

## Keyboard Navigation

When `keyboard` is enabled (default):

| Key | Action |
|-----|--------|
| `↓` | Move to next visible node |
| `↑` | Move to previous visible node |
| `→` | Expand focused node (if collapsed) |
| `←` | Collapse focused node (if expanded) |
| `Enter` / `Space` | Toggle selection (if selectable) |
| `Home` | Focus first node |
| `End` | Focus last visible node |

## Styling Variants

### With Connecting Lines

```twig
<twig:bs:tree-view
    :items="data"
    :show-lines="true" />
```

### Compact Mode

```twig
<twig:bs:tree-view
    :items="data"
    :compact="true" />
```

### Without Hover Effect

```twig
<twig:bs:tree-view
    :items="data"
    :hoverable="false" />
```

## Use Cases

### 1. File Browser

Perfect for displaying file system hierarchies:

```twig
<twig:bs:tree-view
    :items="fileSystem"
    :selectable="true"
    :multi-select="true"
    default-icon="bi-file-earmark"
    folder-icon="bi-folder"
    folder-open-icon="bi-folder-open" />
```

### 2. Category Management

For e-commerce category trees:

```twig
<twig:bs:tree-view
    :items="categories"
    :selectable="true"
    :show-lines="true"
    on-item-click="editCategory" />
```

### 3. Organization Chart

Display company structure:

```twig
<twig:bs:tree-view
    :items="orgChart"
    :expand-all="true"
    :show-icons="true"
    :show-lines="true" />
```

### 4. Menu Editor

For CMS menu management:

```twig
<twig:bs:tree-view
    :items="menuStructure"
    :selectable="false"
    on-item-click="editMenuItem"
    on-expand="handleMenuExpand" />
```

## Accessibility

The Tree View component is fully accessible:

- **ARIA Roles**: `role="tree"` on container, `role="treeitem"` on items
- **ARIA States**: `aria-expanded` for collapsible nodes, `aria-multiselectable` for multi-select
- **Keyboard Navigation**: Full keyboard support with arrow keys and Enter/Space
- **Focus Management**: Visual focus indicators and proper focus order
- **Screen Reader**: Descriptive labels and state announcements

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  tree_view:
    selectable: false
    multi_select: false
    show_icons: true
    default_icon: 'bi-file-earmark'
    folder_icon: 'bi-folder'
    folder_open_icon: 'bi-folder-open'
    show_expand_icons: true
    expand_icon: 'bi-chevron-right'
    collapse_icon: 'bi-chevron-down'
    expand_all: false
    collapse_all: false
    keyboard: true
    show_lines: false
    compact: false
    hoverable: true
    class: null
    attr: {  }
```

## Browser Compatibility

- ✅ Chrome/Edge 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Related Components

- **Accordion**: For simple collapsible sections
- **Collapse**: For basic show/hide functionality
- **Nav**: For flat navigation menus
- **List Group**: For simple lists without hierarchy

## References

- [Bootstrap Documentation](https://getbootstrap.com/)
- [ARIA Tree Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/treeview/)
- [Stimulus Documentation](https://stimulus.hotwired.dev/)

