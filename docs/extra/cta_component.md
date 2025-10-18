# CTA (Call-to-Action) Component

## Overview

The CTA (Call-to-Action) component is a flexible Extra component designed for marketing pages and conversion-focused sections. It provides multiple layout variants to showcase compelling calls-to-action with primary and secondary buttons, titles, descriptions, and optional icons.

**Component Name:** `bs:cta`  
**Namespace:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra`

## Basic Usage

```twig
{# Simple centered CTA #}
<twig:bs:cta
    title="Ready to get started?"
    description="Join thousands of satisfied customers today"
    ctaLabel="Sign Up Now"
    ctaHref="/register"
    secondaryCtaLabel="Learn More"
    secondaryCtaHref="/about"
/>
```

## Component Props

### Core Properties

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'centered'` | Layout variant: `'centered'`, `'split'`, `'bordered'`, `'background'`, `'minimal'` |
| `title` | `string` | `'Ready to get started?'` | Main heading text |
| `description` | `string\|null` | `null` | Description/subheading text |
| `icon` | `string\|null` | `null` | Icon HTML (emoji, SVG, or icon class) |

### Call-to-Action (Primary Button)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `ctaLabel` | `string\|null` | `null` | Primary button text |
| `ctaHref` | `string\|null` | `null` | Primary button URL |
| `ctaVariant` | `string` | `'primary'` | Bootstrap button variant |
| `ctaSize` | `string` | `'lg'` | Button size: `'sm'`, `'lg'`, or default |
| `ctaOutline` | `bool` | `false` | Use outline button style |

### Secondary Call-to-Action

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `secondaryCtaLabel` | `string\|null` | `null` | Secondary button text |
| `secondaryCtaHref` | `string\|null` | `null` | Secondary button URL |
| `secondaryCtaVariant` | `string` | `'outline-secondary'` | Bootstrap button variant |
| `secondaryCtaSize` | `string` | `'lg'` | Button size |
| `secondaryCtaOutline` | `bool` | `false` | Use outline button style |

### Layout & Styling

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `alignment` | `string` | `'center'` | Content alignment: `'start'`, `'center'`, `'end'` |
| `container` | `string` | `'container'` | Container class |
| `bg` | `string\|null` | `null` | Background variant: `'primary'`, `'secondary'`, `'light'`, `'dark'`, `'body-tertiary'`, etc. |
| `textColor` | `string\|null` | `null` | Text color variant |
| `border` | `bool` | `false` | Add border |
| `shadow` | `bool` | `false` | Add shadow |
| `rounded` | `bool` | `true` | Add rounded corners |
| `padding` | `string` | `'py-5'` | Padding class |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Variants

### Centered (Default)

Centered content with icon, title, description, and buttons.

```twig
<twig:bs:cta
    variant="centered"
    icon="🚀"
    title="Launch Your Project Today"
    description="Get started in minutes with our easy-to-use platform"
    ctaLabel="Start Free Trial"
    ctaHref="/trial"
    secondaryCtaLabel="View Demo"
    secondaryCtaHref="/demo"
/>
```

### Split

Content on the left, buttons on the right (responsive).

```twig
<twig:bs:cta
    variant="split"
    title="Ready to transform your business?"
    description="Join over 10,000 companies already using our platform"
    ctaLabel="Get Started"
    ctaHref="/signup"
    secondaryCtaLabel="Contact Sales"
    secondaryCtaHref="/contact"
/>
```

### Bordered

Content within a bordered box.

```twig
<twig:bs:cta
    variant="bordered"
    title="Special Offer"
    description="Sign up today and get 20% off your first month"
    ctaLabel="Claim Offer"
    ctaHref="/offer"
    border="true"
/>
```

### Background

Full-width background with padding (great with bg colors).

```twig
<twig:bs:cta
    variant="background"
    bg="primary"
    textColor="white"
    title="Transform Your Workflow"
    description="Streamline your processes and boost productivity"
    ctaLabel="Start Now"
    ctaHref="/start"
    ctaVariant="light"
/>
```

### Minimal

Compact CTA with smaller text and minimal spacing.

```twig
<twig:bs:cta
    variant="minimal"
    title="Want to learn more?"
    ctaLabel="Read Documentation"
    ctaHref="/docs"
    padding="py-3"
/>
```

## Examples

### Basic CTA

```twig
<twig:bs:cta
    title="Ready to get started?"
    ctaLabel="Sign Up"
    ctaHref="/register"
/>
```

### With Icon and Description

```twig
<twig:bs:cta
    icon="💡"
    title="Got an idea?"
    description="Share your thoughts with our community"
    ctaLabel="Submit Idea"
    ctaHref="/ideas"
/>
```

### Split Layout with Primary Background

```twig
<twig:bs:cta
    variant="split"
    bg="primary"
    textColor="white"
    title="Enterprise Solutions"
    description="Scale your business with our enterprise-grade platform"
    ctaLabel="Contact Sales"
    ctaHref="/sales"
    ctaVariant="light"
    secondaryCtaLabel="View Pricing"
    secondaryCtaHref="/pricing"
    secondaryCtaVariant="outline-light"
/>
```

### Bordered with Shadow

```twig
<twig:bs:cta
    variant="bordered"
    border="true"
    shadow="true"
    rounded="true"
    title="Limited Time Offer"
    description="Get 50% off annual plans"
    ctaLabel="Upgrade Now"
    ctaHref="/upgrade"
    ctaVariant="success"
/>
```

### Newsletter Signup

```twig
<twig:bs:cta
    variant="background"
    bg="body-tertiary"
    title="Stay in the loop"
    description="Subscribe to our newsletter for updates and tips"
    ctaLabel="Subscribe"
    ctaHref="/subscribe"
    alignment="center"
/>
```

### Footer CTA

```twig
<twig:bs:cta
    variant="minimal"
    title="Questions? We're here to help"
    ctaLabel="Contact Support"
    ctaHref="/support"
    ctaSize="md"
    alignment="center"
    padding="py-4"
/>
```

### Custom Content with Slot

```twig
<twig:bs:cta variant="centered" bg="primary" textColor="white">
    <div class="text-center">
        <h1 class="display-4 fw-bold mb-3">🎉 Black Friday Sale!</h1>
        <p class="lead mb-4">Up to 70% off on all plans</p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="/sale" class="btn btn-light btn-lg">Shop Now</a>
            <a href="/details" class="btn btn-outline-light btn-lg">Learn More</a>
        </div>
        <small class="d-block mt-3">Offer ends in 48 hours</small>
    </div>
</twig:bs:cta>
```

### Alignment Variations

```twig
{# Left aligned #}
<twig:bs:cta
    variant="split"
    alignment="start"
    title="Developer Tools"
    ctaLabel="View API Docs"
    ctaHref="/api"
/>

{# Right aligned #}
<twig:bs:cta
    variant="minimal"
    alignment="end"
    title="Need help?"
    ctaLabel="Get Support"
    ctaHref="/help"
/>
```

### Dark Theme CTA

```twig
<twig:bs:cta
    variant="background"
    bg="dark"
    textColor="white"
    icon="⭐"
    title="Premium Features Await"
    description="Unlock advanced capabilities and priority support"
    ctaLabel="Go Premium"
    ctaHref="/premium"
    ctaVariant="warning"
    secondaryCtaLabel="Compare Plans"
    secondaryCtaHref="/plans"
    secondaryCtaVariant="outline-light"
/>
```

## Accessibility

- **Semantic HTML**: Uses `<section>` as the main container
- **Heading Hierarchy**: Ensure the CTA heading level fits your page structure
- **Button Labels**: Use clear, action-oriented text for `ctaLabel`
- **Color Contrast**: When using custom backgrounds, ensure text is readable
- **Focus States**: Bootstrap button styles include proper focus indicators

### Recommendations

1. Use descriptive button labels (avoid generic "Click Here")
2. Ensure sufficient color contrast (especially with custom `bg` and `textColor`)
3. Keep titles concise and action-oriented
4. Use `description` to provide additional context
5. Test keyboard navigation (Tab through buttons)

## Configuration

Configure global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  cta:
    variant: 'centered'
    title: 'Ready to get started?'
    description: null
    icon: null
    
    cta_variant: 'primary'
    cta_size: 'lg'
    cta_outline: false
    
    secondary_cta_variant: 'outline-secondary'
    secondary_cta_size: 'lg'
    secondary_cta_outline: false
    
    alignment: 'center'
    container: 'container'
    bg: null
    text_color: null
    border: false
    shadow: false
    rounded: true
    padding: 'py-5'
    
    class: null
    attr: {}
```

## Testing

The CTA component includes comprehensive tests covering:
- All layout variants
- CTA button configurations
- Styling options (background, border, shadow, rounded)
- Alignment options
- Custom classes and attributes
- Config defaults

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/CtaTest.php
```

## Related Components

- **Hero** (`bs:hero`) - Full hero sections with multiple layouts
- **Empty State** (`bs:empty-state`) - Empty state with CTAs
- **Card** (`bs:card`) - Card components for content blocks
- **Button** (`bs:button`) - Individual button component
- **Button Group** (`bs:button-group`) - Grouped buttons

## Use Cases

1. **Landing Pages**: Primary conversion points
2. **Marketing Pages**: Product features, pricing
3. **Blog Posts**: Newsletter signups, related content
4. **Documentation**: Next steps, support links
5. **Error Pages**: Recovery actions
6. **Checkout Flow**: Upsells, cross-sells
7. **Dashboard**: Upgrade prompts, onboarding
8. **Footer**: Contact, support, newsletter

## Best Practices

### DO:
- ✅ Use action-oriented button text ("Start Free Trial" vs "Click Here")
- ✅ Keep titles short and compelling
- ✅ Use icons sparingly for visual interest
- ✅ Match CTA variant to page context (minimal for subtle, background for prominent)
- ✅ Ensure visual hierarchy (primary CTA more prominent than secondary)
- ✅ Test different variants to optimize conversions
- ✅ Use appropriate container width for content

### DON'T:
- ❌ Overuse CTAs (1-2 per viewport recommended)
- ❌ Use vague button text
- ❌ Make CTAs too visually busy
- ❌ Forget to test mobile responsiveness
- ❌ Use too many buttons (2 max recommended)
- ❌ Ignore color contrast requirements

## References

- [Bootstrap 5.3 Buttons](https://getbootstrap.com/docs/5.3/components/buttons/)
- [Bootstrap 5.3 Utilities](https://getbootstrap.com/docs/5.3/utilities/api/)
- [Call-to-Action Best Practices](https://www.nngroup.com/articles/call-to-action-buttons/)

