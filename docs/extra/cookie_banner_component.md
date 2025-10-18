# Cookie Banner Component

## Overview

The Cookie Banner component (`bs:cookie-banner`) is a compliance-focused component for displaying cookie consent banners on public websites. It provides a fully customizable banner with accept, reject, and customize buttons, along with localStorage/cookie persistence to remember user preferences.

**Key Features:**
- GDPR/CCPA compliance support
- Multiple positioning options (top/bottom, fixed/relative)
- Customizable buttons and text
- Privacy and cookie policy links
- LocalStorage and cookie persistence
- Backdrop overlay option
- Stimulus controller for behavior
- Customizable button variants
- Auto-hide after consent

## Basic Usage

```twig
{# Simple cookie banner #}
<twig:bs:cookie-banner />

{# Fixed position at bottom with custom text #}
<twig:bs:cookie-banner
    position="bottom-fixed"
    title="Cookie Notice"
    message="We use cookies to improve your experience."
/>

{# With privacy links #}
<twig:bs:cookie-banner
    privacyUrl="/privacy"
    cookiePolicyUrl="/cookies"
/>

{# With all three buttons #}
<twig:bs:cookie-banner
    :showReject="true"
    :showCustomize="true"
/>

{# With backdrop #}
<twig:bs:cookie-banner
    :backdrop="true"
    variant="dark"
/>
```

## Component Props

### Position & Layout

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | `string` | `'bottom'` | Banner position: `'top'`, `'bottom'`, `'top-fixed'`, `'bottom-fixed'` |
| `variant` | `string` | `'light'` | Bootstrap background variant |
| `shadow` | `string` | `'shadow-lg'` | Shadow class for the banner |

### Content

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string` | `'We use cookies'` | Banner title text |
| `message` | `string` | `'We use cookies to ensure...'` | Main message text |
| `privacyUrl` | `string\|null` | `null` | URL to privacy policy page |
| `privacyLinkText` | `string` | `'Privacy Policy'` | Text for privacy policy link |
| `cookiePolicyUrl` | `string\|null` | `null` | URL to cookie policy page |
| `cookiePolicyLinkText` | `string` | `'Cookie Policy'` | Text for cookie policy link |

### Buttons

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `acceptText` | `string` | `'Accept'` | Accept button text |
| `rejectText` | `string` | `'Reject'` | Reject button text |
| `customizeText` | `string` | `'Customize'` | Customize button text |
| `showReject` | `bool` | `true` | Show reject button |
| `showCustomize` | `bool` | `false` | Show customize button |
| `acceptVariant` | `string` | `'primary'` | Accept button Bootstrap variant |
| `rejectVariant` | `string` | `'secondary'` | Reject button Bootstrap variant |
| `customizeVariant` | `string` | `'outline-secondary'` | Customize button Bootstrap variant |

### Storage

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `cookieName` | `string` | `'cookie_consent'` | Name for storing consent |
| `expiryDays` | `int` | `365` | Cookie expiration in days |

### Behavior

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `dismissible` | `bool` | `false` | Show close button (dismiss without choosing) |
| `backdrop` | `bool` | `false` | Show backdrop overlay behind banner |

### Extensibility

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

See [Cookie Banner Examples](examples/cookie_banner_example.html.twig) for comprehensive examples including:
- Bottom banner (default)
- Top fixed banner
- Banner with backdrop
- Dark variant
- Custom buttons
- Privacy links
- All button options

## Accessibility

The Cookie Banner component follows accessibility best practices:

- **Keyboard Navigation**: All buttons are fully keyboard accessible
- **Focus Management**: Proper focus indicators on interactive elements
- **Screen Readers**: Semantic HTML with appropriate text
- **Color Contrast**: Sufficient contrast for text and buttons
- **Non-intrusive**: Does not block content when not fixed
- **Persistent**: Remembers user choice across sessions

### ARIA Considerations

```twig
<twig:bs:cookie-banner
    :attr="{
        'role': 'dialog',
        'aria-label': 'Cookie Consent Banner',
        'aria-live': 'polite'
    }"
/>
```

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  cookie_banner:
    # Position
    position: 'bottom-fixed'
    
    # Content
    title: 'We value your privacy'
    message: 'We use cookies to enhance your experience.'
    privacy_url: '/privacy'
    privacy_link_text: 'Privacy Policy'
    cookie_policy_url: '/cookies'
    cookie_policy_link_text: 'Cookie Policy'
    
    # Buttons
    accept_text: 'Accept All'
    reject_text: 'Decline'
    customize_text: 'Settings'
    show_reject: true
    show_customize: true
    
    # Button variants
    accept_variant: 'primary'
    reject_variant: 'secondary'
    customize_variant: 'outline-secondary'
    
    # Storage
    cookie_name: 'cookie_consent'
    expiry_days: 365
    
    # Behavior
    dismissible: false
    backdrop: false
    
    # Styling
    variant: 'light'
    shadow: 'shadow-lg'
    
    # Extensibility
    class: null
    attr: {}
```

## Stimulus Controller

The component uses the `bs-cookie-banner` Stimulus controller for behavior:

### Values

- `cookieName` (String): Name for consent storage
- `expiryDays` (Number): Cookie expiration in days
- `backdrop` (Boolean): Show backdrop overlay

### Actions

- `accept`: User accepts cookies
- `reject`: User rejects cookies
- `customize`: User wants to customize (dispatches event)
- `dismiss`: User dismisses banner without choosing

### Events

The controller dispatches custom events you can listen to:

```javascript
// Listen for consent events
document.addEventListener('bs-cookie-banner:accepted', (event) => {
    console.log('User accepted cookies');
    // Initialize analytics, tracking, etc.
});

document.addEventListener('bs-cookie-banner:rejected', (event) => {
    console.log('User rejected cookies');
    // Disable analytics, tracking, etc.
});

document.addEventListener('bs-cookie-banner:customize', (event) => {
    console.log('User wants to customize');
    // Open your custom preferences modal
});

document.addEventListener('bs-cookie-banner:dismissed', (event) => {
    console.log('User dismissed banner');
});
```

### Storage

The controller stores consent in both localStorage and cookies:

- **localStorage**: `cookie_consent` (or custom name)
- **Cookie**: Same name, with expiry set to `expiryDays`
- **Values**: `'accepted'` or `'rejected'`

The banner automatically hides if consent is already stored.

## Usage Patterns

### GDPR Compliance

```twig
<twig:bs:cookie-banner
    position="bottom-fixed"
    title="Cookie Consent"
    message="We use cookies to comply with GDPR regulations. You can accept or reject non-essential cookies."
    privacyUrl="/privacy"
    cookiePolicyUrl="/cookies"
    :showReject="true"
    :showCustomize="true"
    acceptText="Accept All"
    rejectText="Reject All"
    customizeText="Cookie Settings"
/>
```

### Simple Notice

```twig
<twig:bs:cookie-banner
    title="Notice"
    message="This website uses cookies to ensure you get the best experience."
    :showReject="false"
    acceptText="OK"
/>
```

### Custom Integration

```twig
{# In your template #}
<twig:bs:cookie-banner
    cookieName="my_site_consent"
    :expiryDays="90"
/>

{# In your JavaScript #}
<script>
document.addEventListener('bs-cookie-banner:accepted', (event) => {
    // Enable Google Analytics
    gtag('consent', 'update', {
        'analytics_storage': 'granted'
    });
});

document.addEventListener('bs-cookie-banner:rejected', (event) => {
    // Disable Google Analytics
    gtag('consent', 'update', {
        'analytics_storage': 'denied'
    });
});

document.addEventListener('bs-cookie-banner:customize', (event) => {
    // Open your custom preferences modal
    const modal = new bootstrap.Modal('#cookiePreferencesModal');
    modal.show();
});
</script>
```

## Testing

The component includes comprehensive tests covering:
- All position variants
- Custom text and messages
- Button visibility options
- Button variants
- Privacy/cookie policy links
- Storage configuration
- Backdrop behavior
- Dismissible mode
- Custom classes and attributes
- Config defaults

Run tests:
```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/CookieBannerTest.php
```

## Styling

The component generates the following CSS classes:

```css
/* Base classes */
.cookie-banner { /* Banner container */ }
.cookie-banner-top { /* Top positioning */ }
.cookie-banner-bottom { /* Bottom positioning */ }
.cookie-banner-backdrop { /* Backdrop overlay */ }
.cookie-banner-content { /* Content wrapper */ }

/* Position variants automatically applied */
.position-relative { /* Relative positioning */ }
.position-fixed { /* Fixed positioning */ }
.top-0, .bottom-0 { /* Positioning utilities */ }
.start-0, .end-0 { /* Full width */ }
```

Add custom styles in your CSS:

```css
.cookie-banner {
    /* Custom styling */
    border-top: 2px solid var(--bs-primary);
}

.cookie-banner.bg-dark {
    border-color: var(--bs-light);
}

.cookie-banner-backdrop {
    /* Custom backdrop */
    backdrop-filter: blur(2px);
}
```

## Related Components

- [Alert](../bootstrap/alert_component.md) - For dismissible alerts
- [Modal](../bootstrap/modal_component.md) - For detailed cookie preferences
- [Toast](../bootstrap/toast_component.md) - For notifications

## Best Practices

1. **Be Transparent**: Clearly explain what cookies you use
2. **Easy to Understand**: Use simple, non-technical language
3. **Prominent Placement**: Fixed positioning ensures visibility
4. **Respect Choices**: Honor user preferences immediately
5. **Link to Policies**: Always provide privacy and cookie policy links
6. **Accessible**: Ensure keyboard navigation and screen reader support
7. **Test Consent Flow**: Verify events fire correctly
8. **Comply with Laws**: Follow GDPR, CCPA, and local regulations

## Legal Considerations

This component provides the UI for cookie consent but does not:
- Automatically block cookies/tracking
- Provide legal compliance guarantee
- Include cookie policy content
- Manage granular cookie categories

**You must**:
- Implement cookie blocking based on user choice
- Provide actual privacy and cookie policy documents
- Comply with applicable laws (GDPR, CCPA, etc.)
- Consider consulting legal counsel for compliance

## References

- [GDPR Cookie Consent](https://gdpr.eu/cookies/)
- [CCPA Overview](https://oag.ca.gov/privacy/ccpa)
- [Bootstrap Alert](https://getbootstrap.com/docs/5.3/components/alerts/)
- [Cookie Consent Best Practices](https://www.cookieyes.com/cookie-consent-banner-examples/)

