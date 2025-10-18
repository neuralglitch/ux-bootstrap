# Notification Center Component

## Overview

The **Notification Center** component provides a comprehensive solution for displaying user notifications, inbox-style messages, activity feeds, and alert history. It offers multiple display variants (dropdown, modal, offcanvas, popover, inline) with built-in features for marking notifications as read, clearing notifications, and auto-refreshing from a backend API.

**Component Tag:** `<twig:bs:notification-center>`  
**Namespace:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Stimulus Controller:** `bs-notification-center`

## Key Features

✅ **Multiple Variants:** Dropdown, modal, offcanvas, popover, or inline display  
✅ **Unread Badge:** Automatic unread count badge  
✅ **Mark as Read:** Individual or bulk mark as read  
✅ **Auto-Refresh:** Optional periodic fetching from API  
✅ **Customizable Trigger:** Icon, text, or combined button  
✅ **Actions:** Mark all read, clear all, delete individual  
✅ **Timestamps & Avatars:** Optional display  
✅ **Grouping:** Group notifications by date or category  
✅ **Responsive:** Mobile-friendly with all variants  
✅ **Accessible:** ARIA labels and keyboard navigation

## Use Cases

- **User Notifications:** System notifications, updates, announcements
- **Inbox Messages:** Unread message indicators and quick preview
- **Activity Feed:** Recent user activities and social updates
- **Alert History:** Past alerts and warnings
- **Task Notifications:** Assignment updates, deadline reminders
- **Social Notifications:** Likes, comments, mentions, follows

## Basic Usage

### Dropdown Variant (Default)

```twig
<twig:bs:notification-center>
  <twig:block name="content">
    <div class="dropdown-item notification-unread" data-notification-id="1">
      <div class="d-flex">
        <div class="flex-shrink-0">
          <img src="/avatar.jpg" alt="User" class="rounded-circle" width="40" height="40">
        </div>
        <div class="flex-grow-1 ms-3">
          <p class="mb-0"><strong>John Doe</strong> commented on your post</p>
          <small class="text-muted">5 minutes ago</small>
        </div>
      </div>
    </div>
    
    <div class="dropdown-item notification-read" data-notification-id="2">
      <div class="d-flex">
        <div class="flex-shrink-0">
          <span class="badge bg-success rounded-circle" style="width: 40px; height: 40px; line-height: 40px;">✓</span>
        </div>
        <div class="flex-grow-1 ms-3">
          <p class="mb-0">Your profile was updated successfully</p>
          <small class="text-muted">1 hour ago</small>
        </div>
      </div>
    </div>
  </twig:block>
</twig:bs:notification-center>
```

### Offcanvas Variant

```twig
<twig:bs:notification-center
    variant="offcanvas"
    offcanvasPlacement="end"
    title="Recent Notifications"
    :unreadCount="3">
  <twig:block name="content">
    {# Notification items here #}
  </twig:block>
</twig:bs:notification-center>
```

### Modal Variant

```twig
<twig:bs:notification-center
    variant="modal"
    modalSize="lg"
    :modalCentered="true"
    :modalScrollable="true">
  <twig:block name="content">
    {# Notification items here #}
  </twig:block>
</twig:bs:notification-center>
```

### Inline Variant

```twig
<twig:bs:notification-center
    variant="inline"
    title="Activity Feed"
    :showBadge="false">
  <twig:block name="content">
    {# Notification items here #}
  </twig:block>
</twig:bs:notification-center>
```

## Component Props

### Layout & Appearance

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'dropdown'` | Display variant: `'dropdown'`, `'popover'`, `'offcanvas'`, `'modal'`, `'inline'` |
| `title` | `string\|null` | `'Notifications'` | Title displayed in header |
| `emptyMessage` | `string\|null` | `'No notifications'` | Message when no notifications exist |

### Badge/Count

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `showBadge` | `bool` | `true` | Show unread count badge |
| `unreadCount` | `int` | `0` | Number of unread notifications |
| `badgeVariant` | `string` | `'danger'` | Bootstrap variant for badge |
| `badgePositioned` | `bool` | `true` | Use positioned badge (absolute positioning) |

### Trigger Button

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `triggerVariant` | `string` | `'link'` | Bootstrap button variant |
| `triggerIcon` | `string\|null` | `'🔔'` | Icon for trigger button |
| `triggerLabel` | `string\|null` | `null` | Text label for trigger button |
| `triggerIconOnly` | `bool` | `true` | Show only icon without label |

### Offcanvas Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `offcanvasPlacement` | `string` | `'end'` | Placement: `'start'`, `'end'`, `'top'`, `'bottom'` |
| `offcanvasBackdrop` | `bool` | `true` | Show backdrop overlay |
| `offcanvasScroll` | `bool` | `false` | Allow body scrolling |

### Modal Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modalSize` | `string\|null` | `null` | Size: `null`, `'sm'`, `'lg'`, `'xl'` |
| `modalCentered` | `bool` | `false` | Vertically center modal |
| `modalScrollable` | `bool` | `true` | Scrollable modal body |

### Dropdown Options

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `dropdownDirection` | `string` | `'dropdown'` | Direction: `'dropdown'`, `'dropup'`, `'dropstart'`, `'dropend'` |
| `dropdownMenuAlign` | `string` | `'end'` | Menu alignment: `'start'`, `'end'` |
| `dropdownWidth` | `string` | `'350px'` | CSS width value |
| `dropdownMaxHeight` | `string` | `'400px'` | CSS max-height value |

### Features

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `grouped` | `bool` | `false` | Group notifications by date/category |
| `showTimestamps` | `bool` | `true` | Show notification timestamps |
| `showAvatars` | `bool` | `true` | Show user avatars |
| `showActions` | `bool` | `true` | Show action buttons (mark read, delete) |
| `showMarkAllRead` | `bool` | `true` | Show "Mark all read" button |
| `showClearAll` | `bool` | `true` | Show "Clear all" button |
| `showViewAll` | `bool` | `true` | Show "View all" link |
| `viewAllHref` | `string\|null` | `null` | URL for "View all" link |
| `viewAllLabel` | `string` | `'View all notifications'` | Label for "View all" link |

### Behavior

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `markReadOnClick` | `bool` | `true` | Auto-mark as read when clicked |
| `autoRefresh` | `bool` | `false` | Enable auto-refresh from API |
| `autoRefreshInterval` | `int` | `30000` | Refresh interval in milliseconds |
| `fetchUrl` | `string\|null` | `null` | API URL to fetch notifications |

### IDs

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string\|null` | Auto-generated | Container element ID |
| `triggerId` | `string\|null` | Auto-generated | Trigger button ID |
| `menuId` | `string\|null` | Auto-generated | Menu/panel ID |

### Common

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### With Unread Badge

```twig
<twig:bs:notification-center
    :unreadCount="5"
    badgeVariant="danger"
    :badgePositioned="true">
  {# Notifications #}
</twig:bs:notification-center>
```

### With Custom Trigger

```twig
<twig:bs:notification-center
    triggerVariant="primary"
    triggerLabel="Notifications"
    triggerIcon="🔔"
    :triggerIconOnly="false">
  {# Notifications #}
</twig:bs:notification-center>
```

### With Auto-Refresh

```twig
<twig:bs:notification-center
    :autoRefresh="true"
    :autoRefreshInterval="60000"
    fetchUrl="/api/notifications">
  {# Notifications will auto-refresh every 60 seconds #}
</twig:bs:notification-center>
```

### Structured Notification Items

```twig
<twig:bs:notification-center variant="dropdown">
  <twig:block name="content">
    {# Unread notification #}
    <a href="/posts/123" 
       class="dropdown-item notification-unread" 
       data-notification-id="1"
       data-action="click->bs-notification-center#markAsRead">
      <div class="d-flex align-items-start">
        <img src="/avatars/john.jpg" 
             alt="John Doe" 
             class="rounded-circle me-3" 
             width="40" 
             height="40">
        <div class="flex-grow-1">
          <p class="mb-1"><strong>John Doe</strong> commented on your post</p>
          <small class="text-muted">5 minutes ago</small>
        </div>
        <button type="button" 
                class="btn btn-sm btn-link text-danger ms-2"
                data-action="click->bs-notification-center#deleteNotification">
          ✕
        </button>
      </div>
    </a>
    
    {# Read notification #}
    <a href="/profile/updated" 
       class="dropdown-item notification-read" 
       data-notification-id="2">
      <div class="d-flex align-items-start">
        <span class="badge bg-success rounded-circle me-3" style="width: 40px; height: 40px; line-height: 40px;">
          ✓
        </span>
        <div class="flex-grow-1">
          <p class="mb-1">Your profile was updated</p>
          <small class="text-muted">2 hours ago</small>
        </div>
      </div>
    </a>
    
    {# Divider for grouping #}
    <div class="dropdown-divider"></div>
    <div class="dropdown-header">Earlier</div>
    
    {# Older notifications #}
    <a href="/settings" 
       class="dropdown-item notification-read" 
       data-notification-id="3">
      <div class="d-flex align-items-start">
        <span class="me-3">⚙️</span>
        <div class="flex-grow-1">
          <p class="mb-1">New privacy settings available</p>
          <small class="text-muted">Yesterday</small>
        </div>
      </div>
    </a>
  </twig:block>
</twig:bs:notification-center>
```

### With Grouping

```twig
<twig:bs:notification-center 
    variant="offcanvas"
    :grouped="true">
  <twig:block name="content">
    <div class="notification-group">
      <div class="dropdown-header fw-bold">Today</div>
      {# Today's notifications #}
    </div>
    
    <div class="notification-group">
      <div class="dropdown-header fw-bold">Yesterday</div>
      {# Yesterday's notifications #}
    </div>
    
    <div class="notification-group">
      <div class="dropdown-header fw-bold">This Week</div>
      {# This week's notifications #}
    </div>
  </twig:block>
</twig:bs:notification-center>
```

### Inbox-Style Messages

```twig
<twig:bs:notification-center
    variant="modal"
    modalSize="lg"
    title="Messages"
    triggerIcon="✉️"
    :unreadCount="3">
  <twig:block name="content">
    <a href="/messages/1" 
       class="list-group-item list-group-item-action notification-unread" 
       data-notification-id="msg-1">
      <div class="d-flex w-100 align-items-start">
        <img src="/avatars/alice.jpg" 
             alt="Alice Smith" 
             class="rounded-circle me-3" 
             width="48" 
             height="48">
        <div class="flex-grow-1">
          <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Alice Smith</h6>
            <small class="text-muted">10 min ago</small>
          </div>
          <p class="mb-1">Hey! Are you available for a quick call?</p>
          <small class="text-primary">📧 Unread</small>
        </div>
      </div>
    </a>
    
    <a href="/messages/2" 
       class="list-group-item list-group-item-action notification-read" 
       data-notification-id="msg-2">
      <div class="d-flex w-100 align-items-start">
        <img src="/avatars/bob.jpg" 
             alt="Bob Johnson" 
             class="rounded-circle me-3" 
             width="48" 
             height="48">
        <div class="flex-grow-1">
          <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">Bob Johnson</h6>
            <small class="text-muted">2 hours ago</small>
          </div>
          <p class="mb-1 text-muted">Thanks for your help earlier!</p>
        </div>
      </div>
    </a>
  </twig:block>
</twig:bs:notification-center>
```

### Activity Feed

```twig
<twig:bs:notification-center
    variant="inline"
    title="Recent Activity"
    :showBadge="false"
    viewAllHref="/activity">
  <twig:block name="content">
    <div class="list-group list-group-flush">
      <div class="list-group-item" data-notification-id="act-1">
        <div class="d-flex">
          <span class="me-3">👤</span>
          <div class="flex-grow-1">
            <p class="mb-0"><strong>Sarah</strong> started following you</p>
            <small class="text-muted">15 minutes ago</small>
          </div>
        </div>
      </div>
      
      <div class="list-group-item" data-notification-id="act-2">
        <div class="d-flex">
          <span class="me-3">❤️</span>
          <div class="flex-grow-1">
            <p class="mb-0"><strong>Mike</strong> liked your photo</p>
            <small class="text-muted">1 hour ago</small>
          </div>
        </div>
      </div>
      
      <div class="list-group-item" data-notification-id="act-3">
        <div class="d-flex">
          <span class="me-3">💬</span>
          <div class="flex-grow-1">
            <p class="mb-0"><strong>Emma</strong> mentioned you in a comment</p>
            <small class="text-muted">3 hours ago</small>
          </div>
        </div>
      </div>
    </div>
  </twig:block>
</twig:bs:notification-center>
```

## Notification Item Structure

Each notification item should have:

1. **`data-notification-id` attribute:** Unique identifier
2. **State class:** Either `notification-unread` or `notification-read`
3. **Clickable element:** Link or button
4. **Optional action buttons:** For mark as read, delete, etc.

### Recommended HTML Structure

```html
<a href="/notification/link" 
   class="dropdown-item notification-unread" 
   data-notification-id="unique-id">
  <div class="d-flex align-items-start">
    <!-- Avatar/Icon -->
    <img src="avatar.jpg" class="rounded-circle me-3" width="40" height="40">
    
    <!-- Content -->
    <div class="flex-grow-1">
      <p class="mb-1">Notification message</p>
      <small class="text-muted">Timestamp</small>
    </div>
    
    <!-- Optional: Action buttons -->
    <button type="button" 
            class="btn btn-sm btn-link"
            data-action="click->bs-notification-center#deleteNotification">
      ✕
    </button>
  </div>
</a>
```

## Stimulus Controller API

### Targets

- `trigger`: Trigger button element
- `badge`: Badge element showing unread count
- `notificationList`: Container for notification items

### Values

- `unreadCount`: Number of unread notifications (updates badge automatically)
- `markReadOnClick`: Auto-mark notifications as read when clicked
- `autoRefresh`: Enable auto-refresh functionality
- `autoRefreshInterval`: Interval in milliseconds
- `fetchUrl`: API endpoint for fetching notifications

### Actions

| Action | Description |
|--------|-------------|
| `markAsRead` | Mark a single notification as read |
| `markAsUnread` | Mark a single notification as unread |
| `markAllRead` | Mark all notifications as read |
| `clearAll` | Clear all notifications (with confirmation) |
| `deleteNotification` | Delete a single notification |
| `refresh` | Manually refresh notifications from API |

### Events

The controller dispatches the following custom events:

| Event | Detail | Description |
|-------|--------|-------------|
| `marked-read` | `{ id }` | Notification marked as read |
| `marked-unread` | `{ id }` | Notification marked as unread |
| `marked-all-read` | - | All notifications marked as read |
| `cleared-all` | - | All notifications cleared |
| `deleted` | `{ id }` | Notification deleted |
| `refreshed` | `{ data }` | Notifications refreshed from API |
| `refresh-error` | `{ error }` | Error during refresh |

### Example: Listening to Events

```javascript
document.addEventListener('bs-notification-center:marked-read', (event) => {
    const notificationId = event.detail.id;
    console.log(`Notification ${notificationId} marked as read`);
});
```

## Backend Integration

### API Endpoints

The component expects the following API structure when `fetchUrl` is provided:

#### GET /api/notifications
Fetch notifications list

**Response:**
```json
{
  "html": "<div class='dropdown-item'>...</div>",
  "unreadCount": 5
}
```

#### POST /api/notifications/{id}/read
Mark notification as read

#### POST /api/notifications/{id}/unread
Mark notification as unread

#### POST /api/notifications/read-all
Mark all notifications as read

#### POST /api/notifications/clear-all
Clear all notifications

#### DELETE /api/notifications/{id}
Delete a notification

### Symfony Example

```php
#[Route('/api/notifications', name: 'api_notifications')]
public function notifications(): JsonResponse
{
    $notifications = $this->notificationRepository->findByUser(
        $this->getUser(),
        limit: 10
    );
    
    $html = $this->renderView('notifications/_list.html.twig', [
        'notifications' => $notifications,
    ]);
    
    $unreadCount = $this->notificationRepository->countUnreadByUser(
        $this->getUser()
    );
    
    return new JsonResponse([
        'html' => $html,
        'unreadCount' => $unreadCount,
    ]);
}

#[Route('/api/notifications/{id}/read', name: 'api_notification_read', methods: ['POST'])]
public function markAsRead(Notification $notification): JsonResponse
{
    $notification->setReadAt(new \DateTime());
    $this->entityManager->flush();
    
    return new JsonResponse(['success' => true]);
}
```

## Styling

### CSS Classes

```css
/* Container */
.notification-center { }

/* Trigger button */
.notification-icon { }

/* Menu/List */
.notification-menu { }
.notification-list { }

/* Notification items */
.notification-unread {
    background-color: #f8f9fa;
    font-weight: 500;
}

.notification-read {
    opacity: 0.7;
}

/* Groups */
.notification-group { }

/* Actions */
.notification-actions { }
```

### Custom Styling Example

```scss
.notification-center {
    // Custom unread indicator
    .notification-unread {
        border-left: 3px solid var(--bs-primary);
        background-color: rgba(var(--bs-primary-rgb), 0.05);
    }
    
    // Hover effect
    .dropdown-item:hover {
        background-color: var(--bs-light);
    }
    
    // Compact spacing
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
}
```

## Accessibility

The component implements the following accessibility features:

✅ **ARIA Labels:** Proper labeling for screen readers  
✅ **Keyboard Navigation:** Full keyboard support  
✅ **Focus Management:** Proper focus handling  
✅ **Semantic HTML:** Uses appropriate HTML elements  
✅ **Screen Reader Announcements:** Updates announced to assistive technology

### Best Practices

1. Always provide meaningful `title` and `emptyMessage` props
2. Use `aria-label` for icon-only triggers
3. Ensure notification items have descriptive text
4. Use proper heading hierarchy in grouped notifications
5. Test with screen readers (NVDA, JAWS, VoiceOver)

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  notification_center:
    variant: 'dropdown'
    unread_count: 0
    badge_variant: 'danger'
    trigger_variant: 'link'
    trigger_icon: '🔔'
    auto_refresh: false
    auto_refresh_interval: 30000
    # ... other options
```

## Testing

### Unit Tests

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/NotificationCenterTest.php
```

### Example Test

```php
public function testUnreadCount(): void
{
    $component = new NotificationCenter($this->config);
    $component->unreadCount = 5;
    $component->mount();
    $options = $component->options();

    $this->assertSame(5, $options['unreadCount']);
    $this->assertTrue($options['showBadge']);
}
```

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Related Components

- `bs:alert` - Individual alerts
- `bs:alert-stack` - Stack of alerts/toasts
- `bs:toast` - Toast notifications
- `bs:dropdown` - Base dropdown component
- `bs:offcanvas` - Offcanvas panel
- `bs:modal` - Modal dialogs
- `bs:badge` - Badge indicators

## References

- [Bootstrap Dropdowns](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [Bootstrap Offcanvas](https://getbootstrap.com/docs/5.3/components/offcanvas/)
- [Bootstrap Modal](https://getbootstrap.com/docs/5.3/components/modal/)
- [Bootstrap Badges](https://getbootstrap.com/docs/5.3/components/badge/)
- [Stimulus.js Documentation](https://stimulus.hotwired.dev/)

## Changelog

See [CHANGELOG.md](../CHANGELOG.md) for version history.

