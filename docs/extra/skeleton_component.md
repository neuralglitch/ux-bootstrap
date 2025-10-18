# Skeleton Component

## Overview

The Skeleton component (`bs:skeleton`) is an Extra component that provides content-aware loading states for your application. Unlike Bootstrap's basic placeholder components, Skeleton offers predefined templates for common content types (text, avatars, cards, lists) and intelligent defaults for natural-looking loading states.

**Component Type**: Extra  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Twig Tag**: `<twig:bs:skeleton />`

## Why Use Skeleton Over Basic Placeholders?

Bootstrap's placeholder components are limited to simple rectangles. The Skeleton component provides:
- **Content-aware presets** for common UI patterns (cards, lists, avatars, paragraphs)
- **Intelligent defaults** with natural width variations
- **Composite structures** that combine multiple placeholders
- **Configurable animations** (wave, pulse, none)
- **Flexible customization** while maintaining consistency

## Basic Usage

### Simple Text Skeleton

```twig
{# Default text skeleton with 3 lines #}
<twig:bs:skeleton />

{# Custom number of lines #}
<twig:bs:skeleton :lines="5" />
```

### Heading Skeleton

```twig
<twig:bs:skeleton type="heading" />
```

### Avatar Skeleton

```twig
{# Default medium circle avatar #}
<twig:bs:skeleton type="avatar" />

{# Large square avatar #}
<twig:bs:skeleton type="avatar" size="lg" avatar-shape="square" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `'text'` | Skeleton type: `text`, `heading`, `avatar`, `card`, `list`, `paragraph`, `custom` |
| `lines` | `int` | `3` | Number of lines/items (for text, paragraph, list types) |
| `width` | `?string` | `null` | Width of skeleton (e.g., `'75%'`, `'200px'`, `'sm'`, `'md'`, `'lg'`) |
| `height` | `?string` | `null` | Height of skeleton (CSS value, useful for custom skeletons) |
| `animation` | `string` | `'wave'` | Animation type: `wave`, `pulse`, `none` |
| `size` | `?string` | `null` | Avatar size: `sm`, `md`, `lg`, `xl` |
| `avatarShape` | `string` | `'circle'` | Avatar shape: `circle`, `square`, `rounded` |
| `withAvatar` | `bool` | `false` | Show avatar with text (for card/list types) |
| `withButton` | `bool` | `false` | Show button skeleton (for card type) |
| `withImage` | `bool` | `false` | Show image skeleton (for card type) |
| `rounded` | `?string` | `null` | Border radius: `none`, `sm`, `default`, `lg`, `pill`, `circle` |
| `tag` | `string` | `'div'` | Container HTML tag |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Skeleton Types

### 1. Text Skeleton

Multiple lines with natural width variation.

```twig
<twig:bs:skeleton type="text" :lines="3" />
```

**Structure**:
- Creates `lines` number of placeholder spans
- Each line has slightly different width for natural appearance
- Widths vary between 75-95% by default

### 2. Heading Skeleton

Single large placeholder for headings.

```twig
<twig:bs:skeleton type="heading" />
```

**Structure**:
- Large placeholder (`placeholder-lg`)
- 60% width by default
- 2rem height

### 3. Avatar Skeleton

Circular or square profile picture placeholder.

```twig
{# Circle avatar (default) #}
<twig:bs:skeleton type="avatar" size="md" />

{# Square avatar #}
<twig:bs:skeleton type="avatar" size="lg" avatar-shape="square" />

{# Rounded avatar #}
<twig:bs:skeleton type="avatar" size="xl" avatar-shape="rounded" />
```

**Sizes**:
- `sm`: 32px
- `md`: 48px (default)
- `lg`: 64px
- `xl`: 96px

**Shapes**:
- `circle`: Circular avatar (default)
- `square`: No border radius
- `rounded`: Rounded corners

### 4. Card Skeleton

Complete card structure with optional image, avatar, text, and button.

```twig
{# Basic card #}
<twig:bs:skeleton type="card" />

{# Card with all features #}
<twig:bs:skeleton 
    type="card" 
    :with-image="true"
    :with-avatar="true"
    :with-button="true"
    :lines="4"
/>
```

**Structure**:
- Optional image placeholder at top
- Optional avatar + name in body
- Title placeholder
- Multiple text line placeholders
- Optional button placeholder

### 5. List Skeleton

Multiple list items with optional avatars.

```twig
{# Simple list #}
<twig:bs:skeleton type="list" :lines="4" />

{# List with avatars #}
<twig:bs:skeleton type="list" :lines="5" :with-avatar="true" />
```

**Structure**:
- Each item contains:
  - Optional avatar
  - Title line
  - Subtitle line
- Natural width variation per item

### 6. Paragraph Skeleton

Natural text block with varied line widths.

```twig
<twig:bs:skeleton type="paragraph" :lines="5" />
```

**Structure**:
- Multiple lines with 85-100% width
- Last line is shorter (60-75%) for natural appearance
- Spacing between lines

### 7. Custom Skeleton

Simple placeholder with custom dimensions.

```twig
<twig:bs:skeleton 
    type="custom" 
    width="200px" 
    height="150px"
/>
```

## Animation Options

### Wave Animation (Default)

Smooth wave animation across the placeholder.

```twig
<twig:bs:skeleton animation="wave" />
```

### Pulse Animation

Pulsing glow effect.

```twig
<twig:bs:skeleton animation="pulse" />
```

### No Animation

Static placeholder without animation.

```twig
<twig:bs:skeleton animation="none" />
```

## Examples

### Loading Blog Post

```twig
<article class="mb-4">
    {# Author info #}
    <div class="d-flex align-items-center mb-3">
        <twig:bs:skeleton type="avatar" size="md" />
        <div class="ms-3 flex-grow-1">
            <twig:bs:skeleton type="text" :lines="1" width="120px" />
            <twig:bs:skeleton type="text" :lines="1" width="80px" />
        </div>
    </div>
    
    {# Title #}
    <twig:bs:skeleton type="heading" />
    
    {# Content #}
    <twig:bs:skeleton type="paragraph" :lines="6" class="mt-3" />
</article>
```

### Loading Product Card

```twig
<twig:bs:skeleton 
    type="card"
    :with-image="true"
    :with-button="true"
    :lines="3"
    class="h-100"
/>
```

### Loading Comment List

```twig
<div class="comments">
    <twig:bs:skeleton 
        type="list"
        :lines="5"
        :with-avatar="true"
    />
</div>
```

### Loading User Profile Header

```twig
<div class="profile-header">
    <div class="d-flex align-items-center gap-3">
        <twig:bs:skeleton type="avatar" size="xl" />
        <div class="flex-grow-1">
            <twig:bs:skeleton type="heading" width="250px" />
            <twig:bs:skeleton type="text" :lines="2" width="300px" class="mt-2" />
        </div>
    </div>
</div>
```

### Loading Table Rows

```twig
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        {% for i in 1..5 %}
            <tr>
                <td><twig:bs:skeleton type="text" :lines="1" width="150px" /></td>
                <td><twig:bs:skeleton type="text" :lines="1" width="200px" /></td>
                <td><twig:bs:skeleton type="text" :lines="1" width="80px" /></td>
            </tr>
        {% endfor %}
    </tbody>
</table>
```

### Custom Skeleton Layout

```twig
<twig:bs:skeleton>
    {% block content %}
        <div class="d-flex gap-3">
            <span class="placeholder col-2"></span>
            <span class="placeholder col-4"></span>
            <span class="placeholder col-3"></span>
            <span class="placeholder col-3"></span>
        </div>
    {% endblock %}
</twig:bs:skeleton>
```

### Loading Dashboard Stats

```twig
<div class="row">
    {% for i in 1..4 %}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <twig:bs:skeleton type="text" :lines="1" width="80px" class="mb-2" />
                    <twig:bs:skeleton type="heading" width="120px" />
                </div>
            </div>
        </div>
    {% endfor %}
</div>
```

## Accessibility

The skeleton component uses Bootstrap's placeholder classes which include:
- `aria-hidden="true"` is automatically applied to placeholder elements
- Screen readers will skip skeleton content
- Actual content should replace skeletons when loaded
- Consider adding a visually hidden loading message for screen readers

Example with loading message:

```twig
<div>
    <span class="visually-hidden" role="status" aria-live="polite">
        Loading content...
    </span>
    <twig:bs:skeleton type="card" />
</div>
```

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  skeleton:
    type: 'text'                # Default skeleton type
    lines: 3                    # Default number of lines
    animation: 'wave'           # Default animation
    avatar_shape: 'circle'      # Default avatar shape
    with_avatar: false          # Show avatars by default
    class: 'my-skeleton'        # Default classes
```

## Best Practices

### DO:
- ✅ Match skeleton structure to actual content layout
- ✅ Use appropriate types for different content
- ✅ Keep line counts similar to actual content
- ✅ Use consistent animation throughout the app
- ✅ Replace skeletons promptly when content loads
- ✅ Consider using skeleton for perceived performance

### DON'T:
- ❌ Don't use too many skeleton lines (overwhelming)
- ❌ Don't mix different animation types on same page
- ❌ Don't forget to remove skeletons after content loads
- ❌ Don't use skeletons for instant operations
- ❌ Don't create overly complex skeleton layouts

## Related Components

- **Placeholder** (`bs:placeholder`): Basic Bootstrap placeholder component
- **Spinner** (`bs:spinner`): Loading spinner for buttons and inline loading
- **Progress** (`bs:progress`): Progress bars for determinate operations
- **EmptyState** (`bs:empty-state`): Empty state messages for no results

## References

- [Bootstrap Placeholders Documentation](https://getbootstrap.com/docs/5.3/components/placeholders/)
- [Skeleton Screens: Why, When, and How](https://www.nngroup.com/articles/skeleton-screens/)
- [Web.dev: Building a Skeleton Screen](https://web.dev/building-skeleton-screens/)

