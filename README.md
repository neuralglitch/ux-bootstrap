<div align="center">

# UX Bootstrap

### Reusable Bootstrap 5.3 Twig Components for Symfony

[![Tests](https://github.com/neuralglitch/ux-bootstrap/workflows/Tests/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/tests.yml)
[![Static Analysis](https://github.com/neuralglitch/ux-bootstrap/workflows/Static%20Analysis/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/static-analysis.yml)
[![Build](https://github.com/neuralglitch/ux-bootstrap/workflows/Build/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/build.yml)

[![php](https://img.shields.io/badge/PHP-8.1+-4F5B93.svg?style=flat-square)](https://www.php.net/)
[![symfony](https://img.shields.io/badge/Symfony-6.4%20%7C%207.x-1F2937.svg?style=flat-square)](https://www.symfony.com/)
[![bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952b3.svg?style=flat-square)](https://getbootstrap.com/)
[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

A production-ready collection of Bootstrap 5.3 Twig Components and Stimulus controllers for Symfony applications. Transform your Bootstrap HTML into clean, reusable Twig components.

[Documentation](#-documentation) • [Installation](#-installation) • [Quick Start](#-quick-start)

</div>

---

## ✨ Features

- ** Complete Bootstrap Components** - Full coverage of Bootstrap 5.3 components, including Accordion, Alert, Badge, Breadcrumbs, Button, Card, Carousel, Dropdown, Modal, Nav, Navbar, Toast, and many more - organized alphabetically for easy reference
- ** Advanced UI Components** - Extended components for modern applications including Activity Feed, Alert Stack, Calendar, Command Palette, Data Table, Kanban, Lightbox, Notification Center, Search Bar, Sidebar, Theme Toggle, Timeline, Tour, Tree View, and more
- ** Powerful Stimulus Controllers** - Interactive behaviors for tooltips, popovers, theme switching, live search, drag-and-drop, notifications, and more
- ** Works with Your Bootstrap** - Integrates seamlessly with existing Bootstrap 5.3 installations
- **️ Highly Configurable** - YAML-based defaults for every component
- ** Simple Installation** - Nearly zero-config: `composer require neuralglitch/ux-bootstrap`
- ** Production Ready** - Type-safe, tested, documented

---

## 📋 Requirements

- **PHP 8.1+**
- **Symfony 6.4 LTS or 7.x**
- **Bootstrap 5.3.x** - Must be already installed in your project
- **Stimulus** (optional) - For interactive components

---

## 🚀 Installation

### Prerequisites

**Bootstrap 5.3 must be installed in your project first.**

If you don't have Bootstrap yet:

```bash
# Using Asset Mapper
php bin/console importmap:require bootstrap
php bin/console importmap:require @popperjs/core
```

### Configure Custom Recipe Repository

This bundle uses custom Symfony Flex recipes hosted in a separate repository. To enable automatic configuration during installation, add the custom recipe endpoint to your project's `composer.json`:

```json
{
    "extra": {
        "symfony": {
            "endpoint": [
                "https://api.github.com/repos/neuralglitch/symfony-recipes/contents/index.json",
                "flex://defaults"
            ]
        }
    }
}
```

**Important:** 
- Add this **before** running `composer require neuralglitch/ux-bootstrap`
- The `flex://defaults` entry ensures Symfony's official recipes are still available
- This enables automatic installation of bundle configuration, templates, and assets

If you've already installed the bundle without this configuration, you can:
1. Add the endpoint configuration to `composer.json`
2. Remove and reinstall the bundle: `composer remove neuralglitch/ux-bootstrap && composer require neuralglitch/ux-bootstrap`

### Install the Bundle

```bash
composer require neuralglitch/ux-bootstrap
```

### Enable the Bundle (if not using Flex)

```php
// config/bundles.php
return [
    // ...
    NeuralGlitch\UxBootstrap\NeuralGlitchUxBootstrapBundle::class => ['all' => true],
];
```

### Install Stimulus (Optional)

For interactive features (tooltips, popovers, auto-hide alerts):

```bash
php bin/console importmap:require @hotwired/stimulus
```

### Enable Theme Support

**Option 1: Automatic Installation (Recommended)**

Run the installation command to automatically patch your base template:

```bash
php bin/console ux-bootstrap:install
```

This will add theme support to `templates/base.html.twig` automatically.

**Option 2: Manual Installation**

Add theme detection to your base template (`templates/base.html.twig`):

**Before:**
```twig
<html lang="en">
```

**After:**
```twig
<html lang="en" {{ ux_bootstrap_html_attrs() }}>
```

This adds `data-bs-theme` and `color-scheme` attributes for automatic light/dark mode support. The `ux_bootstrap_html_attrs()` function works with any existing HTML tag attributes.

**That's it!** Start using components immediately.

---

## 🎯 Quick Start

### Basic Components

```twig
{# Badge #}
<twig:bs:badge variant="success">New Feature</twig:bs:badge>

{# Button with Icon #}
<twig:bs:button variant="primary" iconStart="bi:arrow-right">
    Get Started
</twig:bs:button>

{# Link with Tooltip #}
<twig:bs:link 
    href="/docs" 
    variant="primary"
    :tooltip="{text: 'View documentation', placement: 'top'}">
    Documentation
</twig:bs:link>

{# Dismissible Alert #}
<twig:bs:alert variant="warning" :dismissible="true">
    This is a warning message!
</twig:bs:alert>
```

### Advanced Components

```twig
{# Accordion #}
<twig:bs:accordion>
    <twig:bs:accordion-item 
        title="Accordion Item #1" 
        :show="true"
        :parentId="'accordionExample'">
        <strong>This is the first item's accordion body.</strong> 
        It is shown by default.
    </twig:bs:accordion-item>
    <twig:bs:accordion-item 
        title="Accordion Item #2"
        :parentId="'accordionExample'">
        <strong>This is the second item's accordion body.</strong>
        It is hidden by default.
    </twig:bs:accordion-item>
</twig:bs:accordion>

{# Accordion (Flush variant) #}
<twig:bs:accordion :flush="true" id="accordionFlush">
    <twig:bs:accordion-item 
        title="Item #1" 
        :parentId="'accordionFlush'">
        Flush accordion content.
    </twig:bs:accordion-item>
</twig:bs:accordion>

{# Card with Blocks #}
<twig:bs:card>
    <twig:block name="header">
        <h5 class="mb-0">Card Title</h5>
    </twig:block>
    <twig:block name="body">
        <p>Card content goes here...</p>
        <twig:bs:button variant="primary">Action</twig:bs:button>
    </twig:block>
</twig:bs:card>

{# Nav with Tabs #}
<twig:bs:nav variant="tabs">
    <twig:bs:nav-item href="#home" :active="true">Home</twig:bs:nav-item>
    <twig:bs:nav-item href="#profile">Profile</twig:bs:nav-item>
    <twig:bs:nav-item href="#messages">Messages</twig:bs:nav-item>
</twig:bs:nav>

{# Navbar #}
<twig:bs:navbar 
    brand="My App" 
    :bg="'body-tertiary'" 
    :borderBottom="true">
    <twig:block name="nav">
        <twig:bs:link href="/" class="nav-link">Home</twig:bs:link>
        <twig:bs:link href="/about" class="nav-link">About</twig:bs:link>
    </twig:block>
</twig:bs:navbar>

{# Hero Section #}
<twig:bs:hero 
    title="Welcome to Our Site"
    lead="Build something amazing with Bootstrap and Symfony">
    <twig:block name="cta">
        <twig:bs:button variant="primary" size="lg" href="/get-started">
            Get Started
        </twig:bs:button>
    </twig:block>
</twig:bs:hero>
```

---

## 🧩 Components

### Bootstrap Core Components

Complete Twig component coverage of Bootstrap 5.3.

### Extra Components

Advanced UI components built on Bootstrap.

### Stimulus Controllers

Interactive behavior powered by Stimulus.

---

## 🎨 Component Styles

The bundle provides SCSS partials for component enhancements. These are automatically available via AssetMapper.

### Using Component Styles (Optional)

If you want to use the bundle's component styles, import them in your SCSS:

```scss
// assets/styles/app.scss

// Import Bootstrap first
@import "~bootstrap/scss/bootstrap";

// Import UX Bootstrap component styles
@import "~@neuralglitch/ux-bootstrap/styles/app";
```

Or import individual components:

```scss
// Import only what you need
@import "~@neuralglitch/ux-bootstrap/styles/navbar";
@import "~@neuralglitch/ux-bootstrap/styles/search";
```

### What's Included

The SCSS partials provide enhancements for:
- **SearchBar** - Styled search input with results dropdown
- **Navbar** - Multiple collapse types, behaviors (sticky, auto-hide, fullscreen, etc.)
- **Calendar** - Event calendar styling
- **Kanban** - Drag-and-drop board styles
- And more...

The styles use Bootstrap's CSS custom properties (`var(--bs-*)`) and work seamlessly with light/dark themes.

### Customization

Override component styles in your own SCSS:

```scss
// assets/styles/custom.scss
.search-container {
    /* Override search styles */
}

.navbar-fullscreen-overlay {
    /* Override fullscreen navbar */
}
```

Or override component templates (see Customization section below).

---

## ⚙️ Configuration

Configure component defaults globally in `config/packages/ux_bootstrap.yaml`:

```yaml
# config/packages/ux_bootstrap.yaml
neuralglitch_ux_bootstrap:
  
  # Bootstrap Core Components (alphabetically ordered)
  
  badge:
    variant: 'secondary'
    pill: false
    class: null
  
  button:
    variant: 'primary'
    outline: false
    size: null
    tooltip:
      text: null
      placement: 'bottom'
  
  alert:
    variant: 'primary'
    dismissible: false
    fade: true
    auto_hide: false
  
  # Extra Components (alphabetically ordered)
  
  searchbar:
    placeholder: 'Search...'
    search_url: '/search'
    min_chars: 2
  
  hero:
    variant: 'centered'
    title: 'Build something great'
    cta_variant: 'primary'
```

All components respect these defaults but can be overridden per instance:

```twig
{# Uses global default (primary) #}
<twig:bs:button>Default Button</twig:bs:button>

{# Overrides with danger #}
<twig:bs:button variant="danger">Danger Button</twig:bs:button>
```

---

## 🎨 Customization

### Override Component Templates

```
your-project/
  templates/
    components/
      bootstrap/
        button.html.twig  ← Overrides bundle template
```

### Extend SearchService (Optional)

```php
namespace App\Service;

use NeuralGlitch\UxBootstrap\Service\Search\SearchService as BaseSearchService;

class CustomSearchService extends BaseSearchService
{
    protected function getStaticPages(): array
    {
        return [
            [
                'title' => 'Home',
                'url' => '/',
                'type' => 'Page',
            ],
        ];
    }
}
```

---

## 🧪 Local Development & Testing

Want to test the bundle in your project **before** it's published? Use Composer's path repository feature.

### Step 1: Configure Recipe Repository & Link Local Bundle

In your **test project's** `composer.json`, add both the custom recipe endpoint and the path repository:

```json
{
    "extra": {
        "symfony": {
            "endpoint": [
                "https://api.github.com/repos/neuralglitch/symfony-recipes/contents/index.json",
                "flex://defaults"
            ]
        }
    },
    "repositories": [
        {
            "type": "path",
            "url": "../ux-bootstrap",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

**Directory structure:**
```
your-workspace/
├── ux-bootstrap/          ← This bundle
└── my-project/            ← Your test Symfony project
    └── composer.json      ← Add recipe endpoint & path repository here
```

**Note:** The custom recipe endpoint is required for Symfony Flex to automatically install the bundle's configuration, templates, and assets.

### Step 2: Install Locally

```bash
cd my-project

# Install Bootstrap first (required)
php bin/console importmap:require bootstrap
php bin/console importmap:require @popperjs/core

# Install bundle from local path
composer require neuralglitch/ux-bootstrap:@dev
```

The `@dev` tells Composer to use your local development version.

### Step 3: Test Components

```twig
{# templates/test.html.twig #}
<twig:bs:badge variant="success">Local test works!</twig:bs:badge>
<twig:bs:button variant="primary">Testing locally</twig:bs:button>
```

### Step 4: Make Changes

**Edit bundle files** in `ux-bootstrap/src/...`

**Changes appear immediately** in your test project (thanks to symlink)!

```bash
# Clear cache to see changes
php bin/console cache:clear
```

### Step 5: Remove Local Version

When ready to use the published version:

```bash
composer remove neuralglitch/ux-bootstrap

# Remove the "repositories" section from composer.json

# Install from Packagist
composer require neuralglitch/ux-bootstrap
```

### Troubleshooting Recipes

If recipes aren't being applied automatically:

1. **Verify recipe endpoint is configured** in `composer.json` (see Step 1)
2. **Check Flex is installed**: `composer show symfony/flex`
3. **Force recipe application**:
   ```bash
   composer recipes:install neuralglitch/ux-bootstrap --force --reset
   ```
4. **Check recipe was found**:
   ```bash
   composer recipes
   ```
   You should see `neuralglitch/ux-bootstrap` in the list

If you still have issues, the bundle will work but you'll need to manually create the configuration file. See the [Configuration](#-configuration) section for details.

---

## 📖 Documentation

### Installation & Setup
- [Installation Guide](INSTALL.md) - Detailed installation steps
- [Search Implementation](docs/SEARCH_IMPLEMENTATION.md) - Optional search feature

### Component Documentation
- [Accordion Component](docs/accordion_component.md) - Collapsible content panels
- [List Group Component](docs/list_group_component.md) - Flexible lists and menus
- [Timeline Component](docs/timeline_component.md) - Chronological event timelines

### Additional Resources
- [Changelog](CHANGELOG.md) - Version history and releases
- [Contributing](CONTRIBUTING.md) - How to contribute to the project
- [License](LICENSE) - MIT License terms

### Bootstrap Resources
- [Bootstrap 5.3 Documentation](https://getbootstrap.com/docs/5.3/)
- [Symfony UX Documentation](https://ux.symfony.com/)
- [Stimulus Handbook](https://stimulus.hotwired.dev/)

---

## 🤝 Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🔗 Links

- **Repository:** [https://github.com/neuralglitch/ux-bootstrap](https://github.com/neuralglitch/ux-bootstrap)
- **Packagist:** [https://packagist.org/packages/neuralglitch/ux-bootstrap](https://packagist.org/packages/neuralglitch/ux-bootstrap)
- **Issues:** [https://github.com/neuralglitch/ux-bootstrap/issues](https://github.com/neuralglitch/ux-bootstrap/issues)

---

<div align="center">

**Made with ❤️ by [neuralglit.ch](https://neuralglit.ch)**

[⭐ Star on GitHub](https://github.com/neuralglitch/ux-bootstrap) • [📦 View on Packagist](https://packagist.org/packages/neuralglitch/ux-bootstrap)

</div>
