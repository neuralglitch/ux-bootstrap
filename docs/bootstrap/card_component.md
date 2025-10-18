# Card Component

The `bs:card` component provides flexible content containers with headers, footers, images, and variants based on Bootstrap 5.3.

## Basic Usage

```twig
{# Simple card #}
<twig:bs:card 
  title="Card title" 
  text="Card content goes here." />

{# Card with blocks #}
<twig:bs:card>
  {% block header %}Featured{% endblock %}
  {% block content %}
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">Card content here.</p>
  {% endblock %}
  {% block footer %}Last updated 3 mins ago{% endblock %}
</twig:bs:card>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `?string` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, `'danger'`, `'warning'`, `'info'`, `'light'`, `'dark'` |
| `outline` | `bool` | `false` | Use outline style (border only) |
| `title` | `?string` | `null` | Card title |
| `subtitle` | `?string` | `null` | Card subtitle |
| `text` | `?string` | `null` | Card body text |
| `img` | `?string` | `null` | Image source URL |
| `imgAlt` | `?string` | `null` | Image alt text |
| `imgPosition` | `?string` | `'top'` | Image position: `'top'`, `'bottom'`, `'overlay'` |
| `header` | `?string` | `null` | Card header text |
| `footer` | `?string` | `null` | Card footer text |
| `textAlign` | `?string` | `null` | Text alignment: `'start'`, `'center'`, `'end'` |
| `border` | `bool` | `true` | Show card border |
| `bg` | `?string` | `null` | Background color |
| `textColor` | `?string` | `null` | Text color |
| `width` | `?string` | `null` | Card width (e.g., `'18rem'`) |
| `id` | `?string` | `null` | Unique identifier |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

```twig
{# Card with image #}
<twig:bs:card 
  img="/images/card-img.jpg" 
  imgAlt="Card image"
  title="Card with image"
  text="Some quick example text." />

{# Colored cards #}
<twig:bs:card variant="primary" title="Primary card" />
<twig:bs:card variant="success" :outline="true" title="Success outline" />

{# Card with header and footer #}
<twig:bs:card 
  header="Featured"
  title="Special title"
  text="Card content"
  footer="2 days ago" />
```

## References

- [Bootstrap 5.3 Cards Documentation](https://getbootstrap.com/docs/5.3/components/card/)
