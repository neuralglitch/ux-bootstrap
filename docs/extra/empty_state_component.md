# Empty State Component

## Overview

The `bs:empty-state` component provides a user-friendly way to communicate empty states across your application. It's designed for scenarios like empty tables, no search results, new user experiences, and empty lists. The component combines icons or images, descriptive text, and actionable CTAs to guide users when content is unavailable.

**Component Type:** Extra (Custom Component)  
**Namespace:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag:** `<twig:bs:empty-state>`

## Features

- 📦 Icon or image support
- 🎨 Multiple variants (info, warning, success, danger)
- 📏 Size options (small, default, large)
- 🎯 Primary and secondary CTAs
- 🎭 Customizable content with blocks
- ♿ Accessible and semantic HTML
- 📱 Fully responsive
- ⚙️ Configurable defaults via YAML

## Basic Usage

### Simple Empty State

```twig
<twig:bs:empty-state
    title="No items found"
    description="Get started by adding your first item."
    icon="bi bi-inbox"
/>
```

### With Call-to-Action

```twig
<twig:bs:empty-state
    title="No tasks yet"
    description="Create your first task to get started."
    icon="bi bi-list-check"
    ctaLabel="Add Task"
    ctaHref="/tasks/new"
    ctaVariant="primary"
/>
```

### With Image

```twig
<twig:bs:empty-state
    title="Welcome to your dashboard"
    description="Your dashboard is empty. Start by importing data or creating new entries."
    imageSrc="/images/welcome-illustration.svg"
    imageAlt="Welcome illustration"
    ctaLabel="Import Data"
    ctaHref="/import"
    secondaryCtaLabel="Learn More"
    secondaryCtaHref="/docs"
/>
```

## Component Props

| Property | Type | Default | Description |
|---|---|---|---|
| `title` | `string` | `'No items found'` | Main heading text |
| `description` | `?string` | `null` | Optional descriptive text |
| `icon` | `?string` | `null` | Icon class (e.g., `'bi bi-inbox'`) |
| `iconClass` | `?string` | `null` | Additional icon classes |
| `imageSrc` | `?string` | `null` | Image URL |
| `imageAlt` | `?string` | `null` | Image alt text (defaults to title) |
| `ctaLabel` | `?string` | `null` | Primary button label |
| `ctaHref` | `?string` | `null` | Primary button URL |
| `ctaVariant` | `string` | `'primary'` | Primary button variant |
| `ctaSize` | `?string` | `null` | Primary button size |
| `secondaryCtaLabel` | `?string` | `null` | Secondary button label |
| `secondaryCtaHref` | `?string` | `null` | Secondary button URL |
| `secondaryCtaVariant` | `string` | `'outline-secondary'` | Secondary button variant |
| `secondaryCtaSize` | `?string` | `null` | Secondary button size |
| `variant` | `?string` | `null` | Color variant (info, warning, success, danger) |
| `size` | `?string` | `null` | Size option (sm, lg) |
| `container` | `string` | `'container'` | Container class |
| `centered` | `bool` | `true` | Center content |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Empty Table

```twig
<twig:bs:empty-state
    title="No records found"
    description="There are currently no records to display. Try adjusting your filters or add a new record."
    icon="bi bi-table"
    variant="info"
    ctaLabel="Add Record"
    ctaHref="/records/new"
    secondaryCtaLabel="Clear Filters"
    secondaryCtaHref="/records?reset=1"
/>
```

### No Search Results

```twig
<twig:bs:empty-state
    title="No search results"
    description="We couldn't find any results matching your search criteria. Try different keywords or browse all items."
    icon="bi bi-search"
    variant="warning"
    ctaLabel="Clear Search"
    ctaHref="/search?reset=1"
    secondaryCtaLabel="Browse All"
    secondaryCtaHref="/browse"
/>
```

### New User Experience

```twig
<twig:bs:empty-state
    title="Welcome to Your Workspace"
    description="Your workspace is empty. Let's get you started with your first project."
    imageSrc="/images/onboarding/workspace-empty.svg"
    variant="success"
    size="lg"
    ctaLabel="Create Project"
    ctaHref="/projects/new"
    secondaryCtaLabel="Take a Tour"
    secondaryCtaHref="/tour"
/>
```

### Empty Shopping Cart

```twig
<twig:bs:empty-state
    title="Your cart is empty"
    description="Looks like you haven't added anything to your cart yet."
    icon="bi bi-cart-x"
    ctaLabel="Start Shopping"
    ctaHref="/products"
    ctaVariant="success"
/>
```

### Error State

```twig
<twig:bs:empty-state
    title="Unable to load data"
    description="We encountered an error while loading your data. Please try again or contact support if the problem persists."
    icon="bi bi-exclamation-triangle"
    variant="danger"
    ctaLabel="Try Again"
    ctaHref="{{ app.request.uri }}"
    secondaryCtaLabel="Contact Support"
    secondaryCtaHref="/support"
/>
```

### Variants

```twig
{# Info variant #}
<twig:bs:empty-state
    title="No notifications"
    icon="bi bi-bell"
    variant="info"
/>

{# Warning variant #}
<twig:bs:empty-state
    title="No active subscriptions"
    icon="bi bi-exclamation-triangle"
    variant="warning"
/>

{# Success variant #}
<twig:bs:empty-state
    title="All caught up!"
    icon="bi bi-check-circle"
    variant="success"
/>

{# Danger variant #}
<twig:bs:empty-state
    title="Access denied"
    icon="bi bi-lock"
    variant="danger"
/>
```

### Size Options

```twig
{# Small #}
<twig:bs:empty-state
    title="No comments"
    icon="bi bi-chat"
    size="sm"
/>

{# Default (no size prop) #}
<twig:bs:empty-state
    title="No items"
    icon="bi bi-inbox"
/>

{# Large #}
<twig:bs:empty-state
    title="Welcome!"
    icon="bi bi-emoji-smile"
    size="lg"
/>
```

### Custom Content Block

```twig
<twig:bs:empty-state
    title="No saved searches"
    icon="bi bi-bookmark">
    {% block content %}
        <p class="text-muted mb-3">
            Save your frequent searches for quick access later.
        </p>
        <ul class="list-unstyled text-start d-inline-block">
            <li>✓ Save time with quick filters</li>
            <li>✓ Access searches across devices</li>
            <li>✓ Share searches with your team</li>
        </ul>
    {% endblock %}
</twig:bs:empty-state>
```

### Different Container Types

```twig
{# Standard container #}
<twig:bs:empty-state
    container="container"
    title="No items"
/>

{# Fluid container #}
<twig:bs:empty-state
    container="container-fluid"
    title="No items"
/>

{# Responsive container #}
<twig:bs:empty-state
    container="container-md"
    title="No items"
/>
```

### Not Centered

```twig
<twig:bs:empty-state
    title="No items found"
    description="Try adjusting your filters."
    :centered="false"
    icon="bi bi-filter"
/>
```

## Use Cases

### 1. Empty Data Tables

Perfect for displaying when a table has no data to show:

```twig
{% if products is empty %}
    <twig:bs:empty-state
        title="No products found"
        description="You haven't added any products yet."
        icon="bi bi-box"
        ctaLabel="Add Product"
        ctaHref="{{ path('product_new') }}"
    />
{% else %}
    <table class="table">
        {# Table content #}
    </table>
{% endif %}
```

### 2. Search Results

Display when search returns no results:

```twig
{% if searchResults is empty %}
    <twig:bs:empty-state
        title="No results for '{{ query }}'"
        description="Try different keywords or browse all items."
        icon="bi bi-search"
        variant="info"
        ctaLabel="Clear Search"
        ctaHref="{{ path('search') }}"
    />
{% endif %}
```

### 3. Empty Lists

Show guidance when lists are empty:

```twig
{% if tasks is empty %}
    <twig:bs:empty-state
        title="No tasks yet"
        description="Create your first task to get started."
        icon="bi bi-check2-square"
        ctaLabel="Create Task"
        ctaHref="{{ path('task_new') }}"
        ctaVariant="success"
    />
{% endif %}
```

### 4. Onboarding

Guide new users through getting started:

```twig
{% if isNewUser %}
    <twig:bs:empty-state
        title="Welcome {{ user.name }}!"
        description="Let's set up your profile and get you started."
        imageSrc="/images/onboarding.svg"
        variant="success"
        size="lg"
        ctaLabel="Set Up Profile"
        ctaHref="{{ path('profile_setup') }}"
    />
{% endif %}
```

### 5. Error States

Communicate errors gracefully:

```twig
{% if error %}
    <twig:bs:empty-state
        title="Something went wrong"
        description="{{ error.message }}"
        icon="bi bi-exclamation-triangle"
        variant="danger"
        ctaLabel="Retry"
        ctaHref="{{ app.request.uri }}"
    />
{% endif %}
```

## Accessibility

The empty state component follows accessibility best practices:

- **Semantic HTML**: Uses proper heading tags (`<h3>`) for titles
- **Alt Text**: Images have descriptive alt text (defaults to title)
- **Button Labels**: CTAs use the `bs:button` component which supports accessibility
- **Text Contrast**: Icon colors use Bootstrap's semantic colors with proper contrast
- **Screen Readers**: All content is readable by screen readers

### Best Practices

```twig
{# Good: Descriptive title and description #}
<twig:bs:empty-state
    title="No notifications"
    description="You're all caught up! We'll notify you when something new arrives."
    icon="bi bi-bell"
/>

{# Good: Clear call-to-action #}
<twig:bs:empty-state
    title="Empty inbox"
    description="You have no messages."
    icon="bi bi-envelope"
    ctaLabel="Compose new message"
    ctaHref="/messages/new"
/>

{# Good: Image with alt text #}
<twig:bs:empty-state
    title="Welcome"
    imageSrc="/images/welcome.svg"
    imageAlt="Welcome illustration with person waving"
/>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  empty_state:
    # Content
    title: 'No items found'
    description: null
    
    # Icon/Image
    icon: null
    icon_class: null
    image_src: null
    image_alt: null
    
    # Call-to-Action
    cta_label: null
    cta_href: null
    cta_variant: 'primary'
    cta_size: null
    
    # Secondary CTA
    secondary_cta_label: null
    secondary_cta_href: null
    secondary_cta_variant: 'outline-secondary'
    secondary_cta_size: null
    
    # Styling
    variant: null
    size: null
    container: 'container'
    centered: true
    
    class: null
    attr: {  }
```

### Customizing Defaults

```yaml
# Change default title and add icon
neuralglitch_ux_bootstrap:
  empty_state:
    title: 'Nothing here'
    icon: 'bi bi-inbox'
    variant: 'info'
    cta_variant: 'success'
```

## Testing

The component includes comprehensive tests covering:

- Default options
- Custom titles and descriptions
- Icon and image display
- CTA buttons (primary and secondary)
- All variants (info, warning, success, danger)
- Size options (sm, lg)
- Container options
- Centering behavior
- Custom classes and attributes
- Configuration defaults

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/EmptyStateTest.php
```

## Integration Tips

### With Turbo

```twig
<turbo-frame id="products-list">
    {% if products is empty %}
        <twig:bs:empty-state
            title="No products"
            ctaLabel="Add Product"
            ctaHref="{{ path('product_new') }}"
            data-turbo-frame="_top"
        />
    {% else %}
        {# Product list #}
    {% endif %}
</turbo-frame>
```

### With Pagination

```twig
{% if pagination.items is empty %}
    <twig:bs:empty-state
        title="No results on this page"
        description="Try a different page or adjust your filters."
        icon="bi bi-file-earmark"
        ctaLabel="Go to First Page"
        ctaHref="{{ path('list', {page: 1}) }}"
    />
{% endif %}
```

### In Modal

```twig
<twig:bs:modal id="selectItemModal" title="Select Item">
    {% block body %}
        {% if availableItems is empty %}
            <twig:bs:empty-state
                title="No items available"
                description="All items are already selected."
                icon="bi bi-check-all"
                size="sm"
                container="container-fluid"
            />
        {% else %}
            {# Item list #}
        {% endif %}
    {% endblock %}
</twig:bs:modal>
```

## Related Components

- **Hero** (`bs:hero`) - For prominent hero sections
- **Alert** (`bs:alert`) - For temporary notification messages
- **Card** (`bs:card`) - For content containers
- **Modal** (`bs:modal`) - For dialog-based empty states

## CSS Customization

The component generates semantic CSS classes for customization:

```css
/* Wrapper */
.empty-state { }
.empty-state-sm { }
.empty-state-lg { }
.empty-state-info { }
.empty-state-warning { }
.empty-state-success { }
.empty-state-danger { }

/* Icon */
.empty-state-icon { }

/* Image */
.empty-state-image { }
.empty-state-media { }

/* Content */
.empty-state-title { }
.empty-state-description { }
.empty-state-content { }

/* Actions */
.empty-state-actions { }
```

Example custom styling:

```scss
.empty-state {
    padding: 3rem 0;
    
    &-icon {
        opacity: 0.6;
        margin-bottom: 1.5rem;
    }
    
    &-lg {
        padding: 5rem 0;
        
        .empty-state-icon {
            font-size: 5rem !important;
        }
    }
    
    // Custom variant
    &-custom {
        .empty-state-icon {
            color: purple !important;
        }
    }
}
```

## References

- [Bootstrap Empty State Patterns](https://getbootstrap.com/docs/5.3/examples/)
- [UX Guidelines for Empty States](https://uxdesign.cc/empty-state-designs-9f7fbd96f2bf)
- [Material Design Empty States](https://m2.material.io/design/communication/empty-states.html)

## Changelog

- **v1.0.0** - Initial implementation with icon, image, and CTA support

