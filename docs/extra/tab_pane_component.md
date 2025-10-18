# Tab Pane Component

## Overview

The `bs:tab-pane` component provides a reusable tab content pane that works seamlessly with Bootstrap's tab navigation. It's an Extra component designed for common UI patterns like settings pages, dashboards, product details, and multi-section forms.

**Component Type**: Extra  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Twig Tag**: `<twig:bs:tab-pane>`  
**Template**: `components/extra/tab-pane.html.twig`

## Basic Usage

### Simple Tab System

```twig
{# Tab navigation #}
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" 
            data-bs-target="#home" type="button" role="tab">Home</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" 
            data-bs-target="#profile" type="button" role="tab">Profile</button>
  </li>
</ul>

{# Tab content #}
<div class="tab-content">
  <twig:bs:tab-pane id="home" labelledBy="home-tab" :active="true">
    Home content goes here...
  </twig:bs:tab-pane>

  <twig:bs:tab-pane id="profile" labelledBy="profile-tab">
    Profile content goes here...
  </twig:bs:tab-pane>
</div>
```

### Auto-Generated IDs

The component can auto-generate IDs from the title:

```twig
<div class="tab-content">
  <twig:bs:tab-pane title="General Settings" :active="true">
    General settings form...
  </twig:bs:tab-pane>

  <twig:bs:tab-pane title="Security Settings">
    Security settings form...
  </twig:bs:tab-pane>
</div>
```

This generates IDs like `tab-general-settings` and `tab-security-settings`.

## Component Props

| Property | Type | Default | Description |
|---|---|---|---|
| `id` | `?string` | `null` | Unique ID for the pane. Auto-generated from `title` if not provided. |
| `labelledBy` | `?string` | `null` | ID of the tab button. Auto-generated as `{id}-tab` if not provided. |
| `active` | `bool` | `false` | Whether this pane is active/visible by default. |
| `fade` | `bool` | `true` | Enable fade transition when switching tabs. |
| `title` | `?string` | `null` | Title used for auto-generating IDs. |
| `class` | `string` | `''` | Additional CSS classes to apply. |
| `attr` | `array` | `[]` | Additional HTML attributes. |

## Examples

### 1. Settings Page

Perfect for multi-section settings forms:

```twig
<div class="container my-5">
  <h1>Account Settings</h1>
  
  {# Navigation #}
  <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" data-bs-toggle="tab" 
              data-bs-target="#tab-profile" type="button">
        Profile
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-security" type="button">
        Security
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-notifications" type="button">
        Notifications
      </button>
    </li>
  </ul>

  {# Tab Content #}
  <div class="tab-content">
    <twig:bs:tab-pane title="Profile" :active="true">
      <h3>Profile Settings</h3>
      <form>
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Security">
      <h3>Security Settings</h3>
      <form>
        <div class="mb-3">
          <label class="form-label">Current Password</label>
          <input type="password" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
      </form>
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Notifications">
      <h3>Notification Preferences</h3>
      <form>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="emailNotif">
          <label class="form-check-label" for="emailNotif">
            Email notifications
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Save Preferences</button>
      </form>
    </twig:bs:tab-pane>
  </div>
</div>
```

### 2. Dashboard with Pills Navigation

Using pills instead of tabs:

```twig
<div class="container-fluid">
  <h2>Dashboard</h2>
  
  {# Pills navigation #}
  <ul class="nav nav-pills mb-3" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" data-bs-toggle="tab" 
              data-bs-target="#tab-overview" type="button">
        <i class="bi bi-grid"></i> Overview
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-analytics" type="button">
        <i class="bi bi-graph-up"></i> Analytics
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-reports" type="button">
        <i class="bi bi-file-text"></i> Reports
      </button>
    </li>
  </ul>

  {# Dashboard content #}
  <div class="tab-content">
    <twig:bs:tab-pane title="Overview" :active="true">
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5>Total Users</h5>
              <p class="display-6">1,234</p>
            </div>
          </div>
        </div>
        {# More stats cards... #}
      </div>
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Analytics">
      <h3>Analytics Dashboard</h3>
      {# Charts and graphs here #}
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Reports">
      <h3>Reports</h3>
      {# Reports table here #}
    </twig:bs:tab-pane>
  </div>
</div>
```

### 3. Product Details

Great for organizing product information:

```twig
<div class="product-details">
  {# Product tabs #}
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" data-bs-toggle="tab" 
              data-bs-target="#tab-description" type="button">
        Description
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-specifications" type="button">
        Specifications
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-reviews" type="button">
        Reviews
      </button>
    </li>
  </ul>

  <div class="tab-content border border-top-0 p-3">
    <twig:bs:tab-pane title="Description" :active="true">
      <p>{{ product.description }}</p>
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Specifications">
      <table class="table">
        <tbody>
          {% for spec in product.specifications %}
            <tr>
              <th>{{ spec.name }}</th>
              <td>{{ spec.value }}</td>
            </tr>
          {% endfor %}
        </tbody>
      </table>
    </twig:bs:tab-pane>

    <twig:bs:tab-pane title="Reviews">
      {% for review in product.reviews %}
        <div class="mb-3">
          <strong>{{ review.author }}</strong>
          <div>{{ review.rating }} stars</div>
          <p>{{ review.comment }}</p>
        </div>
      {% endfor %}
    </twig:bs:tab-pane>
  </div>
</div>
```

### 4. Multi-Step Form

Ideal for wizard-style forms:

```twig
<div class="container">
  <h2>Registration Wizard</h2>
  
  {# Step indicators #}
  <ul class="nav nav-pills nav-justified mb-4" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" data-bs-toggle="tab" 
              data-bs-target="#tab-step1" type="button">
        1. Personal Info
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-step2" type="button">
        2. Account Setup
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" data-bs-toggle="tab" 
              data-bs-target="#tab-step3" type="button">
        3. Confirmation
      </button>
    </li>
  </ul>

  <form>
    <div class="tab-content">
      <twig:bs:tab-pane title="Step1" :active="true">
        <h3>Personal Information</h3>
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="firstName" />
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lastName" />
        </div>
        <button type="button" class="btn btn-primary" 
                data-bs-toggle="tab" data-bs-target="#tab-step2">
          Next Step →
        </button>
      </twig:bs:tab-pane>

      <twig:bs:tab-pane title="Step2">
        <h3>Account Setup</h3>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" />
        </div>
        <button type="button" class="btn btn-secondary me-2" 
                data-bs-toggle="tab" data-bs-target="#tab-step1">
          ← Previous
        </button>
        <button type="button" class="btn btn-primary" 
                data-bs-toggle="tab" data-bs-target="#tab-step3">
          Next Step →
        </button>
      </twig:bs:tab-pane>

      <twig:bs:tab-pane title="Step3">
        <h3>Confirmation</h3>
        <p>Please review your information and submit.</p>
        <button type="button" class="btn btn-secondary me-2" 
                data-bs-toggle="tab" data-bs-target="#tab-step2">
          ← Previous
        </button>
        <button type="submit" class="btn btn-success">
          Complete Registration
        </button>
      </twig:bs:tab-pane>
    </div>
  </form>
</div>
```

### 5. Without Fade Transition

Disable the fade effect:

```twig
<div class="tab-content">
  <twig:bs:tab-pane id="instant-1" :active="true" :fade="false">
    Instant transition (no fade)
  </twig:bs:tab-pane>

  <twig:bs:tab-pane id="instant-2" :fade="false">
    Another instant pane
  </twig:bs:tab-pane>
</div>
```

### 6. Custom Classes and Attributes

Add custom styling and data attributes:

```twig
<div class="tab-content">
  <twig:bs:tab-pane 
    id="custom-pane"
    :active="true"
    class="p-4 bg-light"
    :attr="{
      'data-controller': 'analytics',
      'data-analytics-id-value': 'home-tab'
    }">
    Custom styled content with Stimulus controller
  </twig:bs:tab-pane>
</div>
```

## Accessibility

The component follows Bootstrap's accessibility guidelines:

1. **ARIA Roles**: Automatically sets `role="tabpanel"`
2. **ARIA Labels**: Auto-generates `aria-labelledby` to link with tab buttons
3. **Keyboard Navigation**: Works with Bootstrap's tab JavaScript for keyboard support
4. **Screen Readers**: Proper semantic structure for screen reader navigation

### Best Practices

```twig
{# Good: Proper ARIA attributes #}
<button class="nav-link" id="home-tab" data-bs-toggle="tab" 
        data-bs-target="#home" role="tab" aria-controls="home">
  Home
</button>

<twig:bs:tab-pane id="home" labelledBy="home-tab" :active="true">
  Home content
</twig:bs:tab-pane>

{# Also Good: Auto-generated relationships #}
<button class="nav-link" data-bs-toggle="tab" 
        data-bs-target="#tab-profile" role="tab">
  Profile
</button>

<twig:bs:tab-pane title="Profile" :active="true">
  {# ID will be 'tab-profile', labelledBy will be 'tab-profile-tab' #}
</twig:bs:tab-pane>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  tab_pane:
    active: false               # Whether pane is active by default
    fade: true                  # Enable fade transition
    class: null                 # Additional classes
    attr: {}                    # Additional attributes
```

### Customizing Defaults

```yaml
neuralglitch_ux_bootstrap:
  tab_pane:
    fade: false                 # Disable fade globally
    class: 'p-4'                # Add padding to all panes
```

## Integration with Nav Component

Works seamlessly with the `bs:nav` component:

```twig
{# Using bs:nav for navigation #}
<twig:bs:nav variant="tabs">
  <twig:bs:nav-item 
    label="Home" 
    href="#tab-home" 
    :active="true"
    :attr="{'data-bs-toggle': 'tab'}" />
  <twig:bs:nav-item 
    label="Profile" 
    href="#tab-profile"
    :attr="{'data-bs-toggle': 'tab'}" />
</twig:bs:nav>

<div class="tab-content">
  <twig:bs:tab-pane title="Home" :active="true">
    Home content
  </twig:bs:tab-pane>
  <twig:bs:tab-pane title="Profile">
    Profile content
  </twig:bs:tab-pane>
</div>
```

## Testing

Run the test suite:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/TabPaneTest.php
```

Test coverage includes:
- Default options
- Active state with fade
- Active state without fade
- Custom IDs and labelledBy
- Auto-generated IDs from title
- Custom classes and attributes
- Config defaults

## Related Components

- **Nav** (`bs:nav`): Navigation component for tabs/pills
- **NavItem** (`bs:nav-item`): Individual navigation items
- **Collapse** (`bs:collapse`): Alternative accordion-style content organization
- **Accordion** (`bs:accordion`): Collapsible content panels

## Browser Compatibility

Works with all Bootstrap 5.3 supported browsers:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## References

- [Bootstrap Tabs Documentation](https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs)
- [Bootstrap JavaScript Behavior](https://getbootstrap.com/docs/5.3/components/navs-tabs/#javascript-behavior)
- [ARIA Authoring Practices for Tabs](https://www.w3.org/WAI/ARIA/apg/patterns/tabs/)

