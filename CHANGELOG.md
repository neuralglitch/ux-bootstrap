# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- N/A

### Changed
- N/A

### Fixed
- N/A

---

## [0.0.1] - 2025-10-18

### Added
- Initial release of Symfony UX Bootstrap Bundle
- Bootstrap 5.3 Twig Components:
  - Accordion with flush variant and always-open option
  - Alert with auto-hide and dismissible options
  - Badge with pill style and positioning
  - Breadcrumbs with auto-generation from routes
  - Button with icons, tooltips, and popovers
  - Button Group with vertical orientation and sizing options
  - Card with header/body/footer blocks
  - Carousel with indicators, controls, captions, fade/dark variants, and auto-play
  - Collapse with vertical/horizontal transitions, accordion support, and accessibility features
  - Dropdown with split buttons, directions (dropup, dropend, dropstart), menu alignment, and dark mode
  - Link with enhanced features (tooltips, popovers, underline control)
  - List Group with action items, variants, numbered/horizontal layouts, and tab support
  - Modal with multiple sizes, fullscreen modes, and static backdrop support
  - Nav with tabs, pills, underline styles, vertical layout, and responsive options
  - Navbar with 8 collapse types (standard, offcanvas, fullscreen, mega-menu, etc.)
  - Offcanvas with 4 placements (start, end, top, bottom), backdrop control, and scrolling options
  - Pagination with sizing (sm, lg), alignment (start, center, end), and full accessibility support
  - Placeholder (skeleton loaders) with grid-based widths, color variants, sizing (lg, sm, xs), and animations (glow, wave)
  - Progress with labels, variants, striped and animated options, custom heights, and accessibility support
  - Spinner with border/grow types, color variants, sizing, and accessibility support
  - Toast with auto-hide and positioning
- Extra Components:
  - ActivityFeed for timeline-style activity feeds with two components (bs:activity-feed container and bs:activity-feed-item), display modes (default/compact), icons and avatars support, timestamps, metadata arrays, clickable items with href, action buttons, highlighted and unread indicators, border variants (start/end/none), scrollable containers with maxHeight, and custom styling support - perfect for social media feeds, audit logs, team activity, system events, and notification feeds
  - AlertStack for flash messages, bulk notifications, and toast management with 6 position options (top/bottom x start/center/end), auto-hide, dismissible alerts, max alerts limit, and Stimulus controller for dynamic add/remove - perfect for form feedback, system notifications, and real-time updates
  - Avatar for user profile pictures with initials fallback, sizes (xs/sm/md/lg/xl/xxl), shapes (circle/square/rounded), status indicators (online/offline/away/busy), and border customization
  - Calendar for event calendars with month/week/day/list views, interactive navigation (prev/next/today), view switcher, event rendering with colors, async event loading, time grid for week/day views, time format (12h/24h), configurable time slots, event and date click handling, business hours support, weekend toggling, week numbers, multi-language support, and Stimulus controller for dynamic rendering - perfect for team calendars, meeting planners, event scheduling, content calendars, and availability displays - **NOT a datepicker** but a full event calendar
  - CodeBlock for syntax highlighted code snippets with copy-to-clipboard button, line numbers, language display, file name/title headers, theme variants (light/dark/auto), scrollable containers with max height, line wrapping, and Stimulus controller for clipboard functionality - perfect for documentation sites, tutorials, code examples, and technical blogs
  - ColorPicker for color selection with preset color swatches, custom hex input, native color picker integration, configurable grid layouts (columns), size variants (sm/default/lg for component and swatches), inline mode, form validation support, and Stimulus controller for synchronization - perfect for theme customization, branding tools, design systems, form styling, and color palette management
  - CookieBanner for GDPR/CCPA compliant cookie consent banners with accept/reject/customize buttons, policy links (privacy/cookie), localStorage and cookie persistence, multiple positioning options (top/bottom with fixed/relative), dismissible mode, backdrop overlay, custom button variants, configurable expiry days, and Stimulus controller with consent events (accepted/rejected/customize/dismissed) - perfect for public websites, compliance requirements, marketing sites, and user privacy management
  - CommentThread for nested, threaded comments with configurable max depth, reply/edit/delete/like actions, author highlighting, flexible date formatting (relative/absolute/both), avatar support with sizes (sm/md/lg/xl), user badges, thread lines connecting replies, collapsible threads, compact mode, and customizable action buttons - perfect for blog posts, articles, discussions, forums, and user feedback
  - CommandPalette for Cmd+K style quick actions, navigation shortcuts, and admin commands with keyboard-driven interface (Cmd+K / Ctrl+K), fuzzy search and filtering, keyboard navigation (arrow keys, enter, escape), recent commands tracking, grouped commands by category, icons and shortcuts display, customizable triggers, and Stimulus controller for modal management - perfect for power users, admin interfaces, quick navigation, and workflow automation
  - ComparisonTable for feature comparisons with 5 layout variants (default/bordered/striped/cards/horizontal), column highlighting, custom checkmarks, sticky headers, responsive design, CTA buttons per plan, and pricing display - perfect for pricing pages, product comparisons, and plan comparisons
  - CTA (Call-to-Action) blocks for marketing pages with 5 layout variants (centered/split/bordered/background/minimal), primary and secondary buttons, optional icons, background colors, text colors, borders, shadows, and flexible alignment - perfect for landing pages, product pages, blog posts, and conversion-focused sections
  - DataTable for feature-rich data tables with column-based sorting, row selection with checkboxes, actions column, responsive design with breakpoint control, empty state display, card wrapper option, flexible column configuration with custom formatters, Bootstrap table styling (striped/bordered/hover/small/variants), caption support, and server-side sorting integration - perfect for admin panels, reports, dashboards, user management, order listings, and product catalogs
  - DropdownMulti for multi-select dropdowns with checkboxes, search/filter functionality, select all/clear all actions, optional apply button, customizable button label (individual items or count), form integration with array name support, descriptions for options, disabled options support, Bootstrap variants and sizing, dark mode, custom max height, and Stimulus controller for dynamic selection management - perfect for filters, permissions selection, category selection, and tag selection
  - EmptyState for empty tables, search results, and onboarding experiences
  - FAQ (Frequently Asked Questions) for styled Q&A sections with 4 layout variants (accordion/simple/card/bordered), optional title and lead text, accordion with flush style and always-open option, auto-generated IDs, and support for HTML content in answers - perfect for help centers, product documentation, support pages, and knowledge bases
  - FeatureGrid for landing page features with icons and descriptions, 6 display variants (default/icon-lg/icon-box/icon-colored/bordered/shadow), flexible column layouts (2/3/4/6), optional headings/subheadings, and support for feature links - perfect for showcasing product features, service offerings, and benefits sections
  - Hero sections with 5 variants
  - MetricsGrid for enhanced metrics display with responsive grid layout (1-6 columns), optional sparkline visualizations for trend data, trend indicators (up/down/neutral with icons), icon support with positioning options (start/end/top), descriptions and change percentages, equal height cards, flexible styling (variants, borders, shadows), configurable sizing (sm/default/lg), text alignment options, responsive breakpoint control (sm/md/lg/xl/xxl), and global or per-metric styling - perfect for dashboards, analytics pages, KPI displays, and performance monitoring
  - Kanban for drag-and-drop task boards with 3 sub-components (Kanban, KanbanColumn, KanbanCard), horizontal/vertical/compact layouts, drag-and-drop with Stimulus controller, WIP (Work In Progress) limits per column, priority indicators (low/medium/high/urgent), collapsible columns, card counts, customizable styling (variants, borders, shadows), responsive design (stacks on mobile), clickable cards with links, avatar and metadata support, and custom events for backend integration - perfect for task management, project boards, workflow tracking, and order status
  - Lightbox for image galleries with zoom, keyboard navigation (arrows, escape), touch/swipe gestures, thumbnails, captions, autoplay, fullscreen mode, and multiple transition effects (fade/slide/zoom) - perfect for portfolios, product galleries, photo albums, and real estate listings
  - MegaFooter for complex multi-column footers with branding, social links, newsletter signup, copyright auto-generation, 4 layout variants (default/minimal/centered/compact), up to 6 customizable columns via named blocks, responsive layouts, and full color customization - perfect for company websites, marketing pages, and web applications
  - NotificationCenter for user notifications, inbox-style messages, activity feeds, and alert history with 5 display variants (dropdown/popover/offcanvas/modal/inline), unread badge with counts, mark as read/unread functionality, bulk actions (mark all read, clear all), auto-refresh from API, grouping by date/category, timestamps, avatars, and Stimulus controller for interactive features - perfect for user notification systems, messaging platforms, activity logs, and real-time updates
  - NotificationBadge for notification indicators on navigation items, avatars, and buttons with dot mode (no content), pulse animation for new notifications, 4 position options (top-start/top-end/bottom-start/bottom-end), 3 sizes (sm/md/lg), max number display (e.g., 99+), bordered style, inline mode, all Bootstrap color variants, and custom content support - perfect for notification counts, unread indicators, online status, shopping cart items, and system alerts
  - PricingCard for subscription plans, pricing pages, and plan comparisons with customizable features, badges, CTA buttons, and featured/shadow styling
  - Rating for reviews, feedback forms, product ratings, and skill levels with multiple display modes (stars/hearts/circles), interactive and read-only states, half-star support, size variants, color customization, and full accessibility
  - SearchBar with live search
  - Sidebar for flexible navigation with 5 variants (fixed/collapsible/overlay/push/mini), mobile responsive behavior, multi-level navigation support, optional header/footer, customizable width and position, backdrop overlay, smooth transitions, and Stimulus controller for interactive toggle and collapse - perfect for admin dashboards, documentation sites, settings pages, and application navigation
  - SplitPanes for resizable split layouts with horizontal/vertical orientation, mouse and touch drag support, keyboard navigation (arrow keys, Home/End), collapsible panes with snap threshold, min/max size constraints, persistent sizing via localStorage, customizable divider, and full accessibility with ARIA attributes - perfect for code editors (source/preview), email clients (list/detail), documentation (toc/content), and data comparison views
  - Skeleton for content-aware loading states with predefined templates (text/heading/avatar/card/list/paragraph), natural width variations, multiple animation types (wave/pulse/none), and customizable options - more advanced than Bootstrap's basic placeholders
  - Stat cards for statistics/KPIs/metrics display
  - Stepper for multi-step progress indicators in checkout flows, onboarding, registration wizards, and survey forms with horizontal/vertical layouts, multiple styles (default/progress/minimal/icon), clickable completed steps, progress bars, and custom icons
  - TabPane for tabbed content interfaces
  - Testimonial for customer testimonials and social proof sections with 5 layout variants (single/featured/grid/wall/minimal), star ratings, avatar support, and flexible alignment options - perfect for marketing sites, landing pages, and service pages
  - Theme toggle for dark/light mode
  - Timeline for chronological event displays with multiple layouts (vertical/horizontal/alternating), state indicators (pending/active/completed), and use cases like order tracking, activity logs, and project milestones
  - Tour for guided product tours and feature highlights with step-by-step walkthroughs, element highlighting, backdrop overlay, progress tracking, keyboard navigation (arrows, escape), customizable button labels, dark/light themes, callbacks (onStart, onComplete, onSkip, onStepShow), persistent completion tracking, and Stimulus controller for dynamic control - perfect for onboarding new users, announcing features, training workflows, and interactive documentation
  - TreeView for hierarchical tree structures with expand/collapse functionality, node selection (single/multiple), keyboard navigation (arrow keys, Enter, Space, Home, End), customizable icons (files, folders, expand/collapse), connecting lines, compact/hoverable modes, event callbacks, and Stimulus controller - perfect for file browsers, category trees, organization structures, and menu editors
- Stimulus Controllers:
  - Alert controller for auto-hide
  - AlertStack controller for dynamic alert management (add/remove/clear)
  - Calendar controller for event calendar with view switching (month/week/day/list), navigation (prev/next/today), event rendering, async event loading, and custom events (dateClick, eventClick) for integration
  - CodeBlock controller for copy-to-clipboard functionality with visual feedback
  - ColorPicker controller for preset swatch selection, hex input validation, and native color picker synchronization with custom events (bs-color-picker:change) for integration
  - CookieBanner controller for cookie consent management with localStorage and cookie persistence, consent events (accepted/rejected/customize/dismissed), and auto-show on first visit
  - Kanban controller for drag-and-drop boards with WIP limits, column management, and custom events (card-moved, add-card) for backend integration
  - Link controller for tooltips/popovers
  - Navbar controllers (fullscreen, mega-menu, sticky)
  - NotificationCenter controller for notification management (mark as read/unread, delete, clear all, auto-refresh, badge updates)
  - Sidebar controller for toggle/collapse, mobile responsive behavior, and keyboard navigation (escape key)
  - SplitPanes controller for split panes resize, collapse, and keyboard navigation
  - Theme controller for dark/light switching
  - Toast controller for notifications
  - Tour controller for guided product tours with step navigation, element highlighting, backdrop, progress tracking, and keyboard support
  - TreeView controller for expand/collapse, selection, and keyboard navigation
  - Clipboard controller for copy functionality
  - Search controller for live search
  - Scrollspy controller for documentation
- Configuration system via YAML (`config/packages/ux_bootstrap.yaml`)
- Comprehensive documentation and installation guide
- PHPUnit test support with Docker integration
- MIT License


### Fixed
- N/A (initial release)

### Removed
- N/A (initial release)

### Security
- N/A (initial release)

---

## Version History

- **[Unreleased]** - Future changes (none yet)
- **[0.0.1]** - 2025-10-18 - Initial release

---

[Unreleased]: https://github.com/neuralglitch/ux-bootstrap/compare/v0.0.1...HEAD
[0.0.1]: https://github.com/neuralglitch/ux-bootstrap/releases/tag/v0.0.1

