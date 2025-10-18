# Command Palette Component

**Component Tag:** `bs:command-palette`  
**Type:** Extra Component  
**Namespace:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra`

## Overview

The Command Palette is a modern, keyboard-driven interface component inspired by applications like Slack, GitHub, and VS Code. It provides quick access to commands, actions, and navigation through a searchable modal interface triggered by keyboard shortcuts (typically Cmd+K or Ctrl+K).

**Key Features:**
- ⌨️ Keyboard-driven interface (Cmd+K / Ctrl+K)
- 🔍 Fuzzy search and filtering
- 📁 Grouped commands by category
- 🕐 Recent commands tracking
- ⚡ Fast keyboard navigation (arrow keys, enter)
- 🎨 Modern, accessible design
- 📱 Responsive and mobile-friendly

## Use Cases

- **Quick Actions**: Trigger common actions without navigating menus
- **Navigation Shortcuts**: Jump to any page in your application
- **Admin Commands**: Power user features and administrative tasks
- **Search Interface**: Universal search across your application
- **Workflow Automation**: Chain multiple commands together

## Basic Usage

### Minimal Example

```twig
<twig:bs:command-palette />
```

This creates a command palette with default settings, triggered by Cmd+K (Mac) or Ctrl+K (Windows/Linux).

### Custom Configuration

```twig
<twig:bs:command-palette
    searchUrl="/api/command-palette"
    placeholder="Search commands..."
    :maxRecent="10"
    size="xl"
/>
```

### Backend Integration

The component expects your backend to return JSON in this format:

```json
{
  "commands": [
    {
      "id": "create-post",
      "label": "Create New Post",
      "description": "Create a new blog post",
      "icon": "📝",
      "group": "Quick Actions",
      "action": "create-post",
      "href": "/posts/new",
      "shortcut": "Cmd+N"
    },
    {
      "id": "nav-dashboard",
      "label": "Dashboard",
      "description": "Go to dashboard",
      "icon": "📊",
      "group": "Navigation",
      "href": "/dashboard"
    }
  ]
}
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| **Keyboard Trigger** | | | |
| `trigger` | string | `'Cmd+K'` | Display name for trigger shortcut |
| `triggerKey` | string | `'k'` | Key to trigger the palette |
| `triggerCtrl` | bool | `false` | Require Ctrl key |
| `triggerMeta` | bool | `true` | Require Meta/Cmd key (Mac) |
| `triggerShift` | bool | `false` | Require Shift key |
| `triggerAlt` | bool | `false` | Require Alt/Option key |
| **Appearance** | | | |
| `placeholder` | string | `'Type a command or search...'` | Input placeholder text |
| `emptyMessage` | string | `'No commands found'` | Message when no results |
| `showShortcuts` | bool | `true` | Show keyboard shortcuts next to commands |
| `showIcons` | bool | `true` | Show icons for commands |
| `showRecent` | bool | `true` | Show recent commands section |
| `maxRecent` | int | `5` | Maximum recent commands to show |
| **Behavior** | | | |
| `searchUrl` | string | `'/command-palette'` | Backend endpoint for search |
| `minChars` | int | `0` | Minimum characters before search |
| `debounce` | int | `150` | Debounce delay in milliseconds |
| `closeOnSelect` | bool | `true` | Close palette when command selected |
| `closeOnEscape` | bool | `true` | Close palette on Escape key |
| `closeOnBackdrop` | bool | `true` | Close when clicking backdrop |
| **Modal Styling** | | | |
| `size` | string | `'lg'` | Modal size: `'sm'`, `'lg'`, `'xl'` |
| `placement` | string | `'top'` | Modal placement: `'top'`, `'center'` |
| `centered` | bool | `false` | Center modal vertically |
| `scrollable` | bool | `false` | Scrollable modal body |
| **Animation** | | | |
| `animation` | string | `'fade'` | Animation: `'fade'`, `'none'` |
| `animationDuration` | int | `200` | Animation duration in milliseconds |
| **Categories/Groups** | | | |
| `grouped` | bool | `true` | Group commands by category |
| `defaultGroups` | array | `['Quick Actions', 'Navigation', 'Admin']` | Default group names |
| **Base Props** | | | |
| `class` | string | `null` | Additional CSS classes |
| `attr` | array | `[]` | Additional HTML attributes |

## Examples

### 1. Quick Actions Palette

Perfect for common tasks in your application:

```twig
<twig:bs:command-palette
    placeholder="What do you want to do?"
    searchUrl="/api/quick-actions"
    :defaultGroups="['Quick Actions', 'Tools', 'Settings']"
/>
```

**Backend Response:**
```json
{
  "commands": [
    {
      "id": "new-user",
      "label": "Create New User",
      "description": "Add a new user account",
      "icon": "👤",
      "group": "Quick Actions",
      "href": "/users/new",
      "shortcut": "Cmd+U"
    },
    {
      "id": "export-data",
      "label": "Export Data",
      "description": "Export all data to CSV",
      "icon": "📥",
      "group": "Tools",
      "action": "export-csv"
    }
  ]
}
```

### 2. Navigation Palette

Jump to any page in your application:

```twig
<twig:bs:command-palette
    placeholder="Go to..."
    searchUrl="/api/navigation"
    triggerKey="p"
    :showIcons="false"
    :defaultGroups="['Pages', 'Settings', 'Admin']"
/>
```

This would be triggered with Cmd+P instead of Cmd+K.

### 3. Admin Command Center

Powerful admin tools accessible via keyboard:

```twig
<twig:bs:command-palette
    placeholder="Admin command..."
    searchUrl="/api/admin-commands"
    size="xl"
    :showRecent="true"
    :maxRecent="10"
    :defaultGroups="['User Management', 'System', 'Content', 'Reports']"
/>
```

### 4. Custom Trigger (Ctrl+Space)

```twig
<twig:bs:command-palette
    triggerKey=" "
    :triggerCtrl="true"
    :triggerMeta="false"
    trigger="Ctrl+Space"
    placeholder="Search anything..."
/>
```

### 5. Windows/Linux Style (Ctrl+K)

```twig
<twig:bs:command-palette
    :triggerCtrl="true"
    :triggerMeta="false"
    trigger="Ctrl+K"
/>
```

### 6. No Grouping

Flat list of commands without categories:

```twig
<twig:bs:command-palette
    :grouped="false"
    searchUrl="/api/commands/all"
/>
```

## Backend Implementation

### Symfony Controller Example

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommandPaletteController extends AbstractController
{
    #[Route('/command-palette', name: 'command_palette_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q', '');
        
        // Define all available commands
        $allCommands = [
            [
                'id' => 'create-post',
                'label' => 'Create New Post',
                'description' => 'Write a new blog post',
                'icon' => '📝',
                'group' => 'Quick Actions',
                'href' => $this->generateUrl('post_new'),
                'shortcut' => 'Cmd+N'
            ],
            [
                'id' => 'nav-dashboard',
                'label' => 'Dashboard',
                'description' => 'Go to main dashboard',
                'icon' => '📊',
                'group' => 'Navigation',
                'href' => $this->generateUrl('dashboard')
            ],
            [
                'id' => 'settings',
                'label' => 'Settings',
                'description' => 'Manage application settings',
                'icon' => '⚙️',
                'group' => 'Navigation',
                'href' => $this->generateUrl('settings')
            ],
            [
                'id' => 'user-list',
                'label' => 'User Management',
                'description' => 'View and manage users',
                'icon' => '👥',
                'group' => 'Admin',
                'href' => $this->generateUrl('admin_users')
            ],
        ];
        
        // Filter commands based on query
        $filteredCommands = array_filter($allCommands, function($command) use ($query) {
            if (empty($query)) {
                return true;
            }
            
            $searchText = strtolower($command['label'] . ' ' . ($command['description'] ?? ''));
            return str_contains($searchText, strtolower($query));
        });
        
        return new JsonResponse([
            'commands' => array_values($filteredCommands)
        ]);
    }
}
```

### Laravel Controller Example

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandPaletteController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        $allCommands = [
            [
                'id' => 'create-post',
                'label' => 'Create New Post',
                'description' => 'Write a new blog post',
                'icon' => '📝',
                'group' => 'Quick Actions',
                'href' => route('posts.create'),
            ],
            // ... more commands
        ];
        
        // Simple search
        if (!empty($query)) {
            $allCommands = array_filter($allCommands, function($cmd) use ($query) {
                $search = strtolower($cmd['label'] . ' ' . ($cmd['description'] ?? ''));
                return str_contains($search, strtolower($query));
            });
        }
        
        return response()->json([
            'commands' => array_values($allCommands)
        ]);
    }
}
```

## JavaScript Events

The component dispatches custom events that you can listen to:

### `command:execute`

Fired when a command is executed (for commands with `action` instead of `href`).

```javascript
document.addEventListener('command:execute', (event) => {
    const { id, action, command } = event.detail;
    
    console.log('Command executed:', id);
    console.log('Action:', action);
    console.log('Full command:', command);
    
    // Handle the command
    if (action === 'export-csv') {
        exportDataToCSV();
    } else if (action === 'clear-cache') {
        clearApplicationCache();
    }
});
```

## Keyboard Navigation

| Key | Action |
|-----|--------|
| `Cmd+K` / `Ctrl+K` | Open command palette |
| `↑` / `↓` | Navigate through commands |
| `Enter` | Execute selected command |
| `Escape` | Close palette |
| `Home` | Jump to first command |
| `End` | Jump to last command |

## Accessibility

The command palette is fully accessible:

- **ARIA Attributes**: Proper `role="dialog"`, `aria-label`, and `aria-hidden` attributes
- **Keyboard Navigation**: Full keyboard support for navigation and selection
- **Screen Reader Support**: All elements properly labeled
- **Focus Management**: Automatic focus on input when opened
- **High Contrast**: Works with high contrast themes

### Screen Reader Announcements

```twig
<twig:bs:command-palette
    attr="{
        'aria-label': 'Command Palette - Search commands and navigate',
        'aria-describedby': 'palette-help'
    }"
/>
```

## Styling & Customization

### Custom Classes

```twig
<twig:bs:command-palette
    class="my-custom-palette elevated-shadow"
/>
```

### Custom Colors

Override CSS custom properties:

```scss
.command-palette-content {
    --command-palette-bg: #1e1e1e;
    --command-palette-text: #ffffff;
    --command-palette-accent: #007bff;
}
```

### Dark Mode

The component automatically adapts to dark mode via Bootstrap's color modes:

```html
<html data-bs-theme="dark">
    <!-- Command palette will use dark theme -->
</html>
```

## Best Practices

### 1. Command Organization

Group commands logically:
- **Quick Actions**: Most common tasks
- **Navigation**: Page navigation
- **Settings**: Configuration options
- **Admin**: Administrative tasks

### 2. Search Performance

For large command sets:
- Implement server-side fuzzy search
- Use debouncing (default: 150ms)
- Cache command lists
- Index searchable text

### 3. Command Naming

- Use clear, action-oriented labels
- Include helpful descriptions
- Add relevant keywords for search
- Use consistent terminology

### 4. Keyboard Shortcuts

- Document all shortcuts
- Avoid conflicts with browser shortcuts
- Use platform-appropriate modifiers
- Keep shortcuts memorable

### 5. Icons

Use recognizable icons:
```javascript
{
  "icon": "📝",  // Emoji
  "icon": "<i class='bi bi-pencil'></i>",  // Bootstrap Icons
  "icon": "<svg>...</svg>"  // SVG
}
```

## Configuration

Global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  command_palette:
    trigger: 'Cmd+K'
    trigger_key: 'k'
    trigger_ctrl: false
    trigger_meta: true
    placeholder: 'Type a command or search...'
    empty_message: 'No commands found'
    show_shortcuts: true
    show_icons: true
    show_recent: true
    max_recent: 5
    search_url: '/command-palette'
    min_chars: 0
    debounce: 150
    close_on_select: true
    size: 'lg'
    placement: 'top'
    grouped: true
    default_groups: ['Quick Actions', 'Navigation', 'Admin']
```

## Testing

The command palette can be tested programmatically:

```javascript
// Trigger the palette
const palette = document.querySelector('[data-controller="bs-command-palette"]');
const controller = application.getControllerForElementAndIdentifier(palette, 'bs-command-palette');

// Open programmatically
controller.open();

// Simulate search
controller.inputTarget.value = 'dashboard';
controller.handleInput({ currentTarget: controller.inputTarget });

// Close
controller.close();
```

## Browser Support

- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile browsers: ✅ Responsive design

## Performance

- **Initial Load**: ~5KB (minified + gzipped)
- **Search Latency**: <150ms (with debouncing)
- **Rendering**: <16ms for 100 commands
- **Memory**: <1MB for recent commands storage

## Troubleshooting

### Commands Not Appearing

1. Check backend endpoint returns correct JSON format
2. Verify CORS settings if API is on different domain
3. Check browser console for errors
4. Ensure `searchUrl` is correct

### Keyboard Shortcut Not Working

1. Check for conflicting browser shortcuts
2. Verify trigger key configuration
3. Test in different browsers
4. Check if modal is properly initialized

### Styling Issues

1. Ensure Bootstrap 5.3+ CSS is loaded
2. Check for CSS conflicts
3. Verify dark mode settings
4. Clear browser cache

## Related Components

- **Navbar** - Traditional navigation
- **SearchBar** - Simple search interface
- **Dropdown** - Menu-based actions
- **Modal** - Dialog windows

## References

- [Bootstrap Modal Documentation](https://getbootstrap.com/docs/5.3/components/modal/)
- [Stimulus Documentation](https://stimulus.hotwired.dev/)
- [Command Palette Design Pattern](https://commandpalette.dev/)
- [Accessibility Guidelines](https://www.w3.org/WAI/ARIA/apg/patterns/dialog-modal/)

## Examples in the Wild

- GitHub: Cmd+K for search and navigation
- VS Code: Cmd+Shift+P for command palette
- Slack: Cmd+K for quick switcher
- Linear: Cmd+K for command menu
- Vercel: Cmd+K for quick actions

