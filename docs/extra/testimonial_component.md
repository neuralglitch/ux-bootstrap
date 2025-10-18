# Testimonial Component

The `bs:testimonial` component provides flexible testimonial sections for displaying customer reviews, social proof, and user feedback with various layout options.

## Basic Usage

```twig
{# Simple testimonial #}
<twig:bs:testimonial 
  quote="This product changed my business completely!"
  author="Jane Doe"
  role="CEO"
  company="Acme Corp"
  avatarSrc="/images/jane.jpg"
  :rating="5" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'single'` | Layout variant: `'single'`, `'featured'`, `'grid'`, `'wall'`, `'minimal'` |
| `quote` | `?string` | `null` | Testimonial quote/text |
| `author` | `?string` | `null` | Author name |
| `role` | `?string` | `null` | Author role/title |
| `company` | `?string` | `null` | Author company |
| `avatarSrc` | `?string` | `null` | Avatar image URL |
| `avatarAlt` | `?string` | `null` | Avatar alt text (defaults to author name) |
| `rating` | `?int` | `null` | Star rating (1-5) |
| `container` | `string` | `'container'` | Container type: `'container'`, `'container-fluid'`, `'container-lg'` |
| `alignment` | `string` | `'left'` | Text alignment: `'left'`, `'center'`, `'right'` |
| `columns` | `int` | `3` | Number of columns for grid/wall variants (2, 3, or 4) |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Variants

### 1. Single (Default)

Centered single testimonial in a card layout.

```twig
<twig:bs:testimonial 
  variant="single"
  quote="Outstanding service and support. Highly recommended!"
  author="John Smith"
  role="Product Manager"
  company="Tech Solutions Inc."
  avatarSrc="/images/john.jpg"
  :rating="5" />
```

### 2. Featured

Large, prominent testimonial for featured reviews.

```twig
<twig:bs:testimonial 
  variant="featured"
  quote="This is the best decision we've made for our business. The ROI has been incredible!"
  author="Sarah Johnson"
  role="Founder & CEO"
  company="StartupCo"
  avatarSrc="/images/sarah.jpg"
  :rating="5" />
```

### 3. Grid

Grid layout for multiple testimonials (requires custom content).

```twig
<twig:bs:testimonial variant="grid">
  {% block content %}
    <div class="col-md-6 col-lg-4 mb-4">
      {# Testimonial item 1 #}
      <div class="card h-100">
        <div class="card-body">
          <p class="fst-italic">"Great product!"</p>
          <div class="fw-bold">John Doe</div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-4">
      {# Testimonial item 2 #}
      <div class="card h-100">
        <div class="card-body">
          <p class="fst-italic">"Excellent service!"</p>
          <div class="fw-bold">Jane Smith</div>
        </div>
      </div>
    </div>
    {# More items... #}
  {% endblock %}
</twig:bs:testimonial>
```

### 4. Wall

Masonry-style wall of testimonials (requires custom content).

```twig
<twig:bs:testimonial variant="wall" :columns="3">
  {% block content %}
    <div class="col">
      <div class="card mb-3">
        <div class="card-body">
          <p>"Amazing experience!"</p>
          <small>- Customer A</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card mb-3">
        <div class="card-body">
          <p>"Highly recommended!"</p>
          <small>- Customer B</small>
        </div>
      </div>
    </div>
    {# More items... #}
  {% endblock %}
</twig:bs:testimonial>
```

### 5. Minimal

Clean, minimal testimonial with border accent.

```twig
<twig:bs:testimonial 
  variant="minimal"
  quote="Simple, elegant, and effective. Everything we needed."
  author="Mike Chen"
  role="Developer"
  company="WebDev Studio"
  :rating="5" />
```

## Examples

### With Rating

```twig
<twig:bs:testimonial 
  quote="Five stars all the way!"
  author="Emily Brown"
  role="Marketing Director"
  :rating="5" />
```

### Centered Alignment

```twig
<twig:bs:testimonial 
  quote="Perfect for our needs"
  author="David Lee"
  alignment="center"
  avatarSrc="/images/david.jpg" />
```

### Full Width Container

```twig
<twig:bs:testimonial 
  container="container-fluid"
  variant="featured"
  quote="Game changer for our team" />
```

### Custom Content

```twig
<twig:bs:testimonial variant="single">
  {% block content %}
    <div class="card border-0 shadow-lg">
      <div class="card-body p-5 text-center">
        <div class="mb-3">
          <i class="bi bi-quote display-4 text-primary"></i>
        </div>
        <blockquote class="mb-4">
          <p class="fs-4">Custom testimonial with your own HTML structure.</p>
        </blockquote>
        <div class="d-flex justify-content-center align-items-center gap-3">
          <img src="/images/avatar.jpg" class="rounded-circle" width="64" height="64" alt="Avatar">
          <div class="text-start">
            <div class="fw-bold">Custom Name</div>
            <div class="text-muted">Custom Role</div>
          </div>
        </div>
      </div>
    </div>
  {% endblock %}
</twig:bs:testimonial>
```

### With Multiple Columns

```twig
<twig:bs:testimonial variant="wall" :columns="4">
  {% block content %}
    {# 4-column grid of testimonials #}
  {% endblock %}
</twig:bs:testimonial>
```

## Star Ratings

The component includes built-in star rating support using Bootstrap Icons:

```twig
<twig:bs:testimonial 
  quote="Excellent service!"
  author="Customer Name"
  :rating="5" />
```

Ratings are displayed using `bi-star-fill` (filled) and `bi-star` (empty) icons in warning color.

**Note**: Requires Bootstrap Icons to be loaded in your project:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
```

## Accessibility

- Uses semantic HTML with `<blockquote>` for quotes
- Avatar images include proper alt text
- Role and company information is properly marked up
- Star ratings include appropriate ARIA labels

## Configuration

Default configuration can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  testimonial:
    variant: 'single'
    quote: null
    author: null
    role: null
    company: null
    avatar_src: null
    avatar_alt: null
    rating: null
    container: 'container'
    alignment: 'left'
    columns: 3
    class: null
    attr: {}
```

## Testing

Run tests for the Testimonial component:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/TestimonialTest.php
```

## Related Components

- [Hero Component](hero_component.md) - For hero sections
- [Avatar Component](avatar_component.md) - For profile pictures
- [Rating Component](rating_component.md) - For standalone ratings
- [Card Component](card_component.md) - For card layouts

## References

- [Bootstrap 5.3 Cards](https://getbootstrap.com/docs/5.3/components/card/)
- [Bootstrap 5.3 Grid System](https://getbootstrap.com/docs/5.3/layout/grid/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

