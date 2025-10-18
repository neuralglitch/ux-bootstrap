# UX Bootstrap Components Documentation

Welcome to the **UX Bootstrap** component library documentation. This bundle provides a comprehensive collection of Bootstrap 5.3 Twig Components built with Symfony UX TwigComponent.

## Overview

UX Bootstrap offers two types of components:

- **Bootstrap Components**: Direct implementations of official Bootstrap 5.3 components
- **Extra Components**: Custom, feature-rich components built on top of Bootstrap for common UI patterns

All components are:
- ✅ Fully typed with PHP 8.2+
- ✅ Configurable via YAML
- ✅ Accessible and semantic
- ✅ Thoroughly tested
- ✅ Production-ready

## Bootstrap Components

Core Bootstrap 5.3 components with Symfony UX TwigComponent integration.

### Layout & Structure
- [Accordion](bootstrap/accordion_component.md) - Collapsible accordion panels ([Example](bootstrap/examples/accordion_example.html.twig))
- [Card](bootstrap/card_component.md) - Flexible content containers ([Example](bootstrap/examples/card_example.html.twig))
- [Collapse](bootstrap/collapse_component.md) - Toggle visibility of content ([Example](bootstrap/examples/collapse_example.html.twig))
- [ListGroup](bootstrap/list_group_component.md) - Flexible lists of content ([Example](bootstrap/examples/list_group_example.html.twig))

### Navigation
- [Breadcrumbs](bootstrap/breadcrumbs_component.md) - Navigation breadcrumb trails ([Example](bootstrap/examples/breadcrumbs_example.html.twig))
- [Nav](bootstrap/nav_component.md) - Navigation tabs and pills ([Example](bootstrap/examples/nav_example.html.twig))
- [Navbar](bootstrap/navbar_component.md) - Responsive navigation bars ([Example](bootstrap/examples/navbar_example.html.twig))
- [Pagination](bootstrap/pagination_component.md) - Pagination controls ([Example](bootstrap/examples/pagination_example.html.twig))

### Buttons & Links
- [Button](bootstrap/button_component.md) - Enhanced buttons with icons and tooltips ([Example](bootstrap/examples/button_example.html.twig))
- [ButtonGroup](bootstrap/button_group_component.md) - Grouped button sets ([Example](bootstrap/examples/button_group_example.html.twig))
- [Link](bootstrap/link_component.md) - Enhanced links with tooltips and popovers ([Example](bootstrap/examples/link_example.html.twig))

### Feedback
- [Alert](bootstrap/alert_component.md) - Dismissible alert messages ([Example](bootstrap/examples/alert_example.html.twig))
- [Badge](bootstrap/badge_component.md) - Small count and label badges ([Example](bootstrap/examples/badge_example.html.twig))
- [Progress](bootstrap/progress_component.md) - Progress bars ([Example](bootstrap/examples/progress_example.html.twig))
- [Spinner](bootstrap/spinner_component.md) - Loading spinners ([Example](bootstrap/examples/spinner_example.html.twig))
- [Toast](bootstrap/toast_component.md) - Notification toasts ([Example](bootstrap/examples/toast_example.html.twig))
- [Placeholder](bootstrap/placeholder_component.md) - Loading placeholders ([Example](bootstrap/examples/placeholder_example.html.twig))

### Overlays
- [Dropdown](bootstrap/dropdown_component.md) - Dropdown menus ([Example](bootstrap/examples/dropdown_example.html.twig))
- [Modal](bootstrap/modal_component.md) - Modal dialogs ([Example](bootstrap/examples/modal_example.html.twig))
- [Offcanvas](bootstrap/offcanvas_component.md) - Off-canvas sidebars ([Example](bootstrap/examples/offcanvas_example.html.twig))

### Media
- [Carousel](bootstrap/carousel_component.md) - Image and content carousels ([Example](bootstrap/examples/carousel_example.html.twig))

## Extra Components

Custom components that extend Bootstrap with additional functionality and patterns.

### User Interface
- [AlertStack](extra/alert_stack_component.md) - Stack of dismissible alerts ([Example](extra/examples/alert_stack_example.html.twig))
- [Avatar](extra/avatar_component.md) - User avatars with fallbacks ([Example](extra/examples/avatar_example.html.twig))
- [CommandPalette](extra/command_palette_component.md) - Command palette for quick actions ([Example](extra/examples/command_palette_example.html.twig))
- [EmptyState](extra/empty_state_component.md) - Empty state placeholders ([Example](extra/examples/empty_state_example.html.twig))
- [NotificationBadge](extra/notification_badge_component.md) - Notification count badges ([Example](extra/examples/notification_badge_example.html.twig))
- [NotificationCenter](extra/notification_center_component.md) - Notification center panel ([Example](extra/examples/notification_center_example.html.twig))
- [Sidebar](extra/sidebar_component.md) - Collapsible sidebar navigation ([Example](extra/examples/sidebar_example.html.twig))
- [Skeleton](extra/skeleton_component.md) - Loading skeletons ([Example](extra/examples/skeleton_example.html.twig))
- [Theme](extra/theme_component.md) - Dark/light mode toggle ([Example](extra/examples/theme_example.html.twig))

### Content Display
- [ActivityFeed](extra/activity_feed_component.md) - Activity timeline feed ([Examples](extra/examples/activity_feed_examples.html.twig))
- [CodeBlock](extra/code_block_component.md) - Syntax-highlighted code blocks ([Example](extra/examples/code_block_example.html.twig))
- [CommentThread](extra/comment_thread_component.md) - Nested comment threads ([Examples](extra/examples/comment_thread_examples.html.twig))
- [ComparisonTable](extra/comparison_table_component.md) - Feature comparison tables ([Example](extra/examples/comparison_table_example.html.twig))
- [DataTable](extra/data_table_component.md) - Advanced data tables ([Example](extra/examples/data_table_example.html.twig))
- [Faq](extra/faq_component.md) - FAQ accordion sections ([Example](extra/examples/faq_example.html.twig))
- [MetricsGrid](extra/metrics_grid_component.md) - Metrics dashboard grid ([Examples](extra/examples/metrics_grid_examples.html.twig))
- [PricingCard](extra/pricing_card_component.md) - Pricing plan cards ([Example](extra/examples/pricing_card_example.html.twig))
- [Rating](extra/rating_component.md) - Star rating displays ([Example](extra/examples/rating_example.html.twig))
- [Stat](extra/stat_component.md) - Statistic cards with trends ([Example](extra/examples/stat_example.html.twig))
- [Testimonial](extra/testimonial_component.md) - Testimonial cards ([Example](extra/examples/testimonial_example.html.twig))
- [Timeline](extra/timeline_component.md) - Vertical timeline displays ([Example](extra/examples/timeline_example.html.twig))

### Forms & Input
- [Calendar](extra/calendar_component.md) - Date picker calendars ([Example](extra/examples/calendar_example.html.twig))
- [ColorPicker](extra/color_picker_component.md) - Color selection input ([Example](extra/examples/color_picker_example.html.twig))
- [DropdownMulti](extra/dropdown_multi_component.md) - Multi-select dropdowns ([Example](extra/examples/dropdown_multi_example.html.twig))
- [SearchBar](extra/search_implementation.md) - Live search input with autocomplete ([Example](extra/examples/searchbar_example.html.twig))
- [Stepper](extra/stepper_component.md) - Multi-step form wizard ([Example](extra/examples/stepper_example.html.twig))

### Marketing & Landing
- [Cta](extra/cta_component.md) - Call-to-action sections ([Example](extra/examples/cta_example.html.twig))
- [FeatureGrid](extra/feature_grid_component.md) - Feature showcase grid ([Example](extra/examples/feature_grid_example.html.twig))
- [Hero](extra/hero_component.md) - Hero/banner sections ([Example](extra/examples/hero_example.html.twig))
- [MegaFooter](extra/mega_footer_component.md) - Multi-column footer ([Example](extra/examples/mega_footer_example.html.twig))

### Organization & Navigation
- [Kanban](extra/kanban_component.md) - Kanban board with drag-and-drop ([Example](extra/examples/kanban_example.html.twig))
- [SplitPanes](extra/split_panes_component.md) - Resizable split panes ([Example](extra/examples/split_panes_example.html.twig))
- [TabPane](extra/tab_pane_component.md) - Enhanced tab navigation ([Example](extra/examples/tab_pane_example.html.twig))
- [Tour](extra/tour_component.md) - Guided product tours ([Example](extra/examples/tour_example.html.twig))
- [TreeView](extra/tree_view_component.md) - Expandable tree navigation ([Example](extra/examples/tree_view_example.html.twig))

### Media & Lightbox
- [Lightbox](extra/lightbox_component.md) - Image lightbox galleries ([Example](extra/examples/lightbox_example.html.twig))

## Getting Started

### Installation

```bash
composer require neuralglitch/ux-bootstrap
```

### Basic Usage

All components use the `bs:` prefix for Twig tags:

```twig
{# Bootstrap Components #}
<twig:bs:button variant="primary">Click Me</twig:bs:button>
<twig:bs:alert variant="success" dismissible>Success!</twig:bs:alert>
<twig:bs:badge variant="danger">New</twig:bs:badge>

{# Extra Components #}
<twig:bs:hero 
    variant="centered"
    title="Welcome to UX Bootstrap"
    ctaLabel="Get Started"
    ctaHref="/docs"
/>

<twig:bs:stat
    label="Total Users"
    value="1,234"
    trend="up"
    trendValue="12%"
    variant="success"
/>
```

### Configuration

All components are configurable via `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  button:
    variant: 'primary'
    size: null
    class: 'my-custom-class'
  
  alert:
    variant: 'info'
    dismissible: false
    auto_hide: false
```

## Component Props

Each component supports:
- **Typed Properties**: All props are strongly typed (PHP 8.2+)
- **Custom Classes**: Add custom CSS classes via `class` prop
- **Custom Attributes**: Add HTML attributes via `attr` prop
- **Configuration Defaults**: Set project-wide defaults via YAML

Example:

```twig
<twig:bs:button
    variant="success"
    size="lg"
    :disabled="false"
    class="my-custom-class"
    :attr="{
        'data-test': 'submit-button',
        'aria-label': 'Submit form'
    }"
>
    Submit
</twig:bs:button>
```

## Stimulus Controllers

Many components include Stimulus controllers for enhanced interactivity:

- `bs-alert` - Auto-hide alerts
- `bs-breadcrumbs` - Collapsible breadcrumbs
- `bs-link` - Tooltip/popover initialization
- `bs-navbar-fullscreen` - Fullscreen navbar overlay
- `bs-navbar-mega-menu` - Mega menu behavior
- `bs-navbar-sticky` - Sticky navbar on scroll
- `bs-search` - Live search functionality
- `bs-theme` - Theme switching (light/dark)
- `bs-toast` - Toast notifications
- `bs-alert-stack` - Alert stack management
- `bs-calendar` - Calendar interactions
- `bs-color-picker` - Color picker functionality
- `bs-command-palette` - Command palette interactions
- `bs-dropdown-multi` - Multi-select dropdown
- `bs-kanban` - Kanban drag-and-drop
- `bs-lightbox` - Lightbox navigation
- `bs-notification-center` - Notification management
- `bs-sidebar` - Sidebar toggle
- `bs-split-panes` - Pane resizing
- `bs-tour` - Product tour steps
- `bs-tree-view` - Tree expansion/collapse

## Testing

All components have comprehensive test coverage (≥80% line coverage):

```bash
bin/php-in-docker vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](../CONTRIBUTING.md) for guidelines.

## License

This bundle is released under the MIT License. See [LICENSE](../LICENSE) for details.

## Support

- 📖 [Documentation](https://github.com/neuralglitch/ux-bootstrap)
- 🐛 [Issue Tracker](https://github.com/neuralglitch/ux-bootstrap/issues)
- 💬 [Discussions](https://github.com/neuralglitch/ux-bootstrap/discussions)

---

Built with ❤️ by [NeuralGlitch](https://github.com/neuralglitch)

