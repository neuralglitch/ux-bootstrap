# Rating Component

## Overview

The **Rating** component (`bs:rating`) is a versatile, accessible rating display and input component designed for reviews, feedback forms, product ratings, and skill level indicators. It supports multiple display modes (stars, hearts, circles), interactive and read-only states, half-star ratings, and comprehensive customization options.

**Location**: Extra Component  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag**: `<twig:bs:rating />`

## Basic Usage

### Simple Star Rating (Read-only)

```twig
<twig:bs:rating :value="4.5" :readonly="true" />
```

### Interactive Rating

```twig
<twig:bs:rating :value="3" :max="5" />
```

### Rating with Value Display

```twig
<twig:bs:rating 
    :value="4.2" 
    :readonly="true" 
    :showValue="true" 
    :halfStars="true" 
/>
```

### Rating with Count

```twig
<twig:bs:rating 
    :value="4" 
    :max="5" 
    :showCount="true" 
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | `float` | `0` | Current rating value (supports decimals for half stars) |
| `max` | `int` | `5` | Maximum rating value |
| `mode` | `string` | `'stars'` | Display mode: `'stars'`, `'hearts'`, `'circles'`, `'custom'` |
| `readonly` | `bool` | `false` | If `true`, display only; if `false`, interactive |
| `halfStars` | `bool` | `false` | Allow half-star ratings (e.g., 4.5) |
| `size` | `string` | `'default'` | Size: `'sm'`, `'default'`, `'lg'` |
| `variant` | `string\|null` | `null` | Bootstrap color variant for filled items (default: `'warning'`) |
| `emptyVariant` | `string` | `'secondary'` | Bootstrap color variant for empty items |
| `customIcon` | `string\|null` | `null` | Custom icon HTML/emoji (for `mode='custom'`) |
| `showValue` | `bool` | `false` | Show numeric value (e.g., "4.5") |
| `showCount` | `bool` | `false` | Show count/max (e.g., "4/5") |
| `showText` | `bool` | `false` | Show text label |
| `text` | `string\|null` | `null` | Custom text label |
| `textPosition` | `string` | `'end'` | Text position: `'start'`, `'end'` |
| `ariaLabel` | `string\|null` | `null` | Custom ARIA label for accessibility |
| `ariaLive` | `bool` | `false` | Announce changes to screen readers (for interactive ratings) |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Display Modes

### Stars (Default)

```twig
<twig:bs:rating :value="4" mode="stars" />
```

Uses star icons: ★ (filled), ⯨ (half), ☆ (empty)

### Hearts

```twig
<twig:bs:rating :value="4" mode="hearts" variant="danger" />
```

Uses heart icons: ♥ (filled), ♡ (empty)

### Circles

```twig
<twig:bs:rating :value="3" mode="circles" />
```

Uses circle icons: ● (filled), ◐ (half), ○ (empty)

### Custom Icons

```twig
<twig:bs:rating 
    :value="4" 
    mode="custom" 
    customIcon="👍" 
/>
```

## Examples

### Product Rating (Read-only with Value)

```twig
<div class="d-flex align-items-center">
    <twig:bs:rating 
        :value="4.3" 
        :readonly="true" 
        :halfStars="true" 
        :showValue="true" 
        variant="warning"
    />
    <span class="text-muted ms-2">(127 reviews)</span>
</div>
```

### Feedback Form (Interactive)

```twig
<div class="mb-3">
    <label class="form-label">Rate your experience</label>
    <twig:bs:rating 
        :value="0" 
        :max="5" 
        size="lg"
        :ariaLive="true"
        ariaLabel="Rate your experience from 1 to 5 stars"
    />
</div>
```

### Skill Level Indicator

```twig
<twig:bs:rating 
    :value="3" 
    :max="5" 
    :readonly="true" 
    :showText="true" 
    text="Intermediate" 
    textPosition="end"
    variant="primary"
/>
```

### Multiple Criteria Rating

```twig
<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>Quality</span>
        <twig:bs:rating :value="5" :readonly="true" size="sm" />
    </div>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>Value</span>
        <twig:bs:rating :value="4" :readonly="true" size="sm" />
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <span>Service</span>
        <twig:bs:rating :value="4.5" :readonly="true" :halfStars="true" size="sm" />
    </div>
</div>
```

### Review Card

```twig
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="card-title mb-0">Great product!</h5>
            <twig:bs:rating :value="5" :readonly="true" variant="warning" />
        </div>
        <p class="text-muted mb-2">
            <small>by John Doe on {{ review.date|date('M d, Y') }}</small>
        </p>
        <p class="card-text">{{ review.text }}</p>
    </div>
</div>
```

### Size Variants

```twig
{# Small #}
<twig:bs:rating :value="4" :readonly="true" size="sm" />

{# Default #}
<twig:bs:rating :value="4" :readonly="true" />

{# Large #}
<twig:bs:rating :value="4" :readonly="true" size="lg" />
```

### Color Variants

```twig
{# Warning (default for filled) #}
<twig:bs:rating :value="4" :readonly="true" />

{# Primary #}
<twig:bs:rating :value="4" :readonly="true" variant="primary" />

{# Success #}
<twig:bs:rating :value="4" :readonly="true" variant="success" />

{# Danger #}
<twig:bs:rating :value="4" :readonly="true" variant="danger" />
```

### With Different Max Values

```twig
{# 3-star rating #}
<twig:bs:rating :value="2" :max="3" :readonly="true" />

{# 10-star rating #}
<twig:bs:rating :value="8" :max="10" :readonly="true" :showCount="true" />
```

### Text Label Positions

```twig
{# Text at the end (default) #}
<twig:bs:rating 
    :value="4" 
    :readonly="true" 
    :showText="true" 
    text="Excellent" 
    textPosition="end"
/>

{# Text at the start #}
<twig:bs:rating 
    :value="4" 
    :readonly="true" 
    :showText="true" 
    text="Rating:" 
    textPosition="start"
/>
```

## Accessibility

The Rating component is designed with accessibility in mind:

- **ARIA Role**: The component has `role="img"` for screen readers
- **ARIA Label**: Auto-generated label (e.g., "Rating: 4 out of 5") or custom via `ariaLabel` prop
- **ARIA Live**: For interactive ratings, set `ariaLive="true"` to announce changes
- **Keyboard Navigation**: Interactive ratings support keyboard navigation (requires JavaScript implementation)
- **Visual Hidden Labels**: Rating items include appropriate ARIA labels

### Example with Full Accessibility

```twig
<twig:bs:rating 
    :value="3" 
    :max="5" 
    ariaLabel="Product rating: 3 out of 5 stars"
    :ariaLive="true"
    readonly="false"
/>
```

## Configuration

Default configuration can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  rating:
    value: 0
    max: 5
    mode: 'stars'
    readonly: false
    half_stars: false
    size: 'default'
    variant: null  # Uses 'warning' for filled items by default
    empty_variant: 'secondary'
    show_value: false
    show_count: false
    show_text: false
    text_position: 'end'
    aria_live: false
    class: null
    attr: {}
```

### Override Defaults

```yaml
neuralglitch_ux_bootstrap:
  rating:
    variant: 'primary'  # All ratings use primary color by default
    size: 'lg'          # All ratings are large by default
    readonly: true      # All ratings are read-only by default
    class: 'my-rating'  # Add custom class to all ratings
```

## Use Cases

### 1. E-Commerce Product Reviews

```twig
<div class="product-rating">
    <twig:bs:rating 
        :value="product.averageRating" 
        :readonly="true" 
        :halfStars="true" 
        :showValue="true"
    />
    <span class="text-muted ms-2">({{ product.reviewCount }} reviews)</span>
</div>
```

### 2. Course/Content Rating

```twig
<twig:bs:rating 
    :value="course.rating" 
    :readonly="true" 
    :showValue="true" 
    variant="warning"
    class="course-rating"
/>
```

### 3. User Feedback Form

```twig
<form>
    <div class="mb-3">
        <label class="form-label">How would you rate this service?</label>
        <twig:bs:rating 
            :value="0" 
            :max="5" 
            size="lg"
            :ariaLive="true"
        />
    </div>
    <button type="submit" class="btn btn-primary">Submit Feedback</button>
</form>
```

### 4. Skill Level Display

```twig
<div class="skill-item">
    <span class="skill-name">JavaScript</span>
    <twig:bs:rating 
        :value="4" 
        :max="5" 
        :readonly="true" 
        variant="primary"
        size="sm"
    />
</div>
```

### 5. Restaurant/Hotel Rating

```twig
<div class="rating-summary">
    <h3>{{ restaurant.name }}</h3>
    <twig:bs:rating 
        :value="restaurant.rating" 
        :readonly="true" 
        :halfStars="true" 
        mode="stars"
        variant="warning"
    />
    <p class="text-muted">Based on {{ restaurant.reviewCount }} reviews</p>
</div>
```

## CSS Customization

The component generates the following CSS classes:

- `.rating` - Main container
- `.rating-{mode}` - Mode-specific class (e.g., `.rating-stars`, `.rating-hearts`)
- `.rating-readonly` - Applied when read-only
- `.rating-interactive` - Applied when interactive
- `.rating-sm` - Small size
- `.rating-lg` - Large size
- `.rating-items` - Container for rating items
- `.rating-item` - Individual rating item
- `.rating-item-filled` - Filled item
- `.rating-item-half` - Half-filled item
- `.rating-item-empty` - Empty item
- `.rating-value` - Numeric value display
- `.rating-count` - Count display
- `.rating-text` - Text label

### Custom Styles Example

```css
.rating {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.rating-items {
    display: inline-flex;
    gap: 0.125rem;
}

.rating-sm .rating-item {
    font-size: 1rem;
}

.rating-lg .rating-item {
    font-size: 2rem;
}

.rating-interactive .rating-item-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: transform 0.2s;
}

.rating-interactive .rating-item-button:hover {
    transform: scale(1.2);
}
```

## Testing

The Rating component includes comprehensive tests covering:

- Default options and configuration
- Read-only vs interactive modes
- Value and max options
- All display modes (stars, hearts, circles)
- Half-star support
- Size variants
- Color variants
- Text display and positioning
- ARIA label generation
- Custom classes and attributes
- Config defaults application

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/RatingTest.php
```

## Related Components

- **[Badge](badge_component.md)** - For numeric indicators
- **[Progress](progress_component.md)** - For progress bars
- **[Stat](stat_component.md)** - For displaying metrics and KPIs

## References

- [Bootstrap Colors](https://getbootstrap.com/docs/5.3/utilities/colors/)
- [Bootstrap Text Utilities](https://getbootstrap.com/docs/5.3/utilities/text/)
- [WAI-ARIA Authoring Practices](https://www.w3.org/WAI/ARIA/apg/)

