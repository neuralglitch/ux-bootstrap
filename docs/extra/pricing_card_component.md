# Pricing Card Component

## Overview

The **Pricing Card** (`bs:pricing-card`) component is an Extra component designed for displaying subscription plans, pricing tiers, and product offerings on landing pages and pricing pages. It provides a polished, conversion-focused design with flexible customization options.

**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag**: `<twig:bs:pricing-card />`  
**Template**: `templates/components/extra/pricing-card.html.twig`

## Use Cases

- 💰 **Landing Pages**: Showcase pricing tiers for SaaS products
- 📊 **Subscription Management**: Display plan options and upgrades
- 🎯 **Plan Comparisons**: Present features and pricing side-by-side
- 🛒 **E-commerce**: Show product pricing and packages
- 🎁 **Promotional Offers**: Highlight special deals or featured plans

## Basic Usage

### Simple Pricing Card

```twig
<twig:bs:pricing-card
    planName="Free"
    price="0"
    currency="$"
    period="month"
    ctaLabel="Get Started"
    ctaHref="/signup"
/>
```

### With Features

```twig
<twig:bs:pricing-card
    planName="Pro"
    price="29"
    :features="[
        'Unlimited projects',
        '100 GB storage',
        'Priority email support',
        'Advanced analytics',
        'Custom domain'
    ]"
    ctaLabel="Start Free Trial"
    ctaHref="/trial"
    ctaVariant="primary"
/>
```

### Featured Plan

```twig
<twig:bs:pricing-card
    planName="Enterprise"
    badge="Most Popular"
    badgeVariant="success"
    price="99"
    planDescription="Perfect for large teams and organizations"
    :features="[
        'Unlimited everything',
        'Unlimited storage',
        '24/7 phone & email support',
        'Advanced security',
        'Dedicated account manager',
        'Custom integrations'
    ]"
    :featured="true"
    :shadow="true"
    ctaLabel="Contact Sales"
    ctaHref="/contact"
/>
```

## Component Props

### Plan Details

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `planName` | `string` | `'Free'` | Name of the pricing plan |
| `planDescription` | `?string` | `null` | Optional description below plan name |

### Pricing

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `price` | `string` | `'0'` | Price amount (string to support decimals) |
| `currency` | `string` | `'$'` | Currency symbol (e.g., '$', '€', '£') |
| `period` | `string` | `'month'` | Billing period (e.g., 'month', 'year', 'week') |
| `showPeriod` | `bool` | `true` | Whether to show the billing period |

### Badge

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `badge` | `?string` | `null` | Optional badge text (e.g., "Popular", "Best Value") |
| `badgeVariant` | `?string` | `'primary'` | Bootstrap variant for badge |

### Features

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `features` | `array<string>` | `[]` | Array of feature strings |
| `showCheckmarks` | `bool` | `true` | Show checkmark icons before features |

### Call-to-Action

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `ctaLabel` | `string` | `'Get Started'` | Button text |
| `ctaHref` | `?string` | `null` | Button URL (if null, renders as button) |
| `ctaVariant` | `string` | `'primary'` | Bootstrap button variant |
| `ctaSize` | `string` | `'lg'` | Button size ('sm', 'lg', or null) |
| `ctaOutline` | `bool` | `false` | Use outline button style |
| `ctaBlock` | `bool` | `true` | Full-width button |

### Styling

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `featured` | `bool` | `false` | Highlight as featured plan (thicker border) |
| `shadow` | `bool` | `false` | Add shadow effect |
| `variant` | `?string` | `null` | Bootstrap color variant for card background |
| `border` | `bool` | `true` | Show card border |
| `textAlign` | `?string` | `'center'` | Text alignment ('start', 'center', 'end') |

### Common Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Complete Pricing Page

```twig
<div class="container py-5">
    <h1 class="text-center mb-5">Choose Your Plan</h1>
    
    <div class="row g-4">
        {# Free Plan #}
        <div class="col-12 col-md-6 col-lg-4">
            <twig:bs:pricing-card
                planName="Free"
                price="0"
                planDescription="Perfect for getting started"
                :features="[
                    '5 projects',
                    '1 GB storage',
                    'Community support',
                    'Basic analytics'
                ]"
                ctaLabel="Get Started"
                ctaHref="/signup"
                ctaVariant="outline-primary"
            />
        </div>
        
        {# Pro Plan - Featured #}
        <div class="col-12 col-md-6 col-lg-4">
            <twig:bs:pricing-card
                planName="Pro"
                badge="Most Popular"
                badgeVariant="success"
                price="29"
                planDescription="Best for professionals"
                :features="[
                    'Unlimited projects',
                    '100 GB storage',
                    'Priority email support',
                    'Advanced analytics',
                    'Custom domain',
                    'API access'
                ]"
                :featured="true"
                :shadow="true"
                ctaLabel="Start Free Trial"
                ctaHref="/trial"
            />
        </div>
        
        {# Enterprise Plan #}
        <div class="col-12 col-md-6 col-lg-4">
            <twig:bs:pricing-card
                planName="Enterprise"
                price="Custom"
                :showPeriod="false"
                planDescription="For large organizations"
                :features="[
                    'Everything in Pro',
                    'Unlimited storage',
                    '24/7 phone support',
                    'Dedicated account manager',
                    'Custom integrations',
                    'SLA guarantee'
                ]"
                ctaLabel="Contact Sales"
                ctaHref="/contact"
                ctaVariant="secondary"
            />
        </div>
    </div>
</div>
```

### Annual vs Monthly Toggle

```twig
{% set isAnnual = true %}

<div class="container py-5">
    <div class="text-center mb-4">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary">Monthly</button>
            <button type="button" class="btn btn-primary">Yearly (Save 20%)</button>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6">
            <twig:bs:pricing-card
                planName="Pro"
                price="{{ isAnnual ? '23' : '29' }}"
                period="{{ isAnnual ? 'month (billed yearly)' : 'month' }}"
                :features="[
                    'All features included',
                    'Priority support'
                ]"
            />
        </div>
        
        <div class="col-md-6">
            <twig:bs:pricing-card
                planName="Enterprise"
                price="{{ isAnnual ? '79' : '99' }}"
                period="{{ isAnnual ? 'month (billed yearly)' : 'month' }}"
                :featured="true"
            />
        </div>
    </div>
</div>
```

### Custom Features with Twig Block

```twig
<twig:bs:pricing-card
    planName="Custom"
    price="Contact us"
    :showPeriod="false"
>
    {% block features %}
        <ul class="list-unstyled mt-3 mb-4">
            <li class="mb-2">
                <i class="bi bi-star-fill text-warning me-2"></i>
                Custom feature 1
            </li>
            <li class="mb-2">
                <i class="bi bi-star-fill text-warning me-2"></i>
                Custom feature 2
            </li>
            <li class="mb-2">
                <i class="bi bi-lightning-fill text-primary me-2"></i>
                Priority access
            </li>
        </ul>
    {% endblock %}
</twig:bs:pricing-card>
```

### Different Currencies

```twig
{# Euro pricing #}
<twig:bs:pricing-card
    planName="Pro"
    price="25"
    currency="€"
/>

{# British Pound #}
<twig:bs:pricing-card
    planName="Pro"
    price="22"
    currency="£"
/>

{# Yen #}
<twig:bs:pricing-card
    planName="Pro"
    price="3,200"
    currency="¥"
/>
```

### Dark Variant

```twig
<twig:bs:pricing-card
    planName="Premium"
    price="49"
    variant="dark"
    :features="[
        'All Pro features',
        'White-glove onboarding',
        'Dedicated support'
    ]"
    badgeVariant="light"
/>
```

### No Features, Just CTA

```twig
<twig:bs:pricing-card
    planName="Free Trial"
    price="0"
    period="14 days"
    planDescription="Try all features risk-free"
    :features="[]"
    ctaLabel="Start Your Trial"
    ctaHref="/trial"
    ctaSize="lg"
/>
```

### Left-Aligned Text

```twig
<twig:bs:pricing-card
    planName="Business"
    price="79"
    textAlign="start"
    :features="[
        'Team collaboration',
        'Advanced reporting',
        'Custom branding'
    ]"
/>
```

## Accessibility

The Pricing Card component follows accessibility best practices:

- **Semantic HTML**: Uses appropriate heading tags and list elements
- **Button Accessibility**: CTA buttons have proper focus states
- **ARIA Labels**: Screen readers can navigate feature lists
- **Contrast**: Text colors meet WCAG AA standards
- **Keyboard Navigation**: All interactive elements are keyboard accessible

### Screen Reader Considerations

The pricing information is structured so screen readers announce:
1. Badge (if present)
2. Plan name
3. Price with currency and period
4. Plan description (if present)
5. Features list
6. Call-to-action button

## Configuration

You can set global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  pricing_card:
    plan_name: 'Free'
    plan_description: null
    price: '0'
    currency: '$'
    period: 'month'
    show_period: true
    badge: null
    badge_variant: 'primary'
    features: []
    show_checkmarks: true
    cta_label: 'Get Started'
    cta_href: null
    cta_variant: 'primary'
    cta_size: 'lg'
    cta_outline: false
    cta_block: true
    featured: false
    shadow: false
    variant: null
    border: true
    text_align: 'center'
    class: null
    attr: {  }
```

## Testing

Run the component tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/PricingCardTest.php
```

The component includes comprehensive tests covering:
- Default options
- All prop variations
- Featured and shadow styling
- Custom classes and attributes
- Button configurations
- Config defaults
- Edge cases

## Best Practices

### DO:
- ✅ Keep feature lists concise (5-8 items ideal)
- ✅ Use clear, benefit-focused language
- ✅ Highlight the recommended plan with `featured` prop
- ✅ Use consistent pricing periods across all cards
- ✅ Include a clear call-to-action for each plan
- ✅ Consider mobile layout (stack cards vertically)
- ✅ Use badges to draw attention to special offers

### DON'T:
- ❌ Overload cards with too many features
- ❌ Use technical jargon in feature descriptions
- ❌ Mix different pricing periods without clear labels
- ❌ Forget to test on mobile devices
- ❌ Use too many featured cards (typically just one)
- ❌ Make prices hard to read (use clear typography)

## Design Patterns

### Three-Tier Pricing

The classic "Good, Better, Best" pattern:

```twig
<div class="row g-4">
    <div class="col-lg-4">
        <twig:bs:pricing-card
            planName="Starter"
            price="9"
            ctaVariant="outline-primary"
        />
    </div>
    <div class="col-lg-4">
        <twig:bs:pricing-card
            planName="Pro"
            badge="Popular"
            :featured="true"
        />
    </div>
    <div class="col-lg-4">
        <twig:bs:pricing-card
            planName="Enterprise"
            ctaVariant="secondary"
        />
    </div>
</div>
```

### Freemium Model

Start with free, upsell to paid:

```twig
<twig:bs:pricing-card
    planName="Free Forever"
    price="0"
    planDescription="No credit card required"
    ctaLabel="Start Free"
/>
```

### Contact Us Pricing

For enterprise or custom pricing:

```twig
<twig:bs:pricing-card
    planName="Enterprise"
    price="Custom"
    :showPeriod="false"
    planDescription="Tailored to your needs"
    ctaLabel="Contact Sales"
    ctaHref="/contact"
/>
```

## Related Components

- **Card** (`bs:card`) - General purpose card component
- **Badge** (`bs:badge`) - For plan badges and labels
- **Button** (`bs:button`) - For call-to-action buttons
- **ListGroup** (`bs:list-group`) - Alternative feature list style
- **Hero** (`bs:hero`) - For pricing page hero sections

## Browser Support

The Pricing Card component works in all modern browsers:
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## References

- [Bootstrap 5.3 Cards](https://getbootstrap.com/docs/5.3/components/card/)
- [Bootstrap 5.3 Badges](https://getbootstrap.com/docs/5.3/components/badge/)
- [Pricing Page Best Practices](https://www.nngroup.com/articles/pricing-plans/)
- [SaaS Pricing Strategies](https://www.priceintelligently.com/blog/saas-pricing-strategies)

## Changelog

See component changelog at: [CHANGELOG.md](../CHANGELOG.md)

## License

This component is part of the NeuralGlitch UX Bootstrap Bundle and is licensed under the MIT License.

