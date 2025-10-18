# Pagination Component

The `bs:pagination` component provides Bootstrap 5.3 pagination navigation with full accessibility support.

## Overview

The Pagination component helps users navigate through pages of content. It consists of two sub-components:
- `bs:pagination` - The main container
- `bs:pagination-item` - Individual page links

Based on [Bootstrap Pagination](https://getbootstrap.com/docs/5.3/components/pagination/).

## Basic Usage

### Simple Pagination

```twig
<twig:bs:pagination ariaLabel="Page navigation example">
  <twig:bs:pagination-item href="#">Previous</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#" :active="true">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">Next</twig:bs:pagination-item>
</twig:bs:pagination>
```

### With Icons

```twig
<twig:bs:pagination ariaLabel="Page navigation example">
  <twig:bs:pagination-item href="#" ariaLabel="Previous">
    <span aria-hidden="true">&laquo;</span>
  </twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#" ariaLabel="Next">
    <span aria-hidden="true">&raquo;</span>
  </twig:bs:pagination-item>
</twig:bs:pagination>
```

## Component Props

### Pagination (Container)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `ariaLabel` | `?string` | `'Page navigation'` | Accessible label for the navigation |
| `size` | `?string` | `null` | Size variant: `null`, `'sm'`, or `'lg'` |
| `alignment` | `?string` | `null` | Alignment: `null` (start), `'center'`, or `'end'` |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### PaginationItem

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | `?string` | `null` | Link URL (if null, renders `<span>`) |
| `label` | `?string` | `null` | Text content (alternative to slot) |
| `active` | `bool` | `false` | Mark as current page |
| `disabled` | `bool` | `false` | Disable interaction |
| `ariaLabel` | `?string` | `null` | Accessible label (e.g., "Previous", "Next") |
| `ariaCurrent` | `string` | `'page'` | Value for `aria-current` when active |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Active State

```twig
<twig:bs:pagination>
  <twig:bs:pagination-item href="#">Previous</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#" :active="true">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">Next</twig:bs:pagination-item>
</twig:bs:pagination>
```

The active item automatically includes `aria-current="page"` for accessibility.

### Disabled State

```twig
<twig:bs:pagination>
  <twig:bs:pagination-item :disabled="true">Previous</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#" :active="true">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">Next</twig:bs:pagination-item>
</twig:bs:pagination>
```

Disabled items use `<span>` instead of `<a>` and include `tabindex="-1"`.

### Sizing

#### Large Pagination

```twig
<twig:bs:pagination size="lg">
  <twig:bs:pagination-item href="#" :active="true">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
</twig:bs:pagination>
```

#### Small Pagination

```twig
<twig:bs:pagination size="sm">
  <twig:bs:pagination-item href="#" :active="true">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
</twig:bs:pagination>
```

### Alignment

#### Center

```twig
<twig:bs:pagination alignment="center">
  <twig:bs:pagination-item :disabled="true">Previous</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">Next</twig:bs:pagination-item>
</twig:bs:pagination>
```

#### End

```twig
<twig:bs:pagination alignment="end">
  <twig:bs:pagination-item :disabled="true">Previous</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">3</twig:bs:pagination-item>
  <twig:bs:pagination-item href="#">Next</twig:bs:pagination-item>
</twig:bs:pagination>
```

### Dynamic Pagination (Symfony Controller)

```php
// In your controller
$currentPage = $request->query->getInt('page', 1);
$totalPages = 10;

return $this->render('list.html.twig', [
    'currentPage' => $currentPage,
    'totalPages' => $totalPages,
]);
```

```twig
{# In your template #}
<twig:bs:pagination ariaLabel="Search results pages">
  {# Previous button #}
  {% if currentPage > 1 %}
    <twig:bs:pagination-item 
      href="{{ path('app_list', {page: currentPage - 1}) }}"
      ariaLabel="Previous">
      Previous
    </twig:bs:pagination-item>
  {% else %}
    <twig:bs:pagination-item :disabled="true">
      Previous
    </twig:bs:pagination-item>
  {% endif %}

  {# Page numbers #}
  {% for page in 1..totalPages %}
    <twig:bs:pagination-item 
      href="{{ path('app_list', {page: page}) }}"
      :active="{{ page == currentPage }}">
      {{ page }}
    </twig:bs:pagination-item>
  {% endfor %}

  {# Next button #}
  {% if currentPage < totalPages %}
    <twig:bs:pagination-item 
      href="{{ path('app_list', {page: currentPage + 1}) }}"
      ariaLabel="Next">
      Next
    </twig:bs:pagination-item>
  {% else %}
    <twig:bs:pagination-item :disabled="true">
      Next
    </twig:bs:pagination-item>
  {% endif %}
</twig:bs:pagination>
```

### Smart Pagination (Limited Range)

When you have many pages, show only a subset:

```twig
{% set maxVisible = 5 %}
{% set startPage = max(1, currentPage - 2) %}
{% set endPage = min(totalPages, startPage + maxVisible - 1) %}

<twig:bs:pagination>
  {# Previous #}
  <twig:bs:pagination-item 
    href="{{ currentPage > 1 ? path('app_list', {page: currentPage - 1}) : null }}"
    :disabled="{{ currentPage == 1 }}"
    ariaLabel="Previous">
    &laquo;
  </twig:bs:pagination-item>

  {# First page #}
  {% if startPage > 1 %}
    <twig:bs:pagination-item href="{{ path('app_list', {page: 1}) }}">
      1
    </twig:bs:pagination-item>
    {% if startPage > 2 %}
      <twig:bs:pagination-item :disabled="true">...</twig:bs:pagination-item>
    {% endif %}
  {% endif %}

  {# Page range #}
  {% for page in startPage..endPage %}
    <twig:bs:pagination-item 
      href="{{ path('app_list', {page: page}) }}"
      :active="{{ page == currentPage }}">
      {{ page }}
    </twig:bs:pagination-item>
  {% endfor %}

  {# Last page #}
  {% if endPage < totalPages %}
    {% if endPage < totalPages - 1 %}
      <twig:bs:pagination-item :disabled="true">...</twig:bs:pagination-item>
    {% endif %}
    <twig:bs:pagination-item href="{{ path('app_list', {page: totalPages}) }}">
      {{ totalPages }}
    </twig:bs:pagination-item>
  {% endif %}

  {# Next #}
  <twig:bs:pagination-item 
    href="{{ currentPage < totalPages ? path('app_list', {page: currentPage + 1}) : null }}"
    :disabled="{{ currentPage == totalPages }}"
    ariaLabel="Next">
    &raquo;
  </twig:bs:pagination-item>
</twig:bs:pagination>
```

### Using Label Prop

```twig
<twig:bs:pagination>
  <twig:bs:pagination-item href="#" label="First" />
  <twig:bs:pagination-item href="#" label="1" :active="true" />
  <twig:bs:pagination-item href="#" label="2" />
  <twig:bs:pagination-item href="#" label="Last" />
</twig:bs:pagination>
```

### Non-interactive Current Page

For the current page, you can omit the `href` to render a `<span>`:

```twig
<twig:bs:pagination>
  <twig:bs:pagination-item href="/page/1">1</twig:bs:pagination-item>
  <twig:bs:pagination-item :active="true">2</twig:bs:pagination-item>
  <twig:bs:pagination-item href="/page/3">3</twig:bs:pagination-item>
</twig:bs:pagination>
```

## Accessibility

### ARIA Labels

The pagination component follows Bootstrap's accessibility guidelines:

1. **Navigation Label**: Use descriptive `aria-label` on the `<nav>` element:
   ```twig
   <twig:bs:pagination ariaLabel="Search results pages">
   ```

2. **Icon Links**: When using icons without text, provide `aria-label`:
   ```twig
   <twig:bs:pagination-item href="#" ariaLabel="Previous page">
     <span aria-hidden="true">&laquo;</span>
   </twig:bs:pagination-item>
   ```

3. **Current Page**: Active items automatically receive `aria-current="page"`:
   ```twig
   <twig:bs:pagination-item href="#" :active="true">2</twig:bs:pagination-item>
   {# Renders: aria-current="page" #}
   ```

4. **Disabled Items**: Include `tabindex="-1"` to prevent keyboard focus:
   ```twig
   <twig:bs:pagination-item :disabled="true">Previous</twig:bs:pagination-item>
   {# Renders: tabindex="-1" #}
   ```

### Screen Reader Support

```twig
<twig:bs:pagination ariaLabel="Product catalog pages">
  <twig:bs:pagination-item 
    href="/products?page=1" 
    ariaLabel="Go to previous page">
    <span aria-hidden="true">&laquo;</span>
    <span class="visually-hidden">Previous</span>
  </twig:bs:pagination-item>
  
  <twig:bs:pagination-item href="/products?page=1">1</twig:bs:pagination-item>
  <twig:bs:pagination-item href="/products?page=2" :active="true">
    2 <span class="visually-hidden">(current)</span>
  </twig:bs:pagination-item>
  <twig:bs:pagination-item href="/products?page=3">3</twig:bs:pagination-item>
  
  <twig:bs:pagination-item 
    href="/products?page=3" 
    ariaLabel="Go to next page">
    <span class="visually-hidden">Next</span>
    <span aria-hidden="true">&raquo;</span>
  </twig:bs:pagination-item>
</twig:bs:pagination>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  pagination:
    aria_label: 'Page navigation'
    size: null              # null (default) | 'sm' | 'lg'
    alignment: null         # null (start/default) | 'center' | 'end'
    class: null
    attr: {  }

  pagination_item:
    active: false
    disabled: false
    aria_current: 'page'
    class: null
    attr: {  }
```

### Customizing Defaults

```yaml
# config/packages/ux_bootstrap.yaml
neuralglitch_ux_bootstrap:
  pagination:
    size: 'sm'              # Make all paginations small by default
    alignment: 'center'     # Center all paginations
    class: 'my-pagination'  # Add custom class to all paginations
```

## Testing

### Testing Pagination Container

```php
use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Pagination;

$config = new Config([
    'pagination' => [
        'aria_label' => 'Page navigation',
        'size' => null,
        'alignment' => null,
        'class' => null,
        'attr' => [],
    ],
]);

$component = new Pagination($config);
$component->size = 'lg';
$component->alignment = 'center';
$component->mount();

$options = $component->options();

assert($options['classes'] === 'pagination pagination-lg justify-content-center');
assert($options['ariaLabel'] === 'Page navigation');
```

### Testing Pagination Item

```php
use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\PaginationItem;

$config = new Config([
    'pagination_item' => [
        'active' => false,
        'disabled' => false,
        'aria_current' => 'page',
        'class' => null,
        'attr' => [],
    ],
]);

$component = new PaginationItem($config);
$component->href = '/page/2';
$component->active = true;
$component->mount();

$options = $component->options();

assert(str_contains($options['itemClasses'], 'active'));
assert($options['linkAttrs']['aria-current'] === 'page');
assert($options['linkAttrs']['href'] === '/page/2');
```

## Related Components

- **Breadcrumb** (`bs:breadcrumbs`) - Hierarchical navigation
- **Navbar** (`bs:navbar`) - Site navigation
- **Button Group** (`bs:button-group`) - Grouped buttons

## Bootstrap Documentation

- [Bootstrap Pagination](https://getbootstrap.com/docs/5.3/components/pagination/)
- [Pagination Accessibility](https://getbootstrap.com/docs/5.3/components/pagination/#overview)

## CSS Classes Reference

### Pagination Container

- `.pagination` - Base class
- `.pagination-sm` - Small size variant
- `.pagination-lg` - Large size variant
- `.justify-content-center` - Center alignment
- `.justify-content-end` - End alignment

### Pagination Item

- `.page-item` - Item container
- `.page-link` - Link/span element
- `.active` - Current page
- `.disabled` - Disabled state

## Tips & Best Practices

1. **Always provide aria-label**: Help screen reader users understand the pagination context
2. **Use descriptive labels**: For "Previous" and "Next" links
3. **Disable appropriately**: Disable "Previous" on first page, "Next" on last page
4. **Limit visible pages**: For large page counts, show a subset with ellipsis
5. **Consistent sizing**: Use the same size across related paginations
6. **Semantic HTML**: Let active/disabled items render as `<span>` when appropriate

## Common Patterns

### Search Results Pagination

```twig
<twig:bs:pagination ariaLabel="Search results pages" alignment="center">
  {% for item in paginationItems %}
    <twig:bs:pagination-item 
      href="{{ item.url }}"
      :active="{{ item.isCurrent }}"
      :disabled="{{ item.isDisabled }}">
      {{ item.label }}
    </twig:bs:pagination-item>
  {% endfor %}
</twig:bs:pagination>
```

### Minimal Pagination

```twig
<twig:bs:pagination size="sm">
  <twig:bs:pagination-item href="{{ prevUrl }}" ariaLabel="Previous">
    &laquo;
  </twig:bs:pagination-item>
  <twig:bs:pagination-item>
    Page {{ currentPage }} of {{ totalPages }}
  </twig:bs:pagination-item>
  <twig:bs:pagination-item href="{{ nextUrl }}" ariaLabel="Next">
    &raquo;
  </twig:bs:pagination-item>
</twig:bs:pagination>
```

