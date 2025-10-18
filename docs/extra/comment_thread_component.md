# Comment Thread Component

## Overview

The Comment Thread component (`bs:comment-thread`) provides a rich, feature-complete solution for displaying nested, threaded comments with replies. It supports multiple nesting levels, user avatars, action buttons (like, reply, edit, delete), flexible date formatting, and comprehensive styling options.

**Namespace:** `Extra` (Custom component)  
**Tag:** `<twig:bs:comment-thread>`  
**Component Class:** `NeuralGlitch\UxBootstrap\Twig\Components\Extra\CommentThread`  
**Template:** `templates/components/extra/comment-thread.html.twig`

## Basic Usage

### Simple Comment Thread

```twig
<twig:bs:comment-thread :comments="comments" />
```

### With Configuration

```twig
<twig:bs:comment-thread
    :comments="comments"
    :maxDepth="3"
    avatarSize="lg"
    dateFormat="relative"
    :highlightAuthor="true"
    authorUsername="john_doe"
/>
```

### Compact Mode

```twig
<twig:bs:comment-thread
    :comments="comments"
    :compact="true"
    :showThreadLines="false"
/>
```

## Comment Data Structure

Each comment in the `comments` array should have the following structure:

```php
$comments = [
    [
        'id' => 1,
        'author' => 'John Doe',
        'username' => 'john_doe',        // Optional, used for author highlighting
        'avatar' => '/path/to/avatar.jpg', // Optional, displays placeholder if not provided
        'content' => '<p>This is a comment</p>',
        'timestamp' => '2024-01-15 10:30:00', // or DateTime object
        'likes' => 5,                     // Optional
        'edited' => true,                 // Optional
        'can_edit' => true,               // Optional, controls edit button visibility
        'can_delete' => true,             // Optional, controls delete button visibility
        'badges' => [                     // Optional
            [
                'label' => 'Moderator',
                'class' => 'bg-success',
            ],
        ],
        'replies' => [                    // Nested replies
            [
                'id' => 2,
                'author' => 'Jane Smith',
                'content' => '<p>Reply to John</p>',
                'timestamp' => '2024-01-15 10:45:00',
                // ... same structure as parent
            ],
        ],
    ],
];
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `comments` | `array` | `[]` | Array of comment data structures |
| `maxDepth` | `int` | `3` | Maximum nesting depth for replies (0 = unlimited) |
| `showReply` | `bool` | `true` | Show reply button |
| `showEdit` | `bool` | `true` | Show edit button (requires `can_edit` in comment data) |
| `showDelete` | `bool` | `true` | Show delete button (requires `can_delete` in comment data) |
| `showLike` | `bool` | `true` | Show like/upvote button |
| `dateFormat` | `string` | `'relative'` | Date format: `'relative'`, `'absolute'`, or `'both'` |
| `avatarSize` | `string` | `'md'` | Avatar size: `'sm'`, `'md'`, `'lg'`, `'xl'` |
| `highlightAuthor` | `bool` | `false` | Highlight comments from specific author |
| `authorUsername` | `?string` | `null` | Username to highlight (requires `highlightAuthor=true`) |
| `compact` | `bool` | `false` | Compact mode with reduced spacing |
| `showThreadLines` | `bool` | `true` | Show lines connecting nested replies |
| `collapsible` | `bool` | `true` | Enable collapsible reply threads |
| `defaultCollapsed` | `bool` | `false` | Default collapsed state for threads |
| `containerClass` | `?string` | `null` | Additional CSS class for container |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Basic Comment Thread

```twig
{% set comments = [
    {
        'id': 1,
        'author': 'Alice Johnson',
        'avatar': '/avatars/alice.jpg',
        'content': '<p>This is a great article! Thanks for sharing.</p>',
        'timestamp': '2024-01-15 09:00:00',
        'likes': 12,
    },
    {
        'id': 2,
        'author': 'Bob Smith',
        'content': '<p>I agree with Alice, very informative.</p>',
        'timestamp': '2024-01-15 09:30:00',
        'likes': 5,
    },
] %}

<twig:bs:comment-thread :comments="comments" />
```

### Nested Replies

```twig
{% set comments = [
    {
        'id': 1,
        'author': 'Alice Johnson',
        'content': '<p>What do you think about this approach?</p>',
        'timestamp': '2024-01-15 09:00:00',
        'replies': [
            {
                'id': 2,
                'author': 'Bob Smith',
                'content': '<p>I think it\'s a great approach!</p>',
                'timestamp': '2024-01-15 09:15:00',
                'replies': [
                    {
                        'id': 3,
                        'author': 'Alice Johnson',
                        'content': '<p>Thanks for the feedback!</p>',
                        'timestamp': '2024-01-15 09:20:00',
                    },
                ],
            },
        ],
    },
] %}

<twig:bs:comment-thread :comments="comments" />
```

### With Author Highlighting

```twig
<twig:bs:comment-thread
    :comments="comments"
    :highlightAuthor="true"
    authorUsername="alice_j"
/>
```

### Compact Mode with Custom Styling

```twig
<twig:bs:comment-thread
    :comments="comments"
    :compact="true"
    :showThreadLines="false"
    avatarSize="sm"
    class="border rounded p-3"
/>
```

### Limited Nesting Depth

```twig
{# Only allow 2 levels of replies #}
<twig:bs:comment-thread
    :comments="comments"
    :maxDepth="2"
/>
```

### Absolute Date Format

```twig
<twig:bs:comment-thread
    :comments="comments"
    dateFormat="absolute"
/>
```

### With Custom Actions

```twig
{% set comments = [
    {
        'id': 1,
        'author': 'Alice Johnson',
        'content': '<p>Check out this feature!</p>',
        'timestamp': '2024-01-15 09:00:00',
        'can_edit': true,
        'can_delete': true,
        'custom_actions': '<button class="btn btn-link btn-sm"><i class="bi bi-flag"></i> Report</button>',
    },
] %}

<twig:bs:comment-thread :comments="comments" />
```

### With User Badges

```twig
{% set comments = [
    {
        'id': 1,
        'author': 'Alice Johnson',
        'username': 'alice_j',
        'content': '<p>Official announcement from the team.</p>',
        'timestamp': '2024-01-15 09:00:00',
        'badges': [
            {
                'label': 'Admin',
                'class': 'bg-danger',
            },
            {
                'label': 'Verified',
                'class': 'bg-primary',
            },
        ],
    },
] %}

<twig:bs:comment-thread
    :comments="comments"
    :highlightAuthor="true"
    authorUsername="alice_j"
/>
```

### Collapsible Threads

```twig
<twig:bs:comment-thread
    :comments="comments"
    :collapsible="true"
    :defaultCollapsed="true"
/>
```

### Large Avatars with Custom Container

```twig
<twig:bs:comment-thread
    :comments="comments"
    avatarSize="xl"
    containerClass="bg-light"
    class="p-4 rounded"
/>
```

## Date Formatting

The component supports three date format modes:

### Relative Format (Default)

Displays human-readable relative time:
- "just now"
- "5 minutes ago"
- "2 hours ago"
- "3 days ago"
- "1 month ago"
- "2 years ago"

```twig
<twig:bs:comment-thread
    :comments="comments"
    dateFormat="relative"
/>
```

### Absolute Format

Displays full date and time:
- "Jan 15, 2024 9:30 AM"

```twig
<twig:bs:comment-thread
    :comments="comments"
    dateFormat="absolute"
/>
```

### Both Formats

Displays both relative and absolute:
- "2 hours ago (Jan 15, 2024)"

```twig
<twig:bs:comment-thread
    :comments="comments"
    dateFormat="both"
/>
```

## Action Buttons

The component provides several action buttons that can be toggled on/off:

### Like Button

Shows a heart icon with optional like count:

```twig
<twig:bs:comment-thread
    :comments="comments"
    :showLike="true"
/>
```

### Reply Button

Opens a reply form when clicked:

```twig
<twig:bs:comment-thread
    :comments="comments"
    :showReply="true"
/>
```

### Edit Button

Only shown if `can_edit` is `true` in comment data:

```twig
<twig:bs:comment-thread
    :comments="comments"
    :showEdit="true"
/>
```

### Delete Button

Only shown if `can_delete` is `true` in comment data:

```twig
<twig:bs:comment-thread
    :comments="comments"
    :showDelete="true"
/>
```

### Disable All Actions

```twig
<twig:bs:comment-thread
    :comments="comments"
    :showLike="false"
    :showReply="false"
    :showEdit="false"
    :showDelete="false"
/>
```

## Styling

### Thread Lines

Visual lines connecting nested comments:

```twig
{# With thread lines (default) #}
<twig:bs:comment-thread
    :comments="comments"
    :showThreadLines="true"
/>

{# Without thread lines #}
<twig:bs:comment-thread
    :comments="comments"
    :showThreadLines="false"
/>
```

### Compact Mode

Reduces spacing for denser layouts:

```twig
<twig:bs:comment-thread
    :comments="comments"
    :compact="true"
/>
```

### Avatar Sizes

Four size options:

```twig
{# Small avatars #}
<twig:bs:comment-thread :comments="comments" avatarSize="sm" />

{# Medium avatars (default) #}
<twig:bs:comment-thread :comments="comments" avatarSize="md" />

{# Large avatars #}
<twig:bs:comment-thread :comments="comments" avatarSize="lg" />

{# Extra large avatars #}
<twig:bs:comment-thread :comments="comments" avatarSize="xl" />
```

### Custom CSS

```twig
<twig:bs:comment-thread
    :comments="comments"
    class="border border-primary rounded shadow-sm p-4"
    :attr="{'data-controller': 'comments'}"
/>
```

## Empty State

When no comments are provided, the component displays a friendly empty state:

```twig
<twig:bs:comment-thread :comments="[]" />
```

Output:
```
┌─────────────────────────────────────┐
│           💬                        │
│   No comments yet. Be the first    │
│      to comment!                    │
└─────────────────────────────────────┘
```

## Accessibility

The component follows accessibility best practices:

- **Semantic HTML**: Uses proper heading hierarchy and semantic elements
- **ARIA Attributes**: Includes `aria-label`, `aria-expanded`, `aria-controls`
- **Keyboard Navigation**: All interactive elements are keyboard accessible
- **Screen Reader Support**: Action buttons include descriptive text for screen readers
- **Color Contrast**: Meets WCAG AA standards for text contrast
- **Focus Management**: Visible focus indicators on all interactive elements

### ARIA Enhancements

```twig
<twig:bs:comment-thread
    :comments="comments"
    :attr="{
        'role': 'list',
        'aria-label': 'User comments',
    }"
/>
```

## Configuration

Default configuration in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  comment_thread:
    max_depth: 3
    show_reply: true
    show_edit: true
    show_delete: true
    show_like: true
    date_format: 'relative'
    avatar_size: 'md'
    highlight_author: false
    compact: false
    show_thread_lines: true
    collapsible: true
    default_collapsed: false
    container_class: null
    class: null
    attr: {  }
```

### Override Defaults

```yaml
neuralglitch_ux_bootstrap:
  comment_thread:
    max_depth: 5
    avatar_size: 'lg'
    date_format: 'both'
    compact: true
    class: 'border rounded p-3'
```

## Integration with Backend

### Controller Example

```php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    public function show(int $id): Response
    {
        $post = $this->postRepository->find($id);
        
        $comments = $post->getComments()->map(function($comment) {
            return [
                'id' => $comment->getId(),
                'author' => $comment->getAuthor()->getName(),
                'username' => $comment->getAuthor()->getUsername(),
                'avatar' => $comment->getAuthor()->getAvatarUrl(),
                'content' => $comment->getContent(),
                'timestamp' => $comment->getCreatedAt(),
                'likes' => $comment->getLikesCount(),
                'edited' => $comment->getUpdatedAt() > $comment->getCreatedAt(),
                'can_edit' => $this->isGranted('EDIT', $comment),
                'can_delete' => $this->isGranted('DELETE', $comment),
                'replies' => $this->buildReplies($comment->getReplies()),
            ];
        })->toArray();
        
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'currentUsername' => $this->getUser()?->getUsername(),
        ]);
    }
    
    private function buildReplies($replies): array
    {
        return $replies->map(function($reply) {
            return [
                'id' => $reply->getId(),
                'author' => $reply->getAuthor()->getName(),
                'username' => $reply->getAuthor()->getUsername(),
                'content' => $reply->getContent(),
                'timestamp' => $reply->getCreatedAt(),
                // ... same structure recursively
            ];
        })->toArray();
    }
}
```

### Template Example

```twig
{# templates/post/show.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <article>
        <h1>{{ post.title }}</h1>
        <div>{{ post.content|raw }}</div>
    </article>

    <section class="mt-5">
        <h2>Comments</h2>
        
        <twig:bs:comment-thread
            :comments="comments"
            :highlightAuthor="true"
            :authorUsername="post.author.username"
            avatarSize="lg"
            dateFormat="relative"
        />
    </section>
{% endblock %}
```

## JavaScript Integration

For interactive features, you can add a Stimulus controller:

```javascript
// assets/controllers/comment_thread_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['replyForm', 'content'];

    like(event) {
        const commentId = event.currentTarget.dataset.commentId;
        // Handle like action
        fetch(`/comments/${commentId}/like`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                // Update UI
            });
    }

    reply(event) {
        const commentId = event.currentTarget.dataset.commentId;
        // Show reply form
    }

    edit(event) {
        const commentId = event.currentTarget.dataset.commentId;
        // Show edit form
    }

    delete(event) {
        if (!confirm('Are you sure you want to delete this comment?')) {
            return;
        }
        
        const commentId = event.currentTarget.dataset.commentId;
        fetch(`/comments/${commentId}`, { method: 'DELETE' })
            .then(() => {
                // Remove comment from DOM
                event.currentTarget.closest('.comment-item').remove();
            });
    }
}
```

```twig
<div data-controller="comment-thread">
    <twig:bs:comment-thread :comments="comments" />
</div>
```

## Testing

```php
use NeuralGlitch\UxBootstrap\Twig\Components\Extra\CommentThread;

final class CommentThreadTest extends TestCase
{
    public function testRenderCommentThread(): void
    {
        $comments = [
            [
                'id' => 1,
                'author' => 'John Doe',
                'content' => '<p>Test comment</p>',
                'timestamp' => '2024-01-15 10:00:00',
            ],
        ];

        $component = new CommentThread($this->config);
        $component->comments = $comments;
        $component->mount();
        $options = $component->options();

        $this->assertCount(1, $options['comments']);
        $this->assertSame('Test comment', $options['comments'][0]['content']);
    }
}
```

## Related Components

- `bs:avatar` - Avatar display component
- `bs:badge` - Badge component for user roles/status
- `bs:button` - Button component for actions
- `bs:card` - Card container for comment sections

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Opera 76+

## References

- [Bootstrap Utilities](https://getbootstrap.com/docs/5.3/utilities/api/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [Twig Components Documentation](https://symfony.com/bundles/ux-twig-component/current/index.html)

