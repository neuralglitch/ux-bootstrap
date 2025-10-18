# Stepper Component

## Overview

The Stepper component displays progress through a multi-step process, commonly used for checkout flows, onboarding, registration wizards, and survey forms. It provides clear visual indicators for completed, active, and pending steps with optional interactivity.

**Component:** `bs:stepper` (Extra Component)  
**Location:** `src/Twig/Components/Extra/Stepper.php`  
**Template:** `templates/components/extra/stepper.html.twig`

## Basic Usage

### Simple Horizontal Stepper

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Account Info'},
        {label: 'Shipping Address'},
        {label: 'Payment'},
        {label: 'Confirmation'}
    ]"
    :currentStep="2"
/>
```

### Vertical Layout

```twig
<twig:bs:stepper
    variant="vertical"
    :steps="[
        {label: 'Personal Details', description: 'Enter your basic information'},
        {label: 'Contact Info', description: 'How can we reach you?'},
        {label: 'Verification', description: 'Confirm your identity'}
    ]"
    :currentStep="2"
    :showDescriptions="true"
/>
```

### With Progress Bar

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Start'},
        {label: 'Setup'},
        {label: 'Configure'},
        {label: 'Complete'}
    ]"
    :currentStep="3"
    :showProgressBar="true"
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `steps` | `array` | `[]` | Array of step definitions (see Step Definition) |
| `currentStep` | `int` | `1` | The currently active step number (1-based) |
| `variant` | `string` | `'horizontal'` | Layout orientation: `'horizontal'` \| `'vertical'` |
| `style` | `string` | `'default'` | Visual style: `'default'` \| `'progress'` \| `'minimal'` \| `'numbered'` \| `'icon'` |
| `clickableCompleted` | `bool` | `true` | Allow clicking on completed steps to navigate back |
| `showLabels` | `bool` | `true` | Show step labels |
| `showDescriptions` | `bool` | `false` | Show step descriptions |
| `showProgressBar` | `bool` | `false` | Show progress bar above steps |
| `completedIcon` | `?string` | `null` | Icon/HTML for completed steps (e.g., `'✓'`) |
| `activeIcon` | `?string` | `null` | Icon/HTML for active step |
| `pendingIcon` | `?string` | `null` | Icon/HTML for pending steps |
| `completedVariant` | `?string` | `'success'` | Bootstrap variant for completed steps |
| `activeVariant` | `?string` | `'primary'` | Bootstrap variant for active step |
| `pendingVariant` | `?string` | `'secondary'` | Bootstrap variant for pending steps |
| `size` | `string` | `'default'` | Size: `'sm'` \| `'default'` \| `'lg'` |
| `responsive` | `bool` | `true` | Auto-switch to vertical layout on mobile |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### Step Definition

Each step in the `steps` array can have the following properties:

```php
[
    'label' => 'Step Name',           // Required: Step label text
    'description' => 'More details',  // Optional: Additional description
    'icon' => '<i class="..."></i>',  // Optional: Custom icon HTML
    'clickable' => true,              // Optional: Override clickable behavior
    'href' => '/step-url',            // Optional: URL for navigation
]
```

## Examples

### Checkout Flow

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Shopping Cart', href: '/cart'},
        {label: 'Shipping Info', href: '/shipping'},
        {label: 'Payment', href: '/payment'},
        {label: 'Review Order', href: '/review'}
    ]"
    :currentStep="3"
    :showProgressBar="true"
    completedIcon="✓"
    activeVariant="primary"
/>
```

### Onboarding Wizard

```twig
<twig:bs:stepper
    variant="vertical"
    :steps="[
        {
            label: 'Welcome',
            description: 'Get started with your new account',
            icon: '<i class=\"bi bi-house\"></i>'
        },
        {
            label: 'Profile Setup',
            description: 'Tell us about yourself',
            icon: '<i class=\"bi bi-person\"></i>'
        },
        {
            label: 'Preferences',
            description: 'Customize your experience',
            icon: '<i class=\"bi bi-gear\"></i>'
        },
        {
            label: 'Complete',
            description: 'You\'re all set!',
            icon: '<i class=\"bi bi-check-circle\"></i>'
        }
    ]"
    :currentStep="2"
    :showDescriptions="true"
    style="icon"
/>
```

### Registration Wizard

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Account', description: 'Create your account'},
        {label: 'Profile', description: 'Add profile details'},
        {label: 'Verify', description: 'Confirm your email'},
        {label: 'Done', description: 'Start using the app'}
    ]"
    :currentStep="2"
    :showDescriptions="true"
    :showProgressBar="true"
    size="lg"
/>
```

### Survey Form

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Introduction'},
        {label: 'Demographics'},
        {label: 'Preferences'},
        {label: 'Feedback'},
        {label: 'Summary'}
    ]"
    :currentStep="3"
    style="minimal"
    :clickableCompleted="false"
/>
```

### Minimal Style

```twig
<twig:bs:stepper
    style="minimal"
    :steps="[
        {label: 'Select Plan'},
        {label: 'Add Details'},
        {label: 'Confirm'}
    ]"
    :currentStep="2"
    completedVariant="success"
    activeVariant="primary"
/>
```

### Small Size (Compact)

```twig
<twig:bs:stepper
    size="sm"
    :steps="[
        {label: 'Step 1'},
        {label: 'Step 2'},
        {label: 'Step 3'}
    ]"
    :currentStep="2"
/>
```

### Large Size (Prominent)

```twig
<twig:bs:stepper
    size="lg"
    :steps="[
        {label: 'Begin', icon: '🚀'},
        {label: 'Process', icon: '⚙️'},
        {label: 'Finish', icon: '🎉'}
    ]"
    :currentStep="2"
    :showDescriptions="true"
/>
```

### With Custom Icons

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Sign Up', icon: '<i class=\"bi bi-person-plus\"></i>'},
        {label: 'Verify Email', icon: '<i class=\"bi bi-envelope-check\"></i>'},
        {label: 'Complete Profile', icon: '<i class=\"bi bi-card-checklist\"></i>'}
    ]"
    :currentStep="2"
    style="icon"
    completedIcon="<i class=\"bi bi-check-circle-fill\"></i>"
/>
```

### Non-Clickable Steps

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Step 1'},
        {label: 'Step 2'},
        {label: 'Step 3'}
    ]"
    :currentStep="2"
    :clickableCompleted="false"
/>
```

### Dynamic Steps (Symfony Controller)

```php
// In your controller
$steps = [
    ['label' => 'Order Details', 'href' => $this->generateUrl('checkout_details')],
    ['label' => 'Shipping', 'href' => $this->generateUrl('checkout_shipping')],
    ['label' => 'Payment', 'href' => $this->generateUrl('checkout_payment')],
    ['label' => 'Confirmation', 'href' => $this->generateUrl('checkout_confirm')],
];

return $this->render('checkout/index.html.twig', [
    'steps' => $steps,
    'currentStep' => 2,
]);
```

```twig
{# In your template #}
<twig:bs:stepper
    :steps="steps"
    :currentStep="currentStep"
    :showProgressBar="true"
/>
```

## Variants

### Layout Variants

- **`horizontal`** (default): Steps arranged horizontally in a row
- **`vertical`**: Steps arranged vertically in a column

### Style Variants

- **`default`**: Standard stepper with numbered badges
- **`progress`**: Emphasizes progress with thicker connecting lines
- **`minimal`**: Minimal design with outlined badges
- **`numbered`**: Clear numbered indicators
- **`icon`**: Uses custom icons for each step

## Step States

The component automatically determines step states based on `currentStep`:

- **Completed**: Steps before the current step (number < currentStep)
- **Active**: The current step (number === currentStep)
- **Pending**: Steps after the current step (number > currentStep)

Each state can have its own:
- Visual style (color variant)
- Icon (optional)
- Clickability (for completed steps)

## Accessibility

The component includes several accessibility features:

- Semantic HTML structure
- `aria-current="step"` for the active step
- Keyboard navigation support for clickable steps
- Screen reader-friendly labels
- Focus indicators for interactive elements

### Best Practices

```twig
{# Provide descriptive labels #}
<twig:bs:stepper
    :steps="[
        {label: 'Personal Information', description: 'Enter your name and contact details'},
        {label: 'Shipping Address', description: 'Where should we deliver?'},
        {label: 'Payment Method', description: 'Choose how to pay'}
    ]"
    :currentStep="1"
    :showDescriptions="true"
/>

{# Use meaningful hrefs for navigation #}
<twig:bs:stepper
    :steps="[
        {label: 'Step 1', href: url('wizard_step1')},
        {label: 'Step 2', href: url('wizard_step2')},
        {label: 'Step 3', href: url('wizard_step3')}
    ]"
    :currentStep="2"
/>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  stepper:
    variant: 'horizontal'
    style: 'default'
    current_step: 1
    clickable_completed: true
    show_labels: true
    show_descriptions: false
    show_progress_bar: false
    completed_icon: null
    active_icon: null
    pending_icon: null
    completed_variant: 'success'
    active_variant: 'primary'
    pending_variant: 'secondary'
    size: 'default'
    responsive: true
    class: null
    attr: {}
```

### Override Globally

```yaml
# config/packages/ux_bootstrap.yaml
neuralglitch_ux_bootstrap:
  stepper:
    completed_icon: '✓'
    show_progress_bar: true
    size: 'lg'
```

## Responsive Behavior

When `responsive` is enabled (default), the stepper automatically adapts to mobile screens:

- Horizontal steppers switch to vertical layout on small screens
- Touch-friendly spacing and sizing
- Optimized for portrait orientation

To disable responsive behavior:

```twig
<twig:bs:stepper
    :steps="steps"
    :currentStep="2"
    :responsive="false"
/>
```

## Use Cases

### 1. E-commerce Checkout

```twig
<twig:bs:stepper
    :steps="[
        {label: 'Cart', href: '/cart'},
        {label: 'Shipping', href: '/shipping'},
        {label: 'Payment', href: '/payment'},
        {label: 'Confirmation', href: '/confirm'}
    ]"
    :currentStep="checkoutStep"
    :showProgressBar="true"
    completedIcon="✓"
/>
```

### 2. User Onboarding

```twig
<twig:bs:stepper
    variant="vertical"
    :steps="onboardingSteps"
    :currentStep="currentOnboardingStep"
    :showDescriptions="true"
    style="icon"
/>
```

### 3. Multi-Page Forms

```twig
<twig:bs:stepper
    :steps="formSteps"
    :currentStep="currentFormPage"
    :clickableCompleted="true"
    size="sm"
/>
```

### 4. Survey/Quiz

```twig
<twig:bs:stepper
    :steps="surveyPages"
    :currentStep="currentPage"
    :clickableCompleted="false"
    style="minimal"
/>
```

## Testing

Comprehensive tests are available in `tests/Twig/Components/Extra/StepperTest.php`:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/StepperTest.php
```

### Test Coverage

- Default options and configuration
- All layout variants (horizontal, vertical)
- All style variants (default, progress, minimal, etc.)
- Step states (completed, active, pending)
- Clickable completed steps
- Progress calculation
- Custom icons and variants
- Responsive behavior
- Size variants (sm, default, lg)
- Custom classes and attributes

## Related Components

- **Timeline**: For displaying chronological events
- **Progress**: For simple progress indication
- **Nav**: For tabbed navigation
- **Breadcrumbs**: For hierarchical navigation

## References

- [Bootstrap Progress Documentation](https://getbootstrap.com/docs/5.3/components/progress/)
- [Bootstrap Badges Documentation](https://getbootstrap.com/docs/5.3/components/badge/)
- [ARIA: step role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/step_role)
- [Multi-Step Form UX Best Practices](https://www.nngroup.com/articles/wizard-forms/)

