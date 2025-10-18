# FAQ Component

## Overview

The `bs:faq` component provides styled Question & Answer sections with multiple layout variants. It's an Extra component built on top of Bootstrap 5.3 that makes it easy to create beautiful, accessible FAQ pages.

## Basic Usage

```twig
<twig:bs:faq
    variant="accordion"
    title="Frequently Asked Questions"
    lead="Find answers to common questions"
    :items="[
        {
            question: 'What is this component?',
            answer: 'This is a FAQ component for styled Q&A sections.'
        },
        {
            question: 'How do I use it?',
            answer: 'Simply pass an array of questions and answers to the items prop.'
        }
    ]"
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'accordion'` | Layout variant: `'accordion'` \| `'simple'` \| `'card'` \| `'bordered'` |
| `items` | `array` | `[]` | Array of Q&A items (see structure below) |
| `title` | `?string` | `null` | Optional heading for the FAQ section |
| `lead` | `?string` | `null` | Optional lead text below the title |
| `accordionId` | `?string` | auto-generated | Custom ID for accordion (auto-generated if not provided) |
| `flush` | `bool` | `false` | Remove borders (accordion variant only) |
| `alwaysOpen` | `bool` | `false` | Allow multiple items to be open (accordion variant only) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### Items Array Structure

Each item in the `items` array should have the following structure:

```php
[
    'question' => 'Question text',  // Required
    'answer' => 'Answer text',      // Required (can contain HTML)
    'id' => 'custom-id',            // Optional (auto-generated if not provided)
]
```

## Layout Variants

### 1. Accordion (Default)

Collapsible Q&A using Bootstrap accordion. Only one item is open at a time by default.

```twig
<twig:bs:faq
    variant="accordion"
    :items="faqItems"
/>
```

**With flush style (no borders):**

```twig
<twig:bs:faq
    variant="accordion"
    :flush="true"
    :items="faqItems"
/>
```

**Allow multiple items open:**

```twig
<twig:bs:faq
    variant="accordion"
    :alwaysOpen="true"
    :items="faqItems"
/>
```

### 2. Simple

Simple list layout without collapse functionality.

```twig
<twig:bs:faq
    variant="simple"
    :items="faqItems"
/>
```

### 3. Card

Each Q&A in a Bootstrap card with header and body.

```twig
<twig:bs:faq
    variant="card"
    :items="faqItems"
/>
```

### 4. Bordered

List group items with borders.

```twig
<twig:bs:faq
    variant="bordered"
    :items="faqItems"
/>
```

## Examples

### Complete FAQ Section

```twig
<twig:bs:faq
    variant="accordion"
    title="Frequently Asked Questions"
    lead="Can't find what you're looking for? Contact our support team."
    :flush="true"
    :items="[
        {
            question: 'How do I get started?',
            answer: '<p>Getting started is easy! Simply <a href=\"/signup\">create an account</a> and follow the setup wizard.</p>'
        },
        {
            question: 'What payment methods do you accept?',
            answer: '<p>We accept all major credit cards, PayPal, and bank transfers.</p>'
        },
        {
            question: 'Can I cancel my subscription?',
            answer: '<p>Yes, you can cancel anytime from your account settings. No questions asked.</p>'
        },
        {
            question: 'Do you offer refunds?',
            answer: '<p>We offer a 30-day money-back guarantee on all plans.</p>'
        }
    ]"
    class="mb-5"
/>
```

### Simple FAQ List

```twig
<twig:bs:faq
    variant="simple"
    title="Quick Answers"
    :items="[
        {
            question: 'What are your business hours?',
            answer: 'Monday to Friday, 9 AM - 6 PM EST'
        },
        {
            question: 'Where are you located?',
            answer: 'Our headquarters are in San Francisco, CA'
        }
    ]"
/>
```

### Card-Based FAQ

```twig
<twig:bs:faq
    variant="card"
    title="Product FAQ"
    lead="Everything you need to know about our product"
    :items="productFaqItems"
    class="mt-4"
/>
```

### Custom Content

You can also provide custom content using the content block:

```twig
<twig:bs:faq variant="accordion" :flush="true">
    {% block content %}
        <div class="accordion" id="customFaq">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#custom1">
                        Custom Question
                    </button>
                </h3>
                <div id="custom1" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        Custom answer with full control over the markup.
                    </div>
                </div>
            </div>
        </div>
    {% endblock %}
</twig:bs:faq>
```

## Controller Example

```php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SupportController extends AbstractController
{
    public function faq(): Response
    {
        $faqItems = [
            [
                'question' => 'How do I reset my password?',
                'answer' => '<p>Click on "Forgot Password" on the login page and follow the instructions.</p>',
            ],
            [
                'question' => 'How can I contact support?',
                'answer' => '<p>You can reach us at <a href="mailto:support@example.com">support@example.com</a> or use our live chat.</p>',
            ],
            [
                'question' => 'What is your SLA?',
                'answer' => '<p>We guarantee 99.9% uptime. Check our <a href="/sla">SLA page</a> for details.</p>',
            ],
        ];

        return $this->render('support/faq.html.twig', [
            'faqItems' => $faqItems,
        ]);
    }
}
```

```twig
{# templates/support/faq.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}FAQ - Support{% endblock %}

{% block body %}
    <div class="container my-5">
        <twig:bs:faq
            variant="accordion"
            title="Frequently Asked Questions"
            lead="Find answers to common questions about our service"
            :items="faqItems"
            :flush="true"
        />
    </div>
{% endblock %}
```

## Accessibility

The FAQ component follows accessibility best practices:

- **Accordion variant**: Uses proper ARIA attributes (`aria-expanded`, `aria-controls`)
- **Semantic HTML**: Uses appropriate heading levels (`h3`, `h4`, `h5`)
- **Keyboard navigation**: Full keyboard support for accordion variant
- **Screen readers**: Properly announced questions and answers

### Accessibility Tips

1. **Use appropriate heading levels**: If used in a section with `h2`, the FAQ title should be `h2` and questions `h3`
2. **Provide descriptive questions**: Make questions clear and specific
3. **Keep answers concise**: Break long answers into paragraphs
4. **Use links wisely**: Ensure linked text is descriptive

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  faq:
    variant: 'accordion'        # Default variant
    title: null                 # Default title
    lead: null                  # Default lead text
    flush: false                # Default flush style
    always_open: false          # Default always open behavior
    class: null                 # Default CSS classes
    attr: {}                    # Default HTML attributes
```

## Testing

The FAQ component includes comprehensive tests covering all variants, options, and edge cases:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/FaqTest.php
```

## Styling

### Custom Styles

You can add custom styles for FAQ variants:

```scss
// Custom FAQ styles
.faq-simple {
  h4 {
    color: var(--bs-primary);
    font-weight: 600;
  }
}

// Custom spacing for card variant
.bs-faq-card {
  .card {
    transition: box-shadow 0.2s;
    
    &:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
  }
}
```

### Dark Mode Support

The component automatically adapts to Bootstrap's dark mode:

```html
<html data-bs-theme="dark">
  <!-- FAQ component will use dark mode styles -->
</html>
```

## Related Components

- **Accordion**: For more complex collapsible content
- **Card**: For individual Q&A cards
- **List Group**: For simple lists

## References

- [Bootstrap Accordion](https://getbootstrap.com/docs/5.3/components/accordion/)
- [Bootstrap Cards](https://getbootstrap.com/docs/5.3/components/card/)
- [Bootstrap List Group](https://getbootstrap.com/docs/5.3/components/list-group/)
- [WAI-ARIA Accordion Pattern](https://www.w3.org/WAI/ARIA/apg/patterns/accordion/)

