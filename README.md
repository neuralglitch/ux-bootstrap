<div align="center">

# Symfony UX Bootstrap

### Reusable Bootstrap 5.3 Twig Components for Symfony

[![Tests](https://github.com/neuralglitch/ux-bootstrap/workflows/Tests/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/tests.yml)
[![Static Analysis](https://github.com/neuralglitch/ux-bootstrap/workflows/Static%20Analysis/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/static-analysis.yml)
[![Build](https://github.com/neuralglitch/ux-bootstrap/workflows/Build/badge.svg)](https://github.com/neuralglitch/ux-bootstrap/actions/workflows/build.yml)

[![php](https://img.shields.io/badge/PHP-8.1+-4F5B93.svg?style=flat-square)](https://www.php.net/)
[![symfony](https://img.shields.io/badge/Symfony-6.4%20%7C%207.x-1F2937.svg?style=flat-square)](https://www.symfony.com/)
[![bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952b3.svg?style=flat-square)](https://getbootstrap.com/)
[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

A production-ready collection of Bootstrap 5.3 Twig Components and Stimulus controllers for Symfony applications. Transform your Bootstrap HTML into clean, reusable Twig components.

[Documentation](#-documentation) • [Installation](#-installation) • [Components](#-components)

</div>

---

## ✨ Features

- **🧩 29 Bootstrap Core Components** - Complete coverage of Bootstrap 5.3 components (alphabetically organized): Accordion, Alert, Badge, Breadcrumbs, Button, Button Group, Card, Carousel, Collapse, Dropdown, Link, List Group, Modal, Nav, Navbar, Offcanvas, Pagination, Placeholder, Progress, Spinner, Toast, and all their sub-components
- **✨ 41 Extra Components** - Advanced UI components built on Bootstrap (alphabetically organized): ActivityFeed, AlertStack, Avatar, Calendar, CodeBlock, ColorPicker, CommandPalette, CommentThread, ComparisonTable, CookieBanner, CTA, DataTable, DropdownMulti, EmptyState, FAQ, FeatureGrid, Hero, Kanban, Lightbox, MegaFooter, MetricsGrid, NotificationBadge, NotificationCenter, PricingCard, Rating, SearchBar, Sidebar, Skeleton, SplitPanes, Stat, Stepper, TabPane, Testimonial, ThemeToggle, Timeline, Tour, TreeView
- **⚡ 20 Stimulus Controllers** - Interactive features for tooltips, popovers, theme switching, live search, drag-and-drop, and more
- **🎨 Works with Your Bootstrap** - Integrates seamlessly with existing Bootstrap 5.3 installations
- **⚙️ Highly Configurable** - YAML-based defaults for every component
- **📦 Simple Installation** - Nearly zero-config: `composer require neuralglitch/ux-bootstrap`
- **✅ Production Ready** - Type-safe, tested, documented

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

### Bootstrap Core Components (29)

Complete Twig component coverage of Bootstrap 5.3, alphabetically organized:

| Component | Tag | Description |
|-----------|-----|-------------|
| **Accordion** | `bs:accordion` | Collapsible content panels with flush variant |
| **Accordion Item** | `bs:accordion-item` | Individual accordion panel item |
| **Alert** | `bs:alert` | Dismissible alerts with auto-hide and Stimulus integration |
| **Badge** | `bs:badge` | Badges with pill style, positioning, and link support |
| **Breadcrumbs** | `bs:breadcrumbs` | Auto-generated breadcrumb navigation from routes |
| **Button** | `bs:button` | Buttons with icons, tooltips, popovers, and all Bootstrap variants |
| **Button Group** | `bs:button-group` | Grouped buttons with vertical layout and sizing |
| **Card** | `bs:card` | Content cards with header/body/footer blocks and image positions |
| **Carousel** | `bs:carousel` | Image/content slideshow with indicators, controls, and transitions |
| **Carousel Item** | `bs:carousel-item` | Individual carousel slide |
| **Collapse** | `bs:collapse` | Toggle visibility with smooth animations |
| **Dropdown** | `bs:dropdown` | Dropdown menus with split buttons, directions, and auto-close options |
| **Dropdown Divider** | `bs:dropdown-divider` | Horizontal divider for dropdown menus |
| **Dropdown Header** | `bs:dropdown-header` | Header text for dropdown sections |
| **Dropdown Item** | `bs:dropdown-item` | Individual dropdown menu item |
| **Link** | `bs:link` | Enhanced links with icons, tooltips, popovers, and underline control |
| **List Group** | `bs:list-group` | Flexible lists with actions, variants, horizontal layout, and tabs |
| **List Group Item** | `bs:list-group-item` | Individual list item with variants and states |
| **Modal** | `bs:modal` | Dialog windows with sizes, fullscreen modes, centering, and scrollable content |
| **Nav** | `bs:nav` | Navigation with tabs, pills, underline, vertical, and justified layouts |
| **Nav Item** | `bs:nav-item` | Individual navigation item |
| **Navbar** | `bs:navbar` | Responsive navigation bars with 8 collapse types and sticky behaviors |
| **Offcanvas** | `bs:offcanvas` | Slideable sidebars from any edge with backdrop and scroll options |
| **Pagination** | `bs:pagination` | Page navigation with sizing and alignment |
| **Pagination Item** | `bs:pagination-item` | Individual pagination page item |
| **Placeholder** | `bs:placeholder` | Loading state placeholders with wave/glow animations |
| **Progress** | `bs:progress` | Progress bars with labels, variants, striped, and animated options |
| **Spinner** | `bs:spinner` | Loading indicators with border/grow types |
| **Toast** | `bs:toast` | Toast notifications with auto-hide and positioning |

### Extra Components (41)

Advanced UI components built on Bootstrap, alphabetically organized:

| Component | Tag | Use Cases |
|-----------|-----|-----------|
| **ActivityFeed** | `bs:activity-feed` | Social feeds, audit logs, team activity, system events |
| **ActivityFeedItem** | `bs:activity-feed-item` | Individual activity feed item |
| **AlertStack** | `bs:alert-stack` | Flash messages, bulk notifications, toast management |
| **Avatar** | `bs:avatar` | User profiles, team members, contact lists |
| **Calendar** | `bs:calendar` | Event management, scheduling, meeting planners |
| **CodeBlock** | `bs:code-block` | Documentation, tutorials, API examples |
| **ColorPicker** | `bs:color-picker` | Theme customization, branding, design tools |
| **CommandPalette** | `bs:command-palette` | Quick actions, navigation shortcuts, admin commands |
| **CommentThread** | `bs:comment-thread` | Blog comments, discussions, feedback |
| **ComparisonTable** | `bs:comparison-table` | Pricing pages, feature comparisons, product specs |
| **CookieBanner** | `bs:cookie-banner` | GDPR/CCPA compliance, consent management |
| **CTA** | `bs:cta` | Marketing pages, landing pages, call-to-actions |
| **DataTable** | `bs:data-table` | Admin panels, reports, dashboards, user management |
| **DropdownMulti** | `bs:dropdown-multi` | Filters, permissions, categories, tags |
| **EmptyState** | `bs:empty-state` | Empty tables, no results, new user onboarding |
| **FAQ** | `bs:faq` | Help pages, documentation, support |
| **FeatureGrid** | `bs:feature-grid` | Landing pages, product features, service listings |
| **Hero** | `bs:hero` | Landing pages, home pages, marketing sections |
| **Kanban** | `bs:kanban` | Task management, project boards, workflow tracking |
| **KanbanCard** | `bs:kanban-card` | Individual kanban board card |
| **KanbanColumn** | `bs:kanban-column` | Kanban board column/lane |
| **Lightbox** | `bs:lightbox` | Image galleries, portfolios, product photos |
| **MegaFooter** | `bs:mega-footer` | Site-wide footers with multiple columns and sections |
| **MetricsGrid** | `bs:metrics-grid` | Dashboards, analytics, KPI displays |
| **NotificationBadge** | `bs:notification-badge` | Unread counts, status indicators, alerts |
| **NotificationCenter** | `bs:notification-center` | User notifications, inbox, activity alerts |
| **PricingCard** | `bs:pricing-card` | Subscription plans, pricing pages |
| **Rating** | `bs:rating` | Reviews, feedback, skill levels |
| **SearchBar** | `bs:searchbar` | Site search, documentation search |
| **Sidebar** | `bs:sidebar` | Admin panels, documentation, settings |
| **Skeleton** | `bs:skeleton` | Loading states, content placeholders |
| **SplitPanes** | `bs:split-panes` | Code editors, email clients, resizable layouts |
| **Stat** | `bs:stat` | Statistics, KPIs, metrics cards |
| **Stepper** | `bs:stepper` | Multi-step forms, wizards, onboarding flows |
| **TabPane** | `bs:tab-pane` | Tabbed content, settings panels |
| **Testimonial** | `bs:testimonial` | Customer reviews, social proof |
| **ThemeToggle** | `bs:theme-toggle` | Dark/light mode toggle with multiple display modes |
| **Timeline** | `bs:timeline` | Order tracking, activity logs, milestones |
| **TimelineItem** | `bs:timeline-item` | Individual timeline event item |
| **Tour** | `bs:tour` | Product tours, feature announcements, training |
| **TreeView** | `bs:tree-view` | File browsers, category trees, navigation structures |

---

### Stimulus Controllers (20)

Interactive behavior powered by Stimulus, alphabetically organized:

| Controller | Stimulus Tag | Description |
|------------|--------------|-------------|
| **Alert** | `bs-alert` | Alert auto-hide & dismissal |
| **AlertStack** | `bs-alert-stack` | Alert stack management with dynamic add/remove |
| **Calendar** | `bs-calendar` | Event calendar with view switching, navigation, and event management |
| **CodeBlock** | `bs-code-block` | Code block copy-to-clipboard functionality |
| **ColorPicker** | `bs-color-picker` | Color picker with preset swatches and custom color input synchronization |
| **CookieBanner** | `bs-cookie-banner` | Cookie consent banner with localStorage/cookie persistence and consent events |
| **DropdownMulti** | `bs-dropdown-multi` | Multi-select dropdown with search, filters, and bulk actions |
| **Kanban** | `bs-kanban` | Kanban board drag-and-drop with WIP limits and column management |
| **Lightbox** | `bs-lightbox` | Image gallery lightbox with zoom, keyboard, and touch support |
| **Link** | `bs-link` | Tooltip/popover initialization and management |
| **Navbar Fullscreen** | `bs-navbar-fullscreen` | Fullscreen overlay navbar with fade/slide animations |
| **Navbar Mega Menu** | `bs-navbar-mega-menu` | Mega menu navigation with multi-column dropdowns |
| **Navbar Sticky** | `bs-navbar-sticky` | Sticky navbar with scroll behaviors (shrink, auto-hide, shadow) |
| **NotificationCenter** | `bs-notification-center` | Notification center with mark as read, auto-refresh, and badge management |
| **Search** | `bs-search` | Live search with debouncing and keyboard navigation |
| **Sidebar** | `bs-sidebar` | Sidebar toggle, collapse, and responsive behavior |
| **SplitPanes** | `bs-split-panes` | Split panes resize, collapse, and keyboard navigation |
| **Theme** | `bs-theme` | Dark/light mode theme switching with persistence |
| **Toast** | `bs-toast` | Toast notification management and auto-hide |
| **Tour** | `bs-tour` | Guided product tour with step navigation, element highlighting, and progress tracking |

---

## 🎨 Component Styles

The bundle includes pre-compiled CSS for component enhancements (~30KB).

### Installation

After installing the bundle, make the CSS available:

```bash
php bin/console assets:install
```

### Include in Your Template

```twig
{# templates/base.html.twig #}
<head>
    {# Bootstrap (required - must be loaded first) #}
    {{ importmap('bootstrap') }}
    
    {# Bundle component enhancements #}
    <link href="{{ asset('bundles/neuralglitchuxbootstrap/ux_bootstrap.css') }}" rel="stylesheet">
</head>
```

**Important:** Bootstrap must be loaded **before** the bundle's CSS.

### What's Included

The CSS provides enhancements for:
- **SearchBar** - Styled search input with results dropdown
- **Navbar** - Multiple collapse types, behaviors (sticky, auto-hide, fullscreen, etc.)

The CSS uses Bootstrap's CSS custom properties (`var(--bs-*)`) and works seamlessly with light/dark themes.

### Customization

You can override the bundled styles in your own CSS:

```css
/* assets/styles/custom.css */
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
  
  # ============================================================
  # Bootstrap Core Components (alphabetically ordered)
  # ============================================================
  
  # Badge defaults
  badge:
    variant: 'secondary'
    pill: false
    href: null
    class: null
    attr: {  }
  
  # Button defaults
  button:
    variant: 'primary'
    outline: false
    size: null
    tooltip:
      text: null
      placement: 'bottom'
    popover:
      title: null
      content: null
    icon_gap: 2
  
  # Alert defaults
  alert:
    variant: 'primary'
    dismissible: false
    fade: true
    auto_hide: false
    auto_hide_delay: 5000
  
  # Modal defaults
  modal:
    size: null
    centered: false
    backdrop: true
    keyboard: true
  
  # ============================================================
  # Extra Components (alphabetically ordered)
  # ============================================================
  
  # SearchBar defaults
  searchbar:
    placeholder: 'Search...'
    search_url: '/search'
    min_chars: 2
    debounce: 300
  
  # Hero defaults
  hero:
    variant: 'centered'
    title: 'Build something great'
    cta_variant: 'primary'
    cta_size: 'lg'
```

All components respect these defaults, but can be overridden per instance:

```twig
{# Uses global default (primary) #}
<twig:bs:button>Default Button</twig:bs:button>

{# Overrides with danger #}
<twig:bs:button variant="danger">Danger Button</twig:bs:button>

{# Uses searchbar defaults #}
<twig:bs:searchbar />

{# Overrides with custom settings #}
<twig:bs:searchbar placeholder="Search docs..." :minChars="1" />
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
