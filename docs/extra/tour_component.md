# Tour Component

## Overview

The **Tour** component provides guided product tours and feature highlights for SaaS applications, documentation sites, and complex interfaces. It creates step-by-step walkthroughs with element highlighting, tooltips, navigation controls, and progress tracking.

**Component**: `bs:tour`  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Stimulus Controller**: `bs-tour`  
**Template**: `templates/components/extra/tour.html.twig`

## When to Use

- **Onboarding**: Guide new users through your application
- **Feature Announcements**: Highlight new features
- **Training**: Teach complex workflows
- **Documentation**: Interactive documentation and demos
- **Walkthroughs**: Step-by-step instructions

## Basic Usage

### Simple Tour

```twig
<twig:bs:tour
    tourId="welcome-tour"
    :steps="[
        {
            'target': '#dashboard',
            'title': 'Welcome to Dashboard',
            'content': 'This is your main dashboard where you can see all your data.',
            'placement': 'bottom'
        },
        {
            'target': '#sidebar',
            'title': 'Navigation',
            'content': 'Use this sidebar to navigate between different sections.',
            'placement': 'right'
        },
        {
            'target': '#profile',
            'title': 'Your Profile',
            'content': 'Click here to manage your profile settings.',
            'placement': 'bottom'
        }
    ]"
    :autoStart="true"
/>

{# Trigger button to start tour manually #}
<button onclick="document.querySelector('[data-controller=bs-tour]').__stimulusControllers.get('bs-tour').start()">
    Start Tour
</button>
```

### Centered Steps (No Target)

```twig
<twig:bs:tour
    tourId="intro-tour"
    :steps="[
        {
            'target': null,
            'title': 'Welcome!',
            'content': 'Let\'s take a quick tour of the main features.'
        },
        {
            'target': '#feature1',
            'title': 'Feature 1',
            'content': 'This is an amazing feature...'
        }
    ]"
/>
```

## Component Props

### Tour Identification

| Property | Type | Default | Description |
|---|---|---|---|
| `tourId` | `?string` | `'tour-{uniqid}'` | Unique identifier for the tour (used for persistence) |

### Steps Configuration

| Property | Type | Default | Description |
|---|---|---|---|
| `steps` | `array` | `[]` | Array of step definitions (see Step Structure below) |

### Behavior Options

| Property | Type | Default | Description |
|---|---|---|---|
| `showProgress` | `bool` | `true` | Show progress bar |
| `showStepNumbers` | `bool` | `true` | Show step numbers (e.g., "Step 1 of 5") |
| `keyboard` | `bool` | `true` | Enable keyboard navigation |
| `backdrop` | `bool` | `true` | Show backdrop overlay |
| `highlight` | `bool` | `true` | Highlight target elements |
| `scrollToElement` | `bool` | `true` | Auto-scroll to target elements |
| `autoStart` | `bool` | `false` | Start tour automatically on mount |

### Navigation Options

| Property | Type | Default | Description |
|---|---|---|---|
| `showPrevButton` | `bool` | `true` | Show "Previous" button |
| `showNextButton` | `bool` | `true` | Show "Next" button |
| `showSkipButton` | `bool` | `true` | Show "Skip Tour" button |
| `showFinishButton` | `bool` | `true` | Show "Finish" button on last step |
| `allowClickThrough` | `bool` | `false` | Allow clicking through backdrop |

### Button Labels

| Property | Type | Default | Description |
|---|---|---|---|
| `nextLabel` | `string` | `'Next'` | Label for next button |
| `prevLabel` | `string` | `'Previous'` | Label for previous button |
| `skipLabel` | `string` | `'Skip Tour'` | Label for skip button |
| `finishLabel` | `string` | `'Finish'` | Label for finish button |
| `closeLabel` | `string` | `'Close'` | Aria-label for close button |

### Styling Options

| Property | Type | Default | Description |
|---|---|---|---|
| `popoverVariant` | `string` | `'light'` | Popover variant: `'light'` or `'dark'` |
| `popoverPlacement` | `string` | `'auto'` | Default placement: `'auto'`, `'top'`, `'right'`, `'bottom'`, `'left'` |
| `popoverWidth` | `int` | `360` | Popover width in pixels |
| `highlightPadding` | `int` | `10` | Padding around highlighted element (px) |
| `highlightBorderRadius` | `int` | `8` | Border radius of highlight (px) |

### Callbacks

| Property | Type | Default | Description |
|---|---|---|---|
| `onStart` | `?string` | `null` | JavaScript function name to call when tour starts |
| `onComplete` | `?string` | `null` | JavaScript function name to call when tour completes |
| `onSkip` | `?string` | `null` | JavaScript function name to call when tour is skipped |
| `onStepShow` | `?string` | `null` | JavaScript function name to call when each step is shown |

### Standard Props

| Property | Type | Default | Description |
|---|---|---|---|
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Step Structure

Each step in the `steps` array should have the following structure:

```php
[
    'target' => '#element-selector',  // CSS selector (null for centered step)
    'title' => 'Step Title',          // Step title
    'content' => 'Step content...',   // Step content
    'placement' => 'bottom',          // Optional: 'auto', 'top', 'right', 'bottom', 'left'
    'contentHtml' => false,           // Optional: Allow HTML in content
]
```

## Examples

### Complete Onboarding Tour

```twig
<twig:bs:tour
    tourId="onboarding-tour"
    :steps="[
        {
            'target': null,
            'title': 'Welcome to MyApp!',
            'content': 'Let us show you around. This tour will only take 2 minutes.'
        },
        {
            'target': '#dashboard',
            'title': 'Your Dashboard',
            'content': 'Here you can see an overview of all your activities and statistics.',
            'placement': 'bottom'
        },
        {
            'target': '#projects',
            'title': 'Projects',
            'content': 'Manage all your projects from here. Click to create a new project.',
            'placement': 'right'
        },
        {
            'target': '#team',
            'title': 'Team Collaboration',
            'content': 'Invite team members and collaborate in real-time.',
            'placement': 'left'
        },
        {
            'target': '#settings',
            'title': 'Settings',
            'content': 'Customize your experience and manage account settings here.',
            'placement': 'bottom'
        },
        {
            'target': null,
            'title': 'You\'re All Set!',
            'content': 'That\'s it! You\'re ready to start using MyApp. Happy working!'
        }
    ]"
    :autoStart="true"
    onComplete="handleOnboardingComplete"
/>
```

### Dark Theme Tour

```twig
<twig:bs:tour
    tourId="dark-tour"
    popoverVariant="dark"
    :backdrop="false"
    :steps="tourSteps"
    nextLabel="Continue"
    finishLabel="Got It"
/>
```

### Minimal Tour (No Progress, No Skip)

```twig
<twig:bs:tour
    tourId="quick-tour"
    :showProgress="false"
    :showStepNumbers="false"
    :showSkipButton="false"
    :steps="[
        {
            'target': '#important-feature',
            'title': 'New Feature',
            'content': 'Check out this new feature we just launched!',
            'placement': 'bottom'
        }
    ]"
/>
```

### Feature Announcement with Custom Styling

```twig
<twig:bs:tour
    tourId="feature-announcement"
    :popoverWidth="400"
    :highlightPadding="15"
    :highlightBorderRadius="12"
    :steps="[
        {
            'target': '#new-button',
            'title': '🎉 New Feature',
            'content': '<strong>We\'ve added a new export feature!</strong><br><br>Click here to export your data in multiple formats.',
            'placement': 'right',
            'contentHtml': true
        }
    ]"
    :autoStart="true"
/>
```

### Manual Tour Control

```twig
<twig:bs:tour
    tourId="manual-tour"
    :autoStart="false"
    :steps="tourSteps"
/>

<button 
    type="button" 
    class="btn btn-primary"
    data-action="click->bs-tour#start">
    Start Tour
</button>

<button 
    type="button" 
    class="btn btn-secondary"
    data-action="click->bs-tour#end">
    End Tour
</button>
```

### With Callbacks

```twig
<twig:bs:tour
    tourId="callback-tour"
    :steps="tourSteps"
    onStart="handleTourStart"
    onComplete="handleTourComplete"
    onSkip="handleTourSkip"
    onStepShow="handleStepShow"
/>

<script>
    function handleTourStart(data) {
        console.log('Tour started:', data.tourId);
        // Track analytics
    }

    function handleTourComplete(data) {
        console.log('Tour completed:', data.tourId);
        // Save completion status to backend
        fetch('/api/tour/complete', {
            method: 'POST',
            body: JSON.stringify({ tourId: data.tourId })
        });
    }

    function handleTourSkip(data) {
        console.log('Tour skipped:', data.tourId);
        // Track skip event
    }

    function handleStepShow(data) {
        console.log('Step shown:', data.step, data.index);
        // Custom logic per step
    }
</script>
```

### Localized Tour

```twig
<twig:bs:tour
    tourId="localized-tour"
    :steps="tourSteps"
    nextLabel="{{ 'tour.next'|trans }}"
    prevLabel="{{ 'tour.previous'|trans }}"
    skipLabel="{{ 'tour.skip'|trans }}"
    finishLabel="{{ 'tour.finish'|trans }}"
    closeLabel="{{ 'tour.close'|trans }}"
/>
```

## JavaScript API

Access the tour controller programmatically:

```javascript
// Get tour controller
const tourElement = document.querySelector('[data-controller="bs-tour"]');
const tourController = tourElement.__stimulusControllers.get('bs-tour');

// Start tour
tourController.start();

// Navigate
tourController.next();
tourController.previous();

// End tour
tourController.skip();
tourController.finish();
tourController.close();
tourController.end();
```

## Keyboard Navigation

When `keyboard` is enabled (default):

- **Escape**: Close tour
- **Arrow Right / Arrow Down**: Next step
- **Arrow Left / Arrow Up**: Previous step

## Persistence

The tour automatically tracks completion status in `localStorage` using the `tourId`:

```javascript
// Check if tour was completed
const completed = localStorage.getItem('tour-welcome-tour') === 'completed';

// Clear completion status (to show tour again)
localStorage.removeItem('tour-welcome-tour');
```

## Styling

### Custom Popover Styles

```css
.tour-popover {
    /* Customize popover appearance */
}

.tour-popover-dark {
    /* Dark variant styles */
}

.tour-step-content {
    /* Customize content area */
}

.tour-progress .progress-bar {
    /* Customize progress bar */
    background-color: #your-color;
}
```

### Custom Backdrop

```css
.tour-backdrop {
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
}
```

### Custom Highlight

```css
.tour-highlight {
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);
    border: 2px solid var(--bs-primary);
}
```

## Accessibility

- Uses `role="dialog"` and `aria-modal="true"` for popover
- Keyboard navigation support
- Focus management
- Close button with `aria-label`
- Screen reader friendly step numbers

### Best Practices

1. **Keep steps short**: 3-5 sentences max per step
2. **Use clear titles**: Descriptive and concise
3. **Logical order**: Follow natural user flow
4. **Don't overuse**: Only for complex features
5. **Allow skipping**: Users may not need the tour
6. **Track completion**: Remember if user completed tour
7. **Test thoroughly**: Ensure elements exist and are visible

## Configuration

Global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  tour:
    show_progress: true
    show_step_numbers: true
    keyboard: true
    backdrop: true
    highlight: true
    scroll_to_element: true
    auto_start: false
    show_prev_button: true
    show_next_button: true
    show_skip_button: true
    show_finish_button: true
    allow_click_through: false
    next_label: 'Next'
    prev_label: 'Previous'
    skip_label: 'Skip Tour'
    finish_label: 'Finish'
    close_label: 'Close'
    popover_variant: 'light'
    popover_placement: 'auto'
    popover_width: 360
    highlight_padding: 10
    highlight_border_radius: 8
    class: null
    attr: {}
```

## Testing

Run component tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/TourTest.php
```

## Related Components

- [Hero](hero_component.md) - Hero sections with CTAs
- [CommandPalette](command_palette_component.md) - Quick action palette
- [Modal](modal_component.md) - Modal dialogs

## References

- [Bootstrap Popovers](https://getbootstrap.com/docs/5.3/components/popovers/)
- [Intro.js](https://introjs.com/) - Tour inspiration
- [Shepherd.js](https://shepherdjs.dev/) - Tour library reference
- [Product Tours Best Practices](https://www.appcues.com/blog/product-tour-best-practices)

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Requires JavaScript enabled
- Uses Popper.js for positioning

## Performance

- Lazy initialization
- Efficient DOM queries
- Smooth animations with CSS transitions
- Minimal memory footprint
- Cleanup on disconnect

## Troubleshooting

### Tour doesn't start

```javascript
// Check if tour was already completed
localStorage.removeItem('tour-your-tour-id');

// Or set autoStart
<twig:bs:tour :autoStart="true" ... />
```

### Element not found

```javascript
// Ensure target elements exist in DOM
const element = document.querySelector('#your-target');
if (!element) {
    console.error('Target element not found');
}
```

### Popover positioning issues

```javascript
// Use different placement
'placement': 'auto'  // Let Popper.js choose best position
```

### Backdrop not showing

```twig
{# Ensure backdrop is enabled #}
<twig:bs:tour :backdrop="true" ... />
```

