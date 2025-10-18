# ActivityFeed Component

## Overview

The `ActivityFeed` component displays a timeline-style feed of activity items, perfect for:

- **Social media feeds** - Posts, comments, likes, shares
- **Audit logs** - System changes, user actions, security events
- **Team activity** - Member updates, project changes, milestones
- **System events** - Notifications, alerts, status updates

The component consists of two parts:
- `bs:activity-feed` - The container component
- `bs:activity-feed-item` - Individual feed items

## Basic Usage

### Simple Feed

```twig
<twig:bs:activity-feed>
    <twig:bs:activity-feed-item
        icon="bi-person-plus"
        iconVariant="success"
        title="John Doe joined the team"
        timestamp="2 hours ago"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-file-earmark"
        iconVariant="primary"
        title="New document uploaded"
        description="project-proposal.pdf"
        timestamp="5 hours ago"
    />
</twig:bs:activity-feed>
```

### With Avatars

```twig
<twig:bs:activity-feed>
    <twig:bs:activity-feed-item
        avatar="/images/avatars/john.jpg"
        title="John Doe commented on your post"
        description="Great work on the new feature!"
        timestamp="10 minutes ago"
        :unread="true"
    />
</twig:bs:activity-feed>
```

## Component Props

### ActivityFeed Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `mode` | `?string` | `'default'` | Display mode: `'default'` or `'compact'` |
| `showTimestamps` | `?bool` | `true` | Whether to display timestamps |
| `showIcons` | `?bool` | `true` | Whether to display icons/avatars |
| `border` | `?string` | `'start'` | Border style: `null`, `'start'`, or `'end'` |
| `groupByDate` | `?bool` | `false` | Group items by date (not yet implemented) |
| `maxHeight` | `?string` | `null` | Maximum height with scroll (e.g., `'400px'`) |
| `tag` | `string` | `'div'` | HTML tag for container |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### ActivityFeedItem Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `icon` | `?string` | `null` | Icon class (e.g., `'bi-person-plus'`) |
| `avatar` | `?string` | `null` | Avatar image URL |
| `iconVariant` | `?string` | `'primary'` | Bootstrap color variant for icon background |
| `title` | `?string` | `null` | Item title (main text) |
| `description` | `?string` | `null` | Item description (secondary text) |
| `timestamp` | `?string` | `null` | Timestamp text (e.g., "2 hours ago") |
| `metadata` | `array` | `[]` | Additional metadata strings |
| `href` | `?string` | `null` | Makes entire item clickable |
| `actionLabel` | `?string` | `null` | Action button label |
| `actionHref` | `?string` | `null` | Action button URL |
| `highlighted` | `?bool` | `false` | Emphasize this item with background |
| `unread` | `?bool` | `false` | Show unread indicator |
| `type` | `?string` | `null` | Semantic type for custom styling |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Social Feed

```twig
<twig:bs:activity-feed maxHeight="500px">
    <twig:bs:activity-feed-item
        avatar="/images/avatars/sarah.jpg"
        title="Sarah Johnson"
        description="Posted a new article about web development"
        timestamp="5 minutes ago"
        :unread="true"
        actionLabel="Read More"
        actionHref="/posts/123"
    />
    
    <twig:bs:activity-feed-item
        avatar="/images/avatars/mike.jpg"
        title="Mike Chen"
        description="Liked your comment"
        timestamp="1 hour ago"
    />
    
    <twig:bs:activity-feed-item
        avatar="/images/avatars/emma.jpg"
        title="Emma Wilson"
        description="Started following you"
        timestamp="3 hours ago"
    />
</twig:bs:activity-feed>
```

### Audit Log

```twig
<twig:bs:activity-feed mode="compact" border="end">
    <twig:bs:activity-feed-item
        icon="bi-shield-check"
        iconVariant="success"
        title="Security update applied"
        description="System security patches installed successfully"
        timestamp="2024-01-15 10:30 AM"
        :metadata="['User: System', 'Level: Critical']"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-person-x"
        iconVariant="warning"
        title="User access revoked"
        description="john.doe@example.com"
        timestamp="2024-01-15 09:15 AM"
        :metadata="['Admin: Jane Smith', 'Reason: Account suspended']"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-key"
        iconVariant="info"
        title="API key generated"
        description="New API key created for production environment"
        timestamp="2024-01-15 08:00 AM"
        :metadata="['User: admin@example.com']"
    />
</twig:bs:activity-feed>
```

### Team Activity

```twig
<twig:bs:activity-feed>
    <twig:bs:activity-feed-item
        icon="bi-git"
        iconVariant="primary"
        title="Code pushed to main branch"
        description="feat: Add new authentication system"
        timestamp="15 minutes ago"
        :metadata="['Author: Mike Chen', 'Commits: 3']"
        actionLabel="View Changes"
        actionHref="/commits/abc123"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-check-circle"
        iconVariant="success"
        title="Pull request merged"
        description="Feature/dark-mode-support"
        timestamp="1 hour ago"
        :metadata="['Reviewer: Sarah Johnson']"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-bug"
        iconVariant="danger"
        title="Issue reported"
        description="Login form validation error"
        timestamp="2 hours ago"
        :metadata="['Reporter: Emma Wilson', 'Priority: High']"
        :highlighted="true"
    />
</twig:bs:activity-feed>
```

### System Events

```twig
<twig:bs:activity-feed :showIcons="false">
    <twig:bs:activity-feed-item
        title="Scheduled maintenance"
        description="System will be unavailable from 2:00 AM to 4:00 AM UTC"
        timestamp="In 2 hours"
        type="warning"
        :highlighted="true"
    />
    
    <twig:bs:activity-feed-item
        title="Backup completed"
        description="Daily backup finished successfully (125 GB)"
        timestamp="6 hours ago"
    />
    
    <twig:bs:activity-feed-item
        title="Database optimization"
        description="Query performance improved by 35%"
        timestamp="Yesterday"
    />
</twig:bs:activity-feed>
```

### Compact Mode

```twig
<twig:bs:activity-feed mode="compact" maxHeight="300px">
    <twig:bs:activity-feed-item
        icon="bi-bell"
        iconVariant="info"
        title="New notification"
        timestamp="1m ago"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-envelope"
        iconVariant="primary"
        title="New message"
        timestamp="5m ago"
    />
    
    <twig:bs:activity-feed-item
        icon="bi-star"
        iconVariant="warning"
        title="New favorite"
        timestamp="10m ago"
    />
</twig:bs:activity-feed>
```

### Clickable Items

```twig
<twig:bs:activity-feed>
    <twig:bs:activity-feed-item
        icon="bi-chat-left"
        iconVariant="primary"
        title="New comment on your post"
        description="Sarah Johnson: This is amazing!"
        timestamp="2 minutes ago"
        href="/posts/123#comment-456"
        :unread="true"
    />
</twig:bs:activity-feed>
```

## Styling

The component includes built-in styles with support for:

- **Hover effects** - Subtle background change on hover
- **Unread indicators** - Blue background tint for unread items
- **Highlighted items** - Light background for emphasized items
- **Dark mode** - Full support for Bootstrap's dark theme
- **Custom scrollbar** - Styled scrollbar when maxHeight is set
- **Responsive design** - Works on all screen sizes

### Custom Styling

```twig
<twig:bs:activity-feed class="my-custom-feed" :attr="{'data-type': 'notifications'}">
    <twig:bs:activity-feed-item
        class="priority-item"
        icon="bi-exclamation-triangle"
        iconVariant="danger"
        title="Critical alert"
        :highlighted="true"
    />
</twig:bs:activity-feed>
```

## Accessibility

The component follows accessibility best practices:

- **Semantic HTML** - Uses appropriate HTML elements
- **ARIA attributes** - Proper ARIA labels can be added via `attr`
- **Keyboard navigation** - Clickable items support keyboard interaction
- **Screen reader support** - Content is properly structured
- **Color contrast** - All variants meet WCAG AA standards

### Example with ARIA Labels

```twig
<twig:bs:activity-feed :attr="{'role': 'feed', 'aria-label': 'Recent activity'}">
    <twig:bs:activity-feed-item
        icon="bi-person-plus"
        title="New team member"
        :attr="{'role': 'article', 'aria-label': 'Activity: New team member joined'}"
    />
</twig:bs:activity-feed>
```

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  activity_feed:
    mode: 'default'             # 'default' | 'compact'
    show_timestamps: true
    show_icons: true
    border: 'start'             # null | 'start' | 'end'
    group_by_date: false
    max_height: null            # e.g., '400px'
    tag: 'div'
    class: null
    attr: {  }

  activity_feed_item:
    icon: null
    avatar: null
    icon_variant: 'primary'
    title: null
    description: null
    timestamp: null
    metadata: []
    href: null
    action_label: null
    action_href: null
    highlighted: false
    unread: false
    type: null
    class: null
    attr: {  }
```

## Integration Examples

### With Symfony Forms

```php
// Controller
public function activityLog(): Response
{
    $activities = $this->activityRepository->findRecent(20);
    
    return $this->render('activity/log.html.twig', [
        'activities' => $activities,
    ]);
}
```

```twig
{# templates/activity/log.html.twig #}
<twig:bs:activity-feed maxHeight="600px">
    {% for activity in activities %}
        <twig:bs:activity-feed-item
            icon="{{ activity.iconClass }}"
            iconVariant="{{ activity.variant }}"
            title="{{ activity.title }}"
            description="{{ activity.description }}"
            timestamp="{{ activity.createdAt|date('Y-m-d H:i') }}"
            :metadata="activity.metadata"
        />
    {% endfor %}
</twig:bs:activity-feed>
```

### With Turbo Frames

```twig
<turbo-frame id="activity-feed">
    <twig:bs:activity-feed maxHeight="500px">
        {# Activity items loaded dynamically #}
    </twig:bs:activity-feed>
</turbo-frame>
```

### With Stimulus

```html
<div data-controller="activity-feed">
    <twig:bs:activity-feed maxHeight="500px">
        {# Items with Stimulus actions #}
        <twig:bs:activity-feed-item
            data-action="click->activity-feed#markAsRead"
            data-activity-feed-id-value="123"
            :unread="true"
        />
    </twig:bs:activity-feed>
</div>
```

## Best Practices

### DO:

- ✅ Use consistent timestamp formats
- ✅ Provide meaningful icons that match content
- ✅ Keep descriptions concise and scannable
- ✅ Use `unread` indicator for new items
- ✅ Set `maxHeight` for long feeds to enable scrolling
- ✅ Use `metadata` for additional context
- ✅ Make entire items clickable with `href` when appropriate
- ✅ Use semantic `type` values for consistency

### DON'T:

- ❌ Don't overload items with too much information
- ❌ Don't forget to mark items as read after viewing
- ❌ Don't use vague titles like "Update" or "Change"
- ❌ Don't mix different timestamp formats in the same feed
- ❌ Don't forget hover states for clickable items
- ❌ Don't use too many different icon variants

## Testing

Comprehensive tests are available in `tests/Twig/Components/Extra/`:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/ActivityFeedTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/ActivityFeedItemTest.php
```

## Related Components

- [Avatar Component](avatar_component.md) - Can be used for user avatars in feed items
- [Badge Component](badge_component.md) - Can be used in metadata
- [Timeline Component](timeline_component.md) - Similar but with different visual style
- [Toast Component](toast_component.md) - For real-time activity notifications

## References

- [Bootstrap Icons](https://icons.getbootstrap.com/) - Icon library
- [Bootstrap Colors](https://getbootstrap.com/docs/5.3/customize/color/) - Variant colors
- [Activity Feeds UI Pattern](https://ui-patterns.com/patterns/activity-stream) - Design pattern

