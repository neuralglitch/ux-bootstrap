# Carousel Component

## Overview

The Carousel component is a slideshow for cycling through a series of content—images, text, or custom markup. It's built with CSS 3D transforms and includes support for previous/next controls, indicators, captions, and various display options including crossfade transitions and dark mode.

This component is based on [Bootstrap 5.3 Carousel](https://getbootstrap.com/docs/5.3/components/carousel/).

**Components:**
- `<twig:bs:carousel>` - Main carousel container
- `<twig:bs:carousel:item>` - Individual slide/item

## Basic Usage

### Simple Carousel with Slotted Items

```twig
<twig:bs:carousel id="myCarousel">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" imgAlt="First slide" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" imgAlt="Second slide" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" imgAlt="Third slide" />
</twig:bs:carousel>
```

### With Controls and Indicators

```twig
<twig:bs:carousel id="carouselWithIndicators" :indicators="true" :controls="true">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" imgAlt="First" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" imgAlt="Second" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" imgAlt="Third" />
</twig:bs:carousel>
```

### Using Array-Based Items

```twig
{% set slides = [
    {imgSrc: '/img1.jpg', imgAlt: 'First slide'},
    {imgSrc: '/img2.jpg', imgAlt: 'Second slide'},
    {imgSrc: '/img3.jpg', imgAlt: 'Third slide'}
] %}

<twig:bs:carousel id="arrayCarousel" :items="slides" />
```

## Carousel Component Props

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `id` | `?string` | auto-generated | Unique carousel ID (required for controls/indicators) |
| `indicators` | `bool` | `false` | Show slide indicators |
| `controls` | `bool` | `true` | Show previous/next controls |
| `fade` | `bool` | `false` | Use crossfade transition instead of slide |
| `dark` | `bool` | `false` | Dark variant for light backgrounds |
| `ride` | `string\|bool` | `false` | Auto-play behavior: `false`, `true`, or `"carousel"` |
| `interval` | `int` | `5000` | Time between slides (milliseconds) |
| `keyboard` | `bool` | `true` | Allow keyboard navigation |
| `pause` | `string\|bool` | `"hover"` | Pause on hover: `"hover"` or `false` |
| `touch` | `bool` | `true` | Enable touch/swipe on mobile |
| `wrap` | `bool` | `true` | Continuous cycling (vs hard stops) |
| `items` | `array` | `[]` | Slide data when not using slots |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## CarouselItem Component Props

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `active` | `bool` | `false` | Mark slide as initially active |
| `imgSrc` | `?string` | `null` | Image source URL |
| `imgAlt` | `?string` | `null` | Image alt text |
| `imgClass` | `?string` | `"d-block w-100"` | Image CSS classes |
| `captionTitle` | `?string` | `null` | Caption title |
| `captionText` | `?string` | `null` | Caption text |
| `interval` | `?int` | `null` | Custom interval for this slide |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### With Captions

```twig
<twig:bs:carousel id="captionCarousel" :indicators="true">
    <twig:bs:carousel:item 
        :active="true"
        imgSrc="/img1.jpg" 
        imgAlt="First slide"
        captionTitle="First Slide Title"
        captionText="Description for the first slide"
    />
    <twig:bs:carousel:item 
        imgSrc="/img2.jpg" 
        imgAlt="Second slide"
        captionTitle="Second Slide Title"
        captionText="Description for the second slide"
    />
</twig:bs:carousel>
```

### Custom Caption Blocks

```twig
<twig:bs:carousel id="customCaptionCarousel">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg">
        {% block caption %}
            <h3>Custom Caption</h3>
            <p>With <strong>HTML</strong> formatting</p>
            <a href="#" class="btn btn-primary">Learn More</a>
        {% endblock %}
    </twig:bs:carousel:item>
</twig:bs:carousel>
```

### Crossfade Transition

```twig
<twig:bs:carousel id="fadeCarousel" :fade="true">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" />
</twig:bs:carousel>
```

### Dark Variant

For use on light backgrounds:

```twig
<twig:bs:carousel id="darkCarousel" :dark="true" :indicators="true">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
</twig:bs:carousel>
```

### Auto-Playing Carousel

```twig
{# Auto-play on page load #}
<twig:bs:carousel id="autoCarousel" ride="carousel" :interval="3000">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" />
</twig:bs:carousel>
```

### Individual Slide Intervals

```twig
<twig:bs:carousel id="variableIntervalCarousel" ride="carousel">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" :interval="1000" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" :interval="3000" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" :interval="5000" />
</twig:bs:carousel>
```

### Without Controls

```twig
<twig:bs:carousel id="noControlsCarousel" :controls="false" :indicators="true">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
</twig:bs:carousel>
```

### Custom Content (No Images)

```twig
<twig:bs:carousel id="textCarousel" :indicators="true">
    <twig:bs:carousel:item :active="true">
        {% block content %}
            <div class="d-flex justify-content-center align-items-center bg-primary text-white" style="height: 400px;">
                <div class="text-center">
                    <h2>First Slide</h2>
                    <p>Custom HTML content</p>
                </div>
            </div>
        {% endblock %}
    </twig:bs:carousel:item>
    <twig:bs:carousel:item>
        {% block content %}
            <div class="d-flex justify-content-center align-items-center bg-success text-white" style="height: 400px;">
                <div class="text-center">
                    <h2>Second Slide</h2>
                    <p>More custom content</p>
                </div>
            </div>
        {% endblock %}
    </twig:bs:carousel:item>
</twig:bs:carousel>
```

### Disable Touch Swiping

```twig
<twig:bs:carousel id="noTouchCarousel" :touch="false">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
</twig:bs:carousel>
```

### No Wrapping (Hard Stops)

```twig
<twig:bs:carousel id="noWrapCarousel" :wrap="false">
    <twig:bs:carousel:item :active="true" imgSrc="/img1.jpg" />
    <twig:bs:carousel:item imgSrc="/img2.jpg" />
    <twig:bs:carousel:item imgSrc="/img3.jpg" />
</twig:bs:carousel>
```

## Accessibility

### ARIA Attributes

The component automatically includes:
- Visually hidden labels for previous/next controls
- Proper ARIA labels for indicator buttons
- Slide numbering for indicators

### Best Practices

1. **Always provide `imgAlt` text** for images
2. **Use descriptive captions** to provide context
3. **Avoid auto-play** when possible (UX consideration)
4. **Provide keyboard navigation** (enabled by default)
5. **Test with screen readers**

### Example with Full Accessibility

```twig
<twig:bs:carousel 
    id="accessibleCarousel" 
    :indicators="true"
    :attr="{'aria-label': 'Product image gallery'}"
>
    <twig:bs:carousel:item 
        :active="true"
        imgSrc="/product1.jpg" 
        imgAlt="Product view from front showing blue color"
        captionTitle="Front View"
    />
    <twig:bs:carousel:item 
        imgSrc="/product2.jpg" 
        imgAlt="Product view from side showing dimensions"
        captionTitle="Side View"
    />
</twig:bs:carousel>
```

## Configuration

### Global Defaults (`config/packages/ux_bootstrap.yaml`)

```yaml
neuralglitch_ux_bootstrap:
  carousel:
    id: null
    indicators: false
    controls: true
    fade: false
    dark: false
    ride: false         # false | true | 'carousel'
    interval: 5000      # milliseconds
    keyboard: true
    pause: 'hover'      # 'hover' | false
    touch: true
    wrap: true
    class: null
    attr: {}

  carousel_item:
    active: false
    img_class: 'd-block w-100'
    class: null
    attr: {}
```

### Override Defaults

```yaml
# Change default behavior for all carousels
neuralglitch_ux_bootstrap:
  carousel:
    indicators: true    # Show indicators by default
    interval: 3000      # Faster transitions
    fade: true          # Use crossfade by default
```

## JavaScript Behavior

### Automatic Initialization

Bootstrap's carousel JavaScript automatically initializes when:
- `ride="carousel"` attribute is present
- User interacts with controls

### Manual Control

You can manually control carousels with JavaScript:

```javascript
// Get carousel instance
const myCarousel = document.querySelector('#myCarousel');
const carousel = bootstrap.Carousel.getInstance(myCarousel);

// Or create new instance
const carousel = new bootstrap.Carousel(myCarousel, {
  interval: 2000,
  wrap: false
});

// Control methods
carousel.cycle();     // Start cycling
carousel.pause();     // Pause
carousel.next();      // Next slide
carousel.prev();      // Previous slide
carousel.to(2);       // Go to slide index 2
```

### Events

Listen to carousel events:

```javascript
const myCarousel = document.getElementById('myCarousel');

myCarousel.addEventListener('slide.bs.carousel', event => {
  console.log(`Sliding from ${event.from} to ${event.to}`);
});

myCarousel.addEventListener('slid.bs.carousel', event => {
  console.log('Slide transition complete');
});
```

## Testing

The component includes comprehensive tests covering:
- Default options rendering
- All property variations
- Auto-ID generation
- Data attribute generation
- Controls and indicators
- Fade and dark variants
- Ride, interval, keyboard, pause, touch, wrap options
- Custom classes and attributes
- Config defaults
- Combined options

Run tests:
```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/CarouselTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Bootstrap/CarouselItemTest.php
```

## Related Components

- **[Button](button_component.md)** - Can be used in custom slide content
- **[Card](card_component.md)** - Alternative for displaying image galleries
- **Badge** - For labeling slides

## Performance Considerations

1. **Lazy Load Images**: For many slides, consider lazy loading
2. **Optimize Images**: Use appropriate sizes and formats
3. **Limit Auto-Play**: Can impact performance and UX
4. **Reduce Animation**: Use `fade` for smoother transitions on some devices

## Browser Support

Follows Bootstrap 5.3 browser support:
- Chrome, Firefox, Safari, Edge (latest)
- Mobile browsers on iOS and Android
- Reduced motion support via `prefers-reduced-motion` media query

## References

- [Bootstrap 5.3 Carousel Documentation](https://getbootstrap.com/docs/5.3/components/carousel/)
- [Bootstrap Carousel JavaScript API](https://getbootstrap.com/docs/5.3/components/carousel/#usage)
- [WCAG Carousel Accessibility Guidelines](https://www.w3.org/WAI/tutorials/carousels/)

