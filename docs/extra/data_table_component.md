# Data Table Component (`bs:data-table`)

## Overview

The `bs:data-table` component is a powerful, feature-rich data table built on Bootstrap 5.3 table classes. It's designed for common use cases like admin panels, reports, dashboards, user management, order listings, and product catalogs.

**Key Features:**
- Full Bootstrap table styling support (striped, bordered, hover, small, variants)
- Responsive tables with breakpoint control
- Column-based sorting with visual indicators
- Row selection with checkboxes
- Actions column for row-specific operations
- Empty state display
- Card wrapper option
- Flexible column configuration
- Caption support
- Custom class and attribute support

**Namespace:** `Extra`  
**Tag:** `<twig:bs:data-table>`  
**Component Class:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra\DataTable`

---

## Basic Usage

### Simple Data Table

```twig
<twig:bs:data-table
    :rows="[
        {'id': 1, 'name': 'John Doe', 'email': 'john@example.com', 'role': 'Admin'},
        {'id': 2, 'name': 'Jane Smith', 'email': 'jane@example.com', 'role': 'User'},
        {'id': 3, 'name': 'Bob Johnson', 'email': 'bob@example.com', 'role': 'User'},
    ]"
    :columns="[
        {'key': 'id', 'label': 'ID'},
        {'key': 'name', 'label': 'Name'},
        {'key': 'email', 'label': 'Email'},
        {'key': 'role', 'label': 'Role'},
    ]"
/>
```

### With Card Wrapper

```twig
<twig:bs:data-table
    :rows="users"
    :columns="userColumns"
    :cardWrapper="true"
    cardTitle="User Management"
    cardSubtitle="All registered users"
/>
```

---

## Component Props

### Data Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `rows` | `array` | `[]` | Array of data rows (each row is an associative array) |
| `columns` | `array` | `[]` | Array of column definitions (see Column Configuration below) |

### Table Appearance

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `striped` | `bool` | `true` | Enable striped rows (`.table-striped`) |
| `bordered` | `bool` | `false` | Add borders to all cells (`.table-bordered`) |
| `borderless` | `bool` | `false` | Remove all borders (`.table-borderless`) |
| `hover` | `bool` | `true` | Enable hover state on rows (`.table-hover`) |
| `small` | `bool` | `false` | Make table more compact (`.table-sm`) |
| `variant` | `?string` | `null` | Table color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |

### Responsive Behavior

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `responsive` | `bool` | `true` | Enable responsive table wrapper (`.table-responsive`) |
| `responsiveBreakpoint` | `?string` | `null` | Responsive breakpoint: `null`, `'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'` |

### Table Layout

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `captionText` | `?string` | `null` | Table caption text |
| `captionPosition` | `string` | `'top'` | Caption position: `'top'` or `'bottom'` |
| `thead` | `?string` | `null` | Table header theme: `null`, `'light'`, or `'dark'` |
| `divider` | `bool` | `false` | Add border divider between header and body |

### Sorting

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `sortable` | `bool` | `false` | Enable column sorting |
| `sortedColumn` | `?string` | `null` | Currently sorted column key |
| `sortDirection` | `string` | `'asc'` | Sort direction: `'asc'` or `'desc'` |
| `sortBaseUrl` | `?string` | `null` | Base URL for sort links (e.g., `'/users'`) |

### Selection

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `selectable` | `bool` | `false` | Enable row selection with checkboxes |
| `selectName` | `string` | `'selected[]'` | Name attribute for checkbox inputs |
| `selectAll` | `bool` | `false` | Show "select all" checkbox in header |

### Actions Column

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showActions` | `bool` | `false` | Show actions column |
| `actionsLabel` | `string` | `'Actions'` | Header label for actions column |
| `actionsPosition` | `string` | `'end'` | Actions column position: `'start'` or `'end'` |

### Empty State

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `emptyMessage` | `string` | `'No data available'` | Message when no data rows |
| `showEmptyState` | `bool` | `true` | Show empty state design |

### Layout

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `container` | `string` | `'container-fluid'` | Container class: `'container'`, `'container-fluid'`, `'container-{breakpoint}'`, or `null` |
| `cardWrapper` | `bool` | `false` | Wrap table in a Bootstrap card |
| `cardTitle` | `?string` | `null` | Card title (when `cardWrapper=true`) |
| `cardSubtitle` | `?string` | `null` | Card subtitle (when `cardWrapper=true`) |

### Extensibility

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `?string` | `null` | Additional CSS classes for wrapper |
| `attr` | `array` | `[]` | Additional HTML attributes for table element |

---

## Column Configuration

Each column in the `columns` array is an associative array with the following fields:

| Field | Type | Default | Description |
|-------|------|---------|-------------|
| `key` | `string` | **Required** | Key to access data in row array |
| `label` | `string` | Auto-generated from key | Column header label |
| `sortable` | `bool` | `true` | Whether this column is sortable |
| `class` | `?string` | `null` | CSS classes for cells in this column |
| `headerClass` | `?string` | `null` | CSS classes for header cell |
| `align` | `?string` | `null` | Text alignment: `'start'`, `'center'`, or `'end'` |
| `formatter` | `?callable` | `null` | Callback function to format cell value |

### Example Column Definitions

```php
$columns = [
    ['key' => 'id', 'label' => 'ID', 'align' => 'end', 'sortable' => true],
    ['key' => 'name', 'label' => 'Name', 'sortable' => true],
    ['key' => 'email', 'label' => 'Email', 'sortable' => true],
    ['key' => 'status', 'label' => 'Status', 'align' => 'center', 'formatter' => function($value, $row) {
        $variant = $value === 'active' ? 'success' : 'secondary';
        return "<span class=\"badge text-bg-{$variant}\">{$value}</span>";
    }],
];
```

---

## Examples

### Admin User Management Table

```twig
<twig:bs:data-table
    :rows="users"
    :columns="[
        {'key': 'id', 'label': 'ID', 'align': 'end'},
        {'key': 'name', 'label': 'Name'},
        {'key': 'email', 'label': 'Email'},
        {'key': 'role', 'label': 'Role'},
        {'key': 'created_at', 'label': 'Joined'},
    ]"
    :cardWrapper="true"
    cardTitle="Users"
    cardSubtitle="Manage system users"
    :sortable="true"
    sortBaseUrl="/admin/users"
    :sortedColumn="sortColumn"
    :sortDirection="sortDir"
    :selectable="true"
    :selectAll="true"
    :showActions="true"
    actionsLabel="Manage"
>
    {% block actions_end %}
        <div class="btn-group btn-group-sm">
            <a href="/admin/users/{{ row.id }}/edit" class="btn btn-outline-primary">Edit</a>
            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ row.id }})">Delete</button>
        </div>
    {% endblock %}
</twig:bs:data-table>
```

### Order Listing with Status Badges

```php
// In controller
$orders = [
    ['id' => 1, 'customer' => 'John Doe', 'total' => '$159.99', 'status' => 'shipped', 'date' => '2024-01-15'],
    ['id' => 2, 'customer' => 'Jane Smith', 'total' => '$89.50', 'status' => 'pending', 'date' => '2024-01-16'],
    ['id' => 3, 'customer' => 'Bob Johnson', 'total' => '$299.99', 'status' => 'delivered', 'date' => '2024-01-14'],
];

$columns = [
    ['key' => 'id', 'label' => 'Order #', 'align' => 'end'],
    ['key' => 'customer', 'label' => 'Customer'],
    ['key' => 'total', 'label' => 'Total', 'align' => 'end'],
    ['key' => 'status', 'label' => 'Status', 'align' => 'center', 'formatter' => function($value) {
        $variants = [
            'pending' => 'warning',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];
        $variant = $variants[$value] ?? 'secondary';
        return "<span class=\"badge text-bg-{$variant}\">" . ucfirst($value) . "</span>";
    }],
    ['key' => 'date', 'label' => 'Date'],
];
```

```twig
<twig:bs:data-table
    :rows="orders"
    :columns="columns"
    :cardWrapper="true"
    cardTitle="Recent Orders"
    :sortable="true"
    sortBaseUrl="/orders"
    :sortedColumn="sort"
    :sortDirection="direction"
    :showActions="true"
>
    {% block actions_end %}
        <a href="/orders/{{ row.id }}" class="btn btn-sm btn-outline-primary">View</a>
    {% endblock %}
</twig:bs:data-table>
```

### Product Catalog with Images

```twig
<twig:bs:data-table
    :rows="products"
    :columns="[
        {'key': 'id', 'label': '#', 'align': 'end'},
        {'key': 'image', 'label': 'Image', 'formatter': imageFormatter},
        {'key': 'name', 'label': 'Product'},
        {'key': 'category', 'label': 'Category'},
        {'key': 'price', 'label': 'Price', 'align': 'end'},
        {'key': 'stock', 'label': 'Stock', 'align': 'center'},
    ]"
    :bordered="true"
    thead="light"
    :showActions="true"
    actionsLabel="Manage"
>
    {% block actions_end %}
        <div class="btn-group btn-group-sm">
            <a href="/admin/products/{{ row.id }}/edit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
            </a>
            <button type="button" class="btn btn-sm btn-outline-danger" data-id="{{ row.id }}">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    {% endblock %}
</twig:bs:data-table>
```

### Compact Dashboard Stats Table

```twig
<twig:bs:data-table
    :rows="stats"
    :columns="[
        {'key': 'metric', 'label': 'Metric'},
        {'key': 'value', 'label': 'Value', 'align': 'end'},
        {'key': 'change', 'label': 'Change', 'align': 'end'},
    ]"
    :small="true"
    :bordered="true"
    :striped="false"
    :hover="false"
    container="null"
    emptyMessage="No statistics available"
/>
```

### Report with Dark Header

```twig
<twig:bs:data-table
    :rows="reportData"
    :columns="reportColumns"
    :cardWrapper="true"
    cardTitle="Monthly Report"
    cardSubtitle="Sales performance for January 2024"
    captionText="Data as of January 31, 2024"
    captionPosition="bottom"
    thead="dark"
    :divider="true"
    :sortable="true"
    sortBaseUrl="/reports/monthly"
    :sortedColumn="sort"
    :sortDirection="direction"
/>
```

### Minimal Table (No Container)

```twig
<twig:bs:data-table
    :rows="items"
    :columns="columns"
    container=""
    :bordered="false"
    :striped="false"
/>
```

---

## Sorting

### Enabling Sorting

To enable sorting, set `sortable="true"` and provide a `sortBaseUrl`:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :sortable="true"
    sortBaseUrl="/admin/users"
    :sortedColumn="currentSort"
    :sortDirection="currentDirection"
/>
```

The component will generate sort links like:
- `/admin/users?sort=name&direction=asc`
- `/admin/users?sort=email&direction=desc`

### Server-Side Sorting

In your controller, handle the sort parameters:

```php
public function index(Request $request): Response
{
    $sort = $request->query->get('sort', 'id');
    $direction = $request->query->get('direction', 'asc');
    
    $users = $userRepository->findAllSorted($sort, $direction);
    
    return $this->render('admin/users.html.twig', [
        'users' => $users,
        'currentSort' => $sort,
        'currentDirection' => $direction,
    ]);
}
```

---

## Row Selection

### Basic Selection

Enable row selection with checkboxes:

```twig
<form method="post" action="/admin/users/bulk-action">
    <twig:bs:data-table
        :rows="users"
        :columns="columns"
        :selectable="true"
        selectName="user_ids[]"
    />
    
    <button type="submit" name="action" value="delete" class="btn btn-danger">
        Delete Selected
    </button>
</form>
```

### Select All

Enable "select all" functionality:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :selectable="true"
    :selectAll="true"
/>

<script>
// Handle select all
document.getElementById('select-all').addEventListener('change', function(e) {
    document.querySelectorAll('.row-select').forEach(cb => {
        cb.checked = e.target.checked;
    });
});
</script>
```

---

## Actions Column

### Custom Actions per Row

Use the `actions_end` or `actions_start` block to define row actions:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :showActions="true"
    actionsLabel="Operations"
    actionsPosition="end"
>
    {% block actions_end %}
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                    type="button" 
                    data-bs-toggle="dropdown">
                Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/users/{{ row.id }}/edit">Edit</a></li>
                <li><a class="dropdown-item" href="/users/{{ row.id }}/view">View</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/users/{{ row.id }}/delete">Delete</a></li>
            </ul>
        </div>
    {% endblock %}
</twig:bs:data-table>
```

---

## Empty State

### Default Empty State

When `rows` is empty and `showEmptyState` is `true`, the table displays a friendly empty state:

```twig
<twig:bs:data-table
    :rows="[]"
    :columns="columns"
    emptyMessage="No users found. Add a new user to get started."
/>
```

### Custom Empty Message

```twig
<twig:bs:data-table
    :rows="searchResults"
    :columns="columns"
    emptyMessage="No results found for '{{ searchQuery }}'. Try a different search term."
/>
```

### Disable Empty State

```twig
<twig:bs:data-table
    :rows="[]"
    :columns="columns"
    :showEmptyState="false"
/>
```

---

## Responsive Tables

### Default Responsive

By default, tables are responsive and scroll horizontally on small screens:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :responsive="true"
/>
```

### Responsive Breakpoint

Make table responsive only below a specific breakpoint:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :responsive="true"
    responsiveBreakpoint="lg"
/>
```

This applies `.table-responsive-lg`, making the table scrollable only on screens smaller than `lg` (1024px).

---

## Styling

### Table Variants

Apply Bootstrap color variants:

```twig
{# Primary variant #}
<twig:bs:data-table :rows="rows" :columns="columns" variant="primary" />

{# Success variant #}
<twig:bs:data-table :rows="rows" :columns="columns" variant="success" />

{# Dark variant #}
<twig:bs:data-table :rows="rows" :columns="columns" variant="dark" />
```

### Table Options

Combine multiple styling options:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    :striped="true"
    :bordered="true"
    :hover="true"
    :small="true"
    thead="dark"
/>
```

### Custom Classes

Add custom CSS classes:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    class="shadow-sm rounded"
/>
```

---

## Accessibility

The component includes several accessibility features:

- **Semantic HTML:** Uses proper `<table>`, `<thead>`, `<tbody>`, `<th>`, and `<td>` elements
- **ARIA Labels:** Checkboxes include descriptive `aria-label` attributes
- **Scope Attributes:** Header cells use `scope="col"` for assistive technologies
- **Caption Support:** Add a caption for screen readers with `captionText`
- **Keyboard Navigation:** Sort links and actions are keyboard accessible

### Best Practices

```twig
<twig:bs:data-table
    :rows="users"
    :columns="columns"
    captionText="List of all registered users with their roles and contact information"
    :attr="{'role': 'table', 'aria-label': 'User management table'}"
/>
```

---

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  data_table:
    striped: true
    bordered: false
    borderless: false
    hover: true
    small: false
    variant: null
    responsive: true
    responsive_breakpoint: null
    caption_position: 'top'
    thead: null
    divider: false
    sortable: false
    sort_direction: 'asc'
    selectable: false
    select_name: 'selected[]'
    select_all: false
    show_actions: false
    actions_label: 'Actions'
    actions_position: 'end'
    empty_message: 'No data available'
    show_empty_state: true
    container: 'container-fluid'
    card_wrapper: false
    class: null
    attr: {  }
```

---

## Testing

Run tests for the DataTable component:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/DataTableTest.php
```

The test suite includes:
- Default options
- All appearance options (striped, bordered, hover, small, variant)
- Responsive behavior
- Sorting functionality
- Selection functionality
- Actions column
- Empty state
- Card wrapper
- Column processing
- Custom classes and attributes
- Config defaults

---

## Use Cases

### Admin Panels
Perfect for user management, role management, and system settings:

```twig
<twig:bs:data-table
    :rows="users"
    :columns="userColumns"
    :cardWrapper="true"
    cardTitle="User Management"
    :sortable="true"
    sortBaseUrl="/admin/users"
    :selectable="true"
    :selectAll="true"
    :showActions="true"
/>
```

### Reports & Dashboards
Display analytics, metrics, and KPIs:

```twig
<twig:bs:data-table
    :rows="salesData"
    :columns="salesColumns"
    :small="true"
    thead="dark"
    captionText="Sales Report - Q1 2024"
/>
```

### E-commerce
Order listings and product catalogs:

```twig
<twig:bs:data-table
    :rows="orders"
    :columns="orderColumns"
    :sortable="true"
    sortBaseUrl="/orders"
    :showActions="true"
/>
```

### Data Management
Any list-based data interface:

```twig
<twig:bs:data-table
    :rows="items"
    :columns="columns"
    :sortable="true"
    :selectable="true"
    :showActions="true"
/>
```

---

## Related Components

- **`bs:pagination`** - For paginating large data sets
- **`bs:card`** - Alternative container for tables
- **`bs:empty-state`** - Standalone empty state component
- **`bs:button`** - For action buttons
- **`bs:dropdown`** - For action menus

---

## References

- [Bootstrap 5.3 Tables](https://getbootstrap.com/docs/5.3/content/tables/)
- [Bootstrap 5.3 Table Responsive](https://getbootstrap.com/docs/5.3/content/tables/#responsive-tables)
- [Bootstrap 5.3 Table Variants](https://getbootstrap.com/docs/5.3/content/tables/#variants)

