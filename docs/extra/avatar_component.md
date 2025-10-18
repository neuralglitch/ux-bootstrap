# Avatar Component

## Overview

The Avatar component displays user profile pictures or initials with various sizes, shapes, and styling options. It's perfect for user menus, comment sections, team lists, and chat interfaces.

**Component Type**: Extra Component  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Tag**: `<twig:bs:avatar />`  
**Template**: `templates/components/extra/avatar.html.twig`

## Features

- ✅ Image avatars with fallback to initials
- ✅ Multiple size options (xs, sm, md, lg, xl, xxl, or custom)
- ✅ Three shape variants (circle, square, rounded)
- ✅ Status indicators (online, offline, away, busy)
- ✅ Border customization
- ✅ Color variants for initials
- ✅ Clickable avatars (link support)
- ✅ Accessible markup
- ✅ Custom content support

## Basic Usage

### Image Avatar

```twig
<twig:bs:avatar 
    src="/path/to/avatar.jpg" 
    alt="John Doe" 
/>
```

### Initials Avatar

```twig
<twig:bs:avatar 
    initials="JD" 
    variant="primary" 
/>
```

### Avatar with Status

```twig
<twig:bs:avatar 
    src="/path/to/avatar.jpg" 
    alt="John Doe"
    status="online" 
/>
```

### Clickable Avatar

```twig
<twig:bs:avatar 
    src="/path/to/avatar.jpg" 
    alt="John Doe"
    href="/profile" 
/>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | `?string` | `null` | Image source URL |
| `alt` | `?string` | `null` | Image alt text (auto-generated from initials if not provided) |
| `initials` | `?string` | `null` | Fallback initials (e.g., "JD", "AB") |
| `size` | `string` | `'md'` | Size: `'xs'`, `'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'`, or custom (e.g., `'64px'`, `'3rem'`) |
| `shape` | `string` | `'circle'` | Shape: `'circle'`, `'square'`, `'rounded'` |
| `status` | `?string` | `null` | Status indicator: `null`, `'online'`, `'offline'`, `'away'`, `'busy'` |
| `border` | `bool` | `false` | Show border around avatar |
| `borderColor` | `?string` | `null` | Border color variant (e.g., `'primary'`, `'success'`) |
| `variant` | `?string` | `null` | Background variant for initials (e.g., `'primary'`, `'success'`, `'danger'`) |
| `href` | `?string` | `null` | URL to link to (makes avatar clickable) |
| `target` | `?string` | `null` | Link target (`'_blank'`, `'_self'`, etc.) |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Size Variants

```twig
{# Extra Small #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="xs" />

{# Small #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="sm" />

{# Medium (default) #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="md" />

{# Large #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="lg" />

{# Extra Large #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="xl" />

{# Extra Extra Large #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="xxl" />

{# Custom Size #}
<twig:bs:avatar src="/avatar.jpg" alt="User" size="64px" />
<twig:bs:avatar src="/avatar.jpg" alt="User" size="5rem" />
```

### Shape Variants

```twig
{# Circle (default) #}
<twig:bs:avatar src="/avatar.jpg" alt="User" shape="circle" />

{# Square #}
<twig:bs:avatar src="/avatar.jpg" alt="User" shape="square" />

{# Rounded #}
<twig:bs:avatar src="/avatar.jpg" alt="User" shape="rounded" />
```

### Initials with Variants

```twig
{# Primary #}
<twig:bs:avatar initials="JD" variant="primary" />

{# Success #}
<twig:bs:avatar initials="AB" variant="success" />

{# Danger #}
<twig:bs:avatar initials="CD" variant="danger" />

{# Warning #}
<twig:bs:avatar initials="EF" variant="warning" />

{# Info #}
<twig:bs:avatar initials="GH" variant="info" />

{# Dark #}
<twig:bs:avatar initials="IJ" variant="dark" />
```

### Status Indicators

```twig
{# Online #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    status="online" 
/>

{# Offline #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    status="offline" 
/>

{# Away #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    status="away" 
/>

{# Busy #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    status="busy" 
/>
```

### Borders

```twig
{# Simple border #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    :border="true" 
/>

{# Colored border #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    :border="true"
    borderColor="primary" 
/>

{# Success border #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    :border="true"
    borderColor="success" 
/>
```

### Clickable Avatars

```twig
{# Simple link #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    href="/profile" 
/>

{# Open in new tab #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    href="/profile"
    target="_blank" 
/>
```

### Custom Content

```twig
{# Custom icon or emoji #}
<twig:bs:avatar variant="primary" size="lg">
    <i class="bi bi-person-fill"></i>
</twig:bs:avatar>

{# Emoji #}
<twig:bs:avatar variant="warning" size="md">
    😀
</twig:bs:avatar>
```

## Real-World Examples

### User Menu

```twig
<div class="dropdown">
    <button class="btn btn-link p-0" 
            type="button" 
            data-bs-toggle="dropdown">
        <twig:bs:avatar 
            src="{{ user.avatarUrl }}" 
            alt="{{ user.name }}"
            size="sm"
            status="online" 
        />
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="/profile">Profile</a></li>
        <li><a class="dropdown-item" href="/settings">Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/logout">Logout</a></li>
    </ul>
</div>
```

### Comment Section

```twig
<div class="d-flex gap-3">
    <twig:bs:avatar 
        src="{{ comment.author.avatarUrl }}" 
        alt="{{ comment.author.name }}"
        size="md"
        href="/user/{{ comment.author.id }}" 
    />
    <div class="flex-grow-1">
        <h6 class="mb-1">{{ comment.author.name }}</h6>
        <p class="text-muted small mb-2">{{ comment.createdAt|date('F j, Y') }}</p>
        <p>{{ comment.text }}</p>
    </div>
</div>
```

### Team List

```twig
<div class="row g-4">
    {% for member in team.members %}
        <div class="col-6 col-md-4 col-lg-3">
            <div class="text-center">
                <twig:bs:avatar 
                    src="{{ member.avatarUrl }}" 
                    alt="{{ member.name }}"
                    size="xl"
                    :border="true"
                    borderColor="primary"
                    class="mb-3" 
                />
                <h6 class="mb-1">{{ member.name }}</h6>
                <p class="text-muted small">{{ member.role }}</p>
            </div>
        </div>
    {% endfor %}
</div>
```

### Chat Interface

```twig
<div class="chat-messages">
    {% for message in messages %}
        <div class="d-flex gap-2 mb-3">
            <twig:bs:avatar 
                src="{{ message.user.avatarUrl }}" 
                alt="{{ message.user.name }}"
                size="sm"
                status="{{ message.user.isOnline ? 'online' : 'offline' }}" 
            />
            <div class="flex-grow-1">
                <div class="bg-light rounded p-2">
                    <strong>{{ message.user.name }}</strong>
                    <p class="mb-0">{{ message.text }}</p>
                </div>
                <small class="text-muted">{{ message.timestamp|date('g:i A') }}</small>
            </div>
        </div>
    {% endfor %}
</div>
```

### Avatar Group (Stacked)

```twig
<div class="avatar-group">
    <twig:bs:avatar src="/avatar1.jpg" alt="User 1" size="sm" :border="true" />
    <twig:bs:avatar src="/avatar2.jpg" alt="User 2" size="sm" :border="true" />
    <twig:bs:avatar src="/avatar3.jpg" alt="User 3" size="sm" :border="true" />
    <twig:bs:avatar initials="+5" variant="secondary" size="sm" :border="true" />
</div>
```

### Avatar with Badge

```twig
<div class="position-relative d-inline-block">
    <twig:bs:avatar 
        src="/avatar.jpg" 
        alt="User"
        size="lg" 
    />
    <twig:bs:badge 
        variant="danger"
        :pill="true"
        :positioned="true"
        position="top-0 start-100"
        :translate="true">
        3
    </twig:bs:badge>
</div>
```

## Accessibility

The Avatar component follows accessibility best practices:

- **Alt Text**: Always provide meaningful alt text for images
- **Initials Fallback**: Automatically uses initials as alt text if no alt is provided
- **Status Labels**: Status indicators include `aria-label` for screen readers
- **Semantic HTML**: Uses appropriate tags (`<div>` or `<a>`) based on context
- **Keyboard Navigation**: Clickable avatars are fully keyboard accessible

### Best Practices

```twig
{# ✅ Good: Descriptive alt text #}
<twig:bs:avatar src="/avatar.jpg" alt="John Doe, Software Engineer" />

{# ✅ Good: Initials with auto-generated alt #}
<twig:bs:avatar initials="JD" variant="primary" />

{# ❌ Bad: Missing alt text #}
<twig:bs:avatar src="/avatar.jpg" />

{# ✅ Good: Link with proper target attributes #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="John Doe"
    href="/profile"
    target="_blank" 
/>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  avatar:
    size: 'md'                  # 'xs' | 'sm' | 'md' | 'lg' | 'xl' | 'xxl' or custom
    shape: 'circle'             # 'circle' | 'square' | 'rounded'
    status: null                # null | 'online' | 'offline' | 'away' | 'busy'
    border: false               # Show border
    border_color: null          # Border color variant
    variant: null               # Background variant for initials
    class: null
    attr: {  }
```

### Custom Configuration Example

```yaml
neuralglitch_ux_bootstrap:
  avatar:
    size: 'lg'                  # Larger default size
    shape: 'rounded'            # Rounded corners instead of circle
    border: true                # Always show border
    border_color: 'primary'     # Primary color border
    variant: 'primary'          # Primary background for initials
    class: 'shadow-sm'          # Add subtle shadow
```

## Styling

The Avatar component includes comprehensive CSS in `assets/styles/_avatar.scss`:

### Size Classes

- `.avatar-xs` - Extra small (1.5rem / 24px)
- `.avatar-sm` - Small (2rem / 32px)
- `.avatar-md` - Medium (2.5rem / 40px) - Default
- `.avatar-lg` - Large (3.5rem / 56px)
- `.avatar-xl` - Extra large (5rem / 80px)
- `.avatar-xxl` - Extra extra large (7rem / 112px)

### Modifier Classes

- `.avatar-border` - Adds border
- `.avatar-link` - Adds link styling with hover effect
- `.rounded-circle` - Circle shape
- `.rounded-0` - Square shape
- `.rounded` - Rounded corners

### Status Classes

- `.avatar-status` - Base status indicator
- `.avatar-status-online` - Green indicator
- `.avatar-status-offline` - Gray indicator
- `.avatar-status-away` - Yellow/orange indicator
- `.avatar-status-busy` - Red indicator

### Avatar Group

The CSS includes support for avatar groups (stacked avatars):

```scss
.avatar-group {
  display: inline-flex;
  align-items: center;
  
  .avatar {
    margin-left: -0.5rem;
    border: 2px solid var(--bs-body-bg);
    
    &:first-child {
      margin-left: 0;
    }
    
    &:hover {
      z-index: 1;
    }
  }
}
```

## Testing

The Avatar component has comprehensive test coverage (37 tests):

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/AvatarTest.php
```

### Key Test Cases

- ✅ Default options
- ✅ Image avatars
- ✅ Initials avatars
- ✅ All size variants (xs, sm, md, lg, xl, xxl)
- ✅ Custom sizes (pixels and rem)
- ✅ Shape variants (circle, square, rounded)
- ✅ Status indicators (online, offline, away, busy)
- ✅ Border with and without colors
- ✅ Variant colors for initials
- ✅ Clickable avatars (href, target)
- ✅ Custom classes and attributes
- ✅ Configuration defaults

## Related Components

- **Badge** - For notification indicators on avatars
- **Dropdown** - For user menu dropdowns
- **Button** - For clickable avatar buttons
- **Card** - For profile cards with avatars

## Browser Support

The Avatar component works in all modern browsers:

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers

## Performance

- **Lazy Loading**: Consider using `loading="lazy"` for images
- **Image Optimization**: Use optimized images (WebP, proper dimensions)
- **CSS Custom Properties**: Uses Bootstrap CSS variables for theming
- **No JavaScript**: Pure CSS implementation (no JavaScript overhead)

### Performance Example

```twig
{# Lazy load images #}
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    :attr="{'loading': 'lazy'}" 
/>

{# Optimized image size #}
<twig:bs:avatar 
    src="/avatar-64x64.webp" 
    alt="User"
    size="md" 
/>
```

## Migration from Other Libraries

### From Bootstrap Avatar

```html
<!-- Bootstrap HTML -->
<img src="/avatar.jpg" class="rounded-circle" width="40" height="40" alt="User">

<!-- Symfony UX Bootstrap -->
<twig:bs:avatar src="/avatar.jpg" alt="User" size="md" />
```

### From Custom Avatar Implementation

```html
<!-- Custom HTML -->
<div class="avatar avatar-md">
    <img src="/avatar.jpg" alt="User">
    <span class="status status-online"></span>
</div>

<!-- Symfony UX Bootstrap -->
<twig:bs:avatar 
    src="/avatar.jpg" 
    alt="User"
    size="md"
    status="online" 
/>
```

## References

- [Bootstrap Documentation](https://getbootstrap.com/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [WCAG 2.1 Accessibility Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [MDN Web Docs - Images](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/img)

