# Lightbox Component

The Lightbox component provides a modern, feature-rich image gallery viewer with support for navigation, zoom, keyboard controls, and touch gestures. Perfect for portfolios, product galleries, photo albums, and real estate listings.

## Overview

- **Component**: `bs:lightbox`
- **Type**: Extra Component
- **Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`
- **Template**: `templates/components/extra/lightbox.html.twig`
- **Stimulus Controller**: `bs-lightbox` (`assets/controllers/bs_lightbox_controller.js`)

## Features

✅ **Multiple Display Modes**
- Image navigation (prev/next)
- Thumbnail navigation
- Image counter
- Captions support

✅ **Interactive Features**
- Zoom functionality (click or mouse wheel)
- Keyboard navigation (arrows, escape)
- Touch/swipe gestures
- Fullscreen mode
- Autoplay slideshow

✅ **Customization**
- Multiple transition effects (fade, slide, zoom)
- Configurable controls
- Download button (optional)
- Custom styling support

✅ **Accessibility**
- ARIA attributes
- Keyboard navigation
- Screen reader support

## Basic Usage

### Simple Gallery

```twig
<twig:bs:lightbox :images="[
    {'src': '/images/photo1.jpg', 'alt': 'Photo 1', 'caption': 'Beautiful landscape'},
    {'src': '/images/photo2.jpg', 'alt': 'Photo 2', 'caption': 'City skyline'},
    {'src': '/images/photo3.jpg', 'alt': 'Photo 3', 'caption': 'Ocean sunset'}
]" />
```

### With Thumbnails

```twig
<twig:bs:lightbox
    :images="[
        {
            'src': '/images/full/photo1.jpg',
            'thumbnail': '/images/thumb/photo1.jpg',
            'alt': 'Photo 1',
            'caption': 'Beautiful landscape'
        },
        {
            'src': '/images/full/photo2.jpg',
            'thumbnail': '/images/thumb/photo2.jpg',
            'alt': 'Photo 2',
            'caption': 'City skyline'
        }
    ]"
    :showThumbnails="true"
/>
```

### Start at Specific Image

```twig
<twig:bs:lightbox
    :images="galleryImages"
    :startIndex="2"  {# Start at 3rd image (0-indexed) #}
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `images` | array | `[]` | Array of image objects with `src`, `alt`, `caption`, `thumbnail` |
| `startIndex` | int | `0` | Initial image to display (0-based) |
| `showThumbnails` | bool | `false` | Show thumbnail navigation bar |
| `showCounter` | bool | `true` | Show image counter (e.g., "1 / 5") |
| `showCaptions` | bool | `true` | Show image captions |
| `enableZoom` | bool | `true` | Enable zoom functionality |
| `enableKeyboard` | bool | `true` | Enable keyboard navigation |
| `enableSwipe` | bool | `true` | Enable swipe gestures on touch devices |
| `closeOnBackdrop` | bool | `true` | Close when clicking outside image |
| `transition` | string | `'fade'` | Transition effect: `'fade'`, `'slide'`, `'zoom'`, `'none'` |
| `transitionDuration` | int | `300` | Transition duration in milliseconds |
| `autoplay` | bool | `false` | Enable autoplay slideshow |
| `autoplayInterval` | int | `3000` | Autoplay interval in milliseconds |
| `showDownload` | bool | `false` | Show download button |
| `showFullscreen` | bool | `true` | Show fullscreen button |
| `showClose` | bool | `true` | Show close button |
| `id` | string | `null` | Custom ID (auto-generated if not provided) |
| `class` | string | `null` | Additional CSS classes |
| `attr` | array | `{}` | Additional HTML attributes |

### Image Object Structure

```php
[
    'src' => '/path/to/full-image.jpg',      // Required: Full-size image URL
    'alt' => 'Image description',             // Optional: Alt text for accessibility
    'caption' => 'Image caption text',        // Optional: Caption displayed below image
    'thumbnail' => '/path/to/thumbnail.jpg'   // Optional: Thumbnail URL (defaults to src)
]
```

## Examples

### Portfolio Gallery

Perfect for showcasing photography or design work:

```twig
<twig:bs:lightbox
    :images="[
        {
            'src': '/portfolio/project1-full.jpg',
            'thumbnail': '/portfolio/project1-thumb.jpg',
            'alt': 'Website Redesign',
            'caption': 'Modern e-commerce website redesign for TechCorp'
        },
        {
            'src': '/portfolio/project2-full.jpg',
            'thumbnail': '/portfolio/project2-thumb.jpg',
            'alt': 'Mobile App',
            'caption': 'iOS fitness tracking application'
        },
        {
            'src': '/portfolio/project3-full.jpg',
            'thumbnail': '/portfolio/project3-thumb.jpg',
            'alt': 'Brand Identity',
            'caption': 'Complete brand identity for startup'
        }
    ]"
    :showThumbnails="true"
    :showCaptions="true"
    transition="zoom"
/>
```

### Product Gallery

Display product images with minimal UI:

```twig
<twig:bs:lightbox
    :images="productImages"
    :showCounter="false"
    :showCaptions="false"
    transition="slide"
    class="product-lightbox"
/>
```

### Photo Album with Autoplay

Create a slideshow experience:

```twig
<twig:bs:lightbox
    :images="albumPhotos"
    :autoplay="true"
    :autoplayInterval="4000"
    :showThumbnails="true"
    transition="fade"
/>
```

### Real Estate Listing

Full-featured gallery for property photos:

```twig
<twig:bs:lightbox
    :images="propertyImages"
    :showThumbnails="true"
    :showDownload="true"
    :showFullscreen="true"
    :enableZoom="true"
    class="property-gallery"
/>
```

### Minimal Gallery

Simple gallery with basic features:

```twig
<twig:bs:lightbox
    :images="images"
    :showCounter="false"
    :showThumbnails="false"
    :showCaptions="false"
    :showDownload="false"
    :showFullscreen="false"
    transition="none"
/>
```

### Custom Transitions

Try different transition effects:

```twig
{# Slide transition #}
<twig:bs:lightbox :images="images" transition="slide" :transitionDuration="400" />

{# Zoom transition #}
<twig:bs:lightbox :images="images" transition="zoom" :transitionDuration="300" />

{# No transition #}
<twig:bs:lightbox :images="images" transition="none" />
```

### Dynamically Load Images

Load images from a controller:

```php
// In your controller
#[Route('/gallery/{id}', name: 'gallery_show')]
public function show(Gallery $gallery): Response
{
    $images = [];
    
    foreach ($gallery->getPhotos() as $photo) {
        $images[] = [
            'src' => $photo->getFullUrl(),
            'thumbnail' => $photo->getThumbnailUrl(),
            'alt' => $photo->getTitle(),
            'caption' => $photo->getDescription(),
        ];
    }
    
    return $this->render('gallery/show.html.twig', [
        'gallery' => $gallery,
        'images' => $images,
    ]);
}
```

```twig
{# In your template #}
<twig:bs:lightbox
    :images="images"
    :showThumbnails="true"
    :showDownload="true"
/>
```

## Keyboard Controls

When the lightbox is open:

- **→ (Right Arrow)**: Next image
- **← (Left Arrow)**: Previous image
- **Esc**: Close lightbox

## Touch Gestures

On touch devices:

- **Swipe Right**: Previous image
- **Swipe Left**: Next image
- **Tap Image**: Toggle zoom
- **Tap Outside**: Close lightbox (if `closeOnBackdrop` is true)

## Zoom Functionality

When zoom is enabled:

- **Click Image**: Toggle zoom in/out
- **Mouse Wheel**: Zoom in/out incrementally
- **Pinch Gesture**: Zoom on touch devices (mobile)

## Custom Styling

### Custom CSS Classes

```twig
<twig:bs:lightbox
    :images="images"
    class="my-custom-lightbox large-images"
/>
```

```css
/* Custom styles */
.my-custom-lightbox .lightbox-image {
    max-height: 80vh;
}

.my-custom-lightbox .lightbox-caption {
    font-size: 1.2rem;
    background: rgba(0, 0, 0, 0.9);
}

.my-custom-lightbox .lightbox-toolbar {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), transparent);
}
```

### Override Styles

```scss
// Override lightbox styles
.lightbox {
    // Custom backdrop
    .lightbox-backdrop {
        background-color: rgba(255, 255, 255, 0.95);
    }
    
    // Custom navigation buttons
    .lightbox-nav {
        width: 4rem;
        height: 4rem;
        background: var(--bs-primary);
        
        &:hover {
            background: var(--bs-primary-dark);
        }
    }
    
    // Custom thumbnails
    .lightbox-thumbnail-btn {
        width: 80px;
        height: 80px;
        border-width: 3px;
        
        &.active {
            border-color: var(--bs-primary);
        }
    }
}
```

## Accessibility

The lightbox component includes comprehensive accessibility features:

- **ARIA Attributes**: Proper `role`, `aria-modal`, `aria-label` attributes
- **Keyboard Navigation**: Full keyboard support (arrows, escape)
- **Screen Reader Support**: Image alt text and captions are announced
- **Focus Management**: Focus is trapped within the lightbox when open
- **Close Button**: Clearly labeled close button for screen readers

### Best Practices

1. **Always provide alt text** for all images
2. **Use descriptive captions** to provide context
3. **Ensure keyboard navigation** is enabled (default: true)
4. **Test with screen readers** to verify announcements

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  lightbox:
    images: []
    start_index: 0
    show_thumbnails: false
    show_counter: true
    show_captions: true
    enable_zoom: true
    enable_keyboard: true
    enable_swipe: true
    close_on_backdrop: true
    transition: 'fade'
    transition_duration: 300
    autoplay: false
    autoplay_interval: 3000
    show_download: false
    show_fullscreen: true
    show_close: true
    id: null
    class: null
    attr: {}
```

## JavaScript Events

The lightbox dispatches custom events you can listen to:

```javascript
const lightbox = document.querySelector('[data-controller="bs-lightbox"]');

// When lightbox opens
lightbox.addEventListener('lightbox:opened', (event) => {
    console.log('Lightbox opened at index:', event.detail.index);
});

// When lightbox closes
lightbox.addEventListener('lightbox:closed', () => {
    console.log('Lightbox closed');
});

// When image changes
lightbox.addEventListener('lightbox:changed', (event) => {
    console.log('Image changed to:', event.detail.index, event.detail.image);
});
```

## Testing

Run the component tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/LightboxTest.php
```

The test suite covers:
- Default configuration
- Image array handling
- All boolean props
- Transition effects
- Keyboard/swipe/zoom options
- Custom styling
- Edge cases (empty images, out of bounds indices)

## Browser Support

The lightbox component works in all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

**Features with fallbacks:**
- Fullscreen API (degrades gracefully if not supported)
- Touch events (desktop uses mouse events)
- CSS transforms (falls back to basic transitions)

## Performance Tips

1. **Use thumbnails**: Provide smaller thumbnail images for the navigation bar
2. **Lazy load**: Only load full images when needed
3. **Optimize images**: Compress images before uploading
4. **Limit gallery size**: Consider pagination for very large galleries (>50 images)
5. **Disable autoplay**: Only enable autoplay when appropriate

## Common Use Cases

### 1. Portfolio/Photography

```twig
<twig:bs:lightbox
    :images="portfolioImages"
    :showThumbnails="true"
    :showCaptions="true"
    :enableZoom="true"
    transition="zoom"
    :transitionDuration="400"
/>
```

### 2. E-commerce Product Gallery

```twig
<twig:bs:lightbox
    :images="productImages"
    :showCounter="true"
    :showCaptions="false"
    :enableZoom="true"
    transition="slide"
/>
```

### 3. Real Estate Listings

```twig
<twig:bs:lightbox
    :images="propertyPhotos"
    :showThumbnails="true"
    :showDownload="true"
    :showFullscreen="true"
    :showCaptions="true"
/>
```

### 4. Photo Album/Slideshow

```twig
<twig:bs:lightbox
    :images="albumPhotos"
    :autoplay="true"
    :autoplayInterval="5000"
    :showThumbnails="true"
    transition="fade"
/>
```

### 5. Blog Post Images

```twig
<twig:bs:lightbox
    :images="articleImages"
    :showCounter="false"
    :showCaptions="true"
    transition="fade"
    class="article-lightbox"
/>
```

## Related Components

- **Carousel** (`bs:carousel`): Automatic slideshow with indicators
- **Card** (`bs:card`): Display individual images with descriptions
- **Modal** (`bs:modal`): General-purpose overlay content

## References

- [Bootstrap 5.3 Modal](https://getbootstrap.com/docs/5.3/components/modal/)
- [Stimulus Controller Targets](https://stimulus.hotwired.dev/reference/targets)
- [Fullscreen API (MDN)](https://developer.mozilla.org/en-US/docs/Web/API/Fullscreen_API)
- [Touch Events (MDN)](https://developer.mozilla.org/en-US/docs/Web/API/Touch_events)

