// UX Bootstrap Stimulus Controllers
// Auto-imported by Symfony Flex recipe

import BsAlertController from '@neuralglitch/ux-bootstrap/controllers/bs_alert_controller.js';
import BsAlertStackController from '@neuralglitch/ux-bootstrap/controllers/bs_alert_stack_controller.js';
import BsBreadcrumbsController from '@neuralglitch/ux-bootstrap/controllers/bs_breadcrumbs_controller.js';
import BsCalendarController from '@neuralglitch/ux-bootstrap/controllers/bs_calendar_controller.js';
import BsCodeBlockController from '@neuralglitch/ux-bootstrap/controllers/bs_code_block_controller.js';
import BsColorPickerController from '@neuralglitch/ux-bootstrap/controllers/bs_color_picker_controller.js';
import BsCommandPaletteController from '@neuralglitch/ux-bootstrap/controllers/bs_command_palette_controller.js';
import BsCookieBannerController from '@neuralglitch/ux-bootstrap/controllers/bs_cookie_banner_controller.js';
import BsDropdownMultiController from '@neuralglitch/ux-bootstrap/controllers/bs_dropdown_multi_controller.js';
import BsKanbanController from '@neuralglitch/ux-bootstrap/controllers/bs_kanban_controller.js';
import BsLightboxController from '@neuralglitch/ux-bootstrap/controllers/bs_lightbox_controller.js';
import BsLinkController from '@neuralglitch/ux-bootstrap/controllers/bs_link_controller.js';
import BsNavbarFullscreenController from '@neuralglitch/ux-bootstrap/controllers/bs_navbar_fullscreen_controller.js';
import BsNavbarMegaMenuController from '@neuralglitch/ux-bootstrap/controllers/bs_navbar_mega_menu_controller.js';
import BsNavbarStickyController from '@neuralglitch/ux-bootstrap/controllers/bs_navbar_sticky_controller.js';
import BsNotificationCenterController from '@neuralglitch/ux-bootstrap/controllers/bs_notification_center_controller.js';
import BsSearchController from '@neuralglitch/ux-bootstrap/controllers/bs_search_controller.js';
import BsSidebarController from '@neuralglitch/ux-bootstrap/controllers/bs_sidebar_controller.js';
import BsSplitPanesController from '@neuralglitch/ux-bootstrap/controllers/bs_split_panes_controller.js';
import BsThemeController from '@neuralglitch/ux-bootstrap/controllers/bs_theme_controller.js';
import BsToastController from '@neuralglitch/ux-bootstrap/controllers/bs_toast_controller.js';
import BsTourController from '@neuralglitch/ux-bootstrap/controllers/bs_tour_controller.js';
import BsTreeViewController from '@neuralglitch/ux-bootstrap/controllers/bs_tree_view_controller.js';

export function registerUxBootstrapControllers(app) {
    app.register('bs-alert', BsAlertController);
    app.register('bs-alert-stack', BsAlertStackController);
    app.register('bs-breadcrumbs', BsBreadcrumbsController);
    app.register('bs-calendar', BsCalendarController);
    app.register('bs-code-block', BsCodeBlockController);
    app.register('bs-color-picker', BsColorPickerController);
    app.register('bs-command-palette', BsCommandPaletteController);
    app.register('bs-cookie-banner', BsCookieBannerController);
    app.register('bs-dropdown-multi', BsDropdownMultiController);
    app.register('bs-kanban', BsKanbanController);
    app.register('bs-lightbox', BsLightboxController);
    app.register('bs-link', BsLinkController);
    app.register('bs-navbar-fullscreen', BsNavbarFullscreenController);
    app.register('bs-navbar-mega-menu', BsNavbarMegaMenuController);
    app.register('bs-navbar-sticky', BsNavbarStickyController);
    app.register('bs-notification-center', BsNotificationCenterController);
    app.register('bs-search', BsSearchController);
    app.register('bs-sidebar', BsSidebarController);
    app.register('bs-split-panes', BsSplitPanesController);
    app.register('bs-theme', BsThemeController);
    app.register('bs-toast', BsToastController);
    app.register('bs-tour', BsTourController);
    app.register('bs-tree-view', BsTreeViewController);
}

