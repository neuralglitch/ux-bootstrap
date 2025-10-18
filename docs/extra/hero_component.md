# Hero Component

The `bs:hero` component provides flexible hero/banner sections with multiple layout variants for landing pages and feature sections.

## Basic Usage

```twig
{# Simple hero #}
<twig:bs:hero 
  title="Build something great" 
  lead="Start your next project with our platform" 
  ctaLabel="Get Started" 
  ctaHref="/signup" />
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'centered'` | Layout variant: `'centered'`, `'screenshot_centered'`, `'image_left'`, `'signup'`, `'border_image'` |
| `title` | `string` | `'Build something great'` | Hero title |
| `lead` | `?string` | `null` | Lead text / subtitle |
| `ctaLabel` | `?string` | `null` | Primary CTA button text |
| `ctaHref` | `?string` | `null` | Primary CTA button URL |
| `ctaVariant` | `?string` | `'primary'` | Primary CTA button variant |
| `ctaSize` | `?string` | `'lg'` | Primary CTA button size |
| `secondaryCtaLabel` | `?string` | `null` | Secondary CTA button text |
| `secondaryCtaHref` | `?string` | `null` | Secondary CTA button URL |
| `secondaryCtaVariant` | `?string` | `'outline-secondary'` | Secondary CTA variant |
| `secondaryCtaSize` | `?string` | `'lg'` | Secondary CTA size |
| `imageSrc` | `?string` | `null` | Image source URL (for `image_left`, `border_image` variants) |
| `imageAlt` | `?string` | `null` | Image alt text |
| `screenshotSrc` | `?string` | `null` | Screenshot source URL (for `screenshot_centered` variant) |
| `fullHeight` | `bool` | `false` | Full viewport height (`min-vh-100`) |
| `container` | `string` | `'container'` | Container type: `'container'`, `'container-fluid'`, `'container-lg'` |
| `class` | `string` | `''` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Variants

### 1. Centered (Default)
Simple centered hero with title, lead, and CTA buttons.

```twig
<twig:bs:hero 
  variant="centered"
  title="Welcome to Our Platform"
  lead="The best solution for your business"
  ctaLabel="Get Started"
  ctaHref="/signup"
  secondaryCtaLabel="Learn More"
  secondaryCtaHref="/about" />
```

### 2. Screenshot Centered
Centered content with large screenshot below.

```twig
<twig:bs:hero 
  variant="screenshot_centered"
  title="See it in action"
  lead="Take a look at our platform"
  screenshotSrc="/images/screenshot.png"
  ctaLabel="Try it now"
  ctaHref="/demo" />
```

### 3. Image Left
Two-column layout with image on left, content on right.

```twig
<twig:bs:hero 
  variant="image_left"
  title="Feature Rich Platform"
  lead="Everything you need in one place"
  imageSrc="/images/feature.jpg"
  imageAlt="Platform features"
  ctaLabel="Explore Features"
  ctaHref="/features" />
```

### 4. Signup
Optimized for signup/conversion with form space.

```twig
<twig:bs:hero 
  variant="signup"
  title="Join thousands of users"
  lead="Create your free account today">
  {% block content %}
    {# Signup form here #}
  {% endblock %}
</twig:bs:hero>
```

### 5. Border Image
Image with border styling and shadow effects.

```twig
<twig:bs:hero 
  variant="border_image"
  title="Beautiful Design"
  lead="Pixel-perfect interfaces"
  imageSrc="/images/design.jpg"
  imageAlt="Design example" />
```

## Examples

```twig
{# Full-height hero #}
<twig:bs:hero 
  title="Welcome"
  :fullHeight="true"
  ctaLabel="Get Started"
  ctaHref="/start" />

{# Custom container #}
<twig:bs:hero 
  title="Wide Hero"
  container="container-fluid"
  lead="Full-width content" />

{# Hero with custom content #}
<twig:bs:hero title="Flexible Content">
  {% block content %}
    <p class="lead">Custom HTML content goes here</p>
    <div class="d-flex gap-2">
      <a href="/action1" class="btn btn-primary">Action 1</a>
      <a href="/action2" class="btn btn-outline-secondary">Action 2</a>
    </div>
  {% endblock %}
</twig:bs:hero>
```

## References

- [Bootstrap 5.3 Heroes Examples](https://getbootstrap.com/docs/5.3/examples/heroes/)
- [Bootstrap Layout Documentation](https://getbootstrap.com/docs/5.3/layout/grid/)
