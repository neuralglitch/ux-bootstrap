# Kanban Component

## Overview

The Kanban component provides a fully-featured drag-and-drop kanban board for task management, project boards, workflow tracking, and order status. It consists of three sub-components:

- **`bs:kanban`**: The main kanban board container
- **`bs:kanban-column`**: Individual columns (swim lanes) representing workflow stages
- **`bs:kanban-card`**: Task/item cards that can be dragged between columns

**Location:**
- PHP: `src/Twig/Components/Extra/Kanban.php`, `KanbanColumn.php`, `KanbanCard.php`
- Templates: `templates/components/extra/kanban.html.twig`, `kanban-column.html.twig`, `kanban-card.html.twig`
- Controller: `assets/controllers/bs_kanban_controller.js`
- Styles: `assets/styles/_kanban.scss`

**Features:**
- ✅ Drag-and-drop functionality with Stimulus
- ✅ Responsive layout (stacks on mobile)
- ✅ WIP (Work In Progress) limits per column
- ✅ Priority indicators (low, medium, high, urgent)
- ✅ Collapsible columns
- ✅ Card counts per column
- ✅ Customizable styling (variants, borders, shadows)
- ✅ Horizontal and vertical layouts
- ✅ Compact mode for dense boards
- ✅ Clickable cards with links
- ✅ Avatar and metadata support

## Basic Usage

### Simple Kanban Board

```twig
<twig:bs:kanban>
  
  {# To Do Column #}
  <twig:bs:kanban-column 
    title="To Do" 
    column_key="todo"
    variant="secondary">
    
    <twig:bs:kanban-card 
      title="Design homepage"
      description="Create mockups for the new landing page"
      priority="high"
      badge="Design"
      badge_variant="info"
      footer_text="Due: Tomorrow" />
    
    <twig:bs:kanban-card 
      title="Fix login bug"
      priority="urgent"
      badge="Bug"
      badge_variant="danger" />
      
  </twig:bs:kanban-column>
  
  {# In Progress Column #}
  <twig:bs:kanban-column 
    title="In Progress" 
    column_key="in_progress"
    variant="primary"
    :limit="3">
    
    <twig:bs:kanban-card 
      title="Implement API endpoints"
      avatar_src="/avatars/john.jpg"
      avatar_alt="John Doe"
      priority="high"
      footer_text="Started 2h ago" />
      
  </twig:bs:kanban-column>
  
  {# Done Column #}
  <twig:bs:kanban-column 
    title="Done" 
    column_key="done"
    variant="success">
    
    <twig:bs:kanban-card 
      title="Setup CI/CD pipeline"
      priority="medium"
      footer_text="Completed today" />
      
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### With Custom Icons

```twig
<twig:bs:kanban>
  
  <twig:bs:kanban-column 
    title="Backlog" 
    icon="📋"
    variant="secondary">
    {# Cards... #}
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column 
    title="In Progress" 
    icon="🚀"
    variant="primary">
    {# Cards... #}
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column 
    title="Review" 
    icon="👀"
    variant="warning">
    {# Cards... #}
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column 
    title="Completed" 
    icon="✅"
    variant="success">
    {# Cards... #}
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

## Component Props

### Kanban (Main Container)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'horizontal'` | Layout variant: `'horizontal'`, `'vertical'`, `'compact'` |
| `scrollable` | bool | `true` | Enable horizontal/vertical scrolling |
| `height` | string\|null | `null` | Fixed height (CSS value, e.g., `'600px'`, `'80vh'`) |
| `draggable` | bool | `true` | Enable drag-and-drop functionality |
| `allow_cross_column` | bool | `true` | Allow dragging cards between columns |
| `drop_zone_class` | string\|null | `null` | Custom CSS class for drop zones |
| `container` | string | `'container-fluid'` | Bootstrap container class |
| `responsive` | bool | `true` | Stack columns on mobile |
| `mobile_breakpoint` | string | `'md'` | Breakpoint for stacking: `'sm'`, `'md'`, `'lg'`, `'xl'`, `'xxl'` |
| `card_wrapper` | bool | `false` | Wrap entire kanban in a Bootstrap card |
| `gap` | string | `'3'` | Gap between columns (Bootstrap spacing: 0-5) |
| `show_column_count` | bool | `true` | Show card count in column headers |
| `compact_mode` | bool | `false` | More compact card layout |
| `stimulus_controller` | string | `'bs-kanban'` | Stimulus controller name |
| `class` | string\|null | `null` | Additional CSS classes |
| `attr` | array | `[]` | Additional HTML attributes |

### Kanban Column

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | `'Column'` | Column header title |
| `description` | string\|null | `null` | Optional description below title |
| `limit` | int\|null | `null` | Maximum cards (WIP limit) |
| `icon` | string\|null | `null` | Icon HTML (emoji or SVG) |
| `variant` | string\|null | `null` | Color variant: `'primary'`, `'success'`, `'danger'`, etc. |
| `bg` | string\|null | `null` | Background color variant |
| `shadow` | bool | `false` | Add shadow effect |
| `border` | bool | `true` | Show border |
| `collapsed` | bool | `false` | Initial collapsed state |
| `collapsible` | bool | `false` | Allow user to collapse/expand |
| `disabled` | bool | `false` | Disable dropping cards |
| `show_count` | bool | `true` | Show card count in header |
| `show_add_button` | bool | `true` | Show "Add card" button in footer |
| `add_button_label` | string\|null | `null` | Custom label for add button |
| `id` | string\|null | `null` | HTML ID (auto-generated if not provided) |
| `column_key` | string\|null | `null` | Unique identifier for this column |
| `class` | string\|null | `null` | Additional CSS classes |
| `attr` | array | `[]` | Additional HTML attributes |

### Kanban Card

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string\|null | `null` | Card title |
| `description` | string\|null | `null` | Card description |
| `label` | string\|null | `null` | Simple label (fallback if no title/description) |
| `badge` | string\|null | `null` | Badge text (e.g., "Bug", "Feature") |
| `badge_variant` | string | `'secondary'` | Badge color variant |
| `avatar_src` | string\|null | `null` | Assigned user avatar URL |
| `avatar_alt` | string\|null | `null` | Avatar alt text |
| `footer_text` | string\|null | `null` | Footer metadata (due date, timestamp) |
| `icon` | string\|null | `null` | Icon HTML in card header |
| `variant` | string\|null | `null` | Border color variant |
| `shadow` | bool | `true` | Add shadow effect |
| `hover_effect` | bool | `true` | Lift card on hover |
| `clickable` | bool | `false` | Make entire card clickable |
| `href` | string\|null | `null` | Link destination (auto-enables `clickable`) |
| `show_drag_handle` | bool | `true` | Show drag handle icon |
| `draggable` | bool | `true` | Enable dragging |
| `priority` | string\|null | `null` | Priority: `'low'`, `'medium'`, `'high'`, `'urgent'` |
| `status` | string\|null | `null` | Custom status indicator |
| `id` | string\|null | `null` | HTML ID (auto-generated if not provided) |
| `card_id` | string\|null | `null` | Business/data ID for the card |
| `class` | string\|null | `null` | Additional CSS classes |
| `attr` | array | `[]` | Additional HTML attributes |

## Examples

### Task Management Board

```twig
<twig:bs:kanban height="700px">
  
  <twig:bs:kanban-column title="Backlog" column_key="backlog" icon="📝">
    <twig:bs:kanban-card 
      title="Add dark mode toggle"
      description="Implement theme switching functionality"
      badge="Feature"
      badge_variant="primary"
      priority="medium"
      card_id="TASK-001" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="To Do" column_key="todo" icon="📋" variant="info">
    <twig:bs:kanban-card 
      title="Fix responsive issues"
      badge="Bug"
      badge_variant="danger"
      priority="high"
      footer_text="Due: Today"
      card_id="TASK-002" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column 
    title="In Progress" 
    column_key="in_progress" 
    icon="🚀" 
    variant="primary"
    :limit="3"
    description="Max 3 tasks at once">
    
    <twig:bs:kanban-card 
      title="Implement user authentication"
      avatar_src="/avatars/jane.jpg"
      avatar_alt="Jane Smith"
      priority="urgent"
      footer_text="Started 1h ago"
      card_id="TASK-003" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Review" column_key="review" icon="👀" variant="warning">
    <twig:bs:kanban-card 
      title="API documentation"
      avatar_src="/avatars/john.jpg"
      badge="Docs"
      badge_variant="info"
      footer_text="Ready for review"
      card_id="TASK-004" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Done" column_key="done" icon="✅" variant="success">
    <twig:bs:kanban-card 
      title="Setup CI/CD pipeline"
      priority="medium"
      footer_text="Completed yesterday"
      card_id="TASK-005" />
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### Order Status Tracking

```twig
<twig:bs:kanban container="container">
  
  <twig:bs:kanban-column title="Received" column_key="received" variant="secondary">
    <twig:bs:kanban-card 
      title="Order #12345"
      description="2x Blue T-Shirts"
      badge="Standard Shipping"
      footer_text="Ordered: 2 days ago"
      card_id="ORDER-12345" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Processing" column_key="processing" variant="info">
    <twig:bs:kanban-card 
      title="Order #12344"
      description="1x Coffee Maker"
      badge="Express Shipping"
      badge_variant="warning"
      footer_text="Processing..."
      card_id="ORDER-12344" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Shipped" column_key="shipped" variant="primary">
    <twig:bs:kanban-card 
      title="Order #12343"
      description="3x Books"
      footer_text="Tracking: ABC123XYZ"
      href="/orders/12343"
      card_id="ORDER-12343" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Delivered" column_key="delivered" variant="success">
    <twig:bs:kanban-card 
      title="Order #12342"
      description="1x Laptop Stand"
      footer_text="Delivered: Today"
      card_id="ORDER-12342" />
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### Compact Mode

```twig
<twig:bs:kanban :compact_mode="true" gap="2">
  
  <twig:bs:kanban-column title="To Do" column_key="todo">
    <twig:bs:kanban-card label="Task 1" priority="high" />
    <twig:bs:kanban-card label="Task 2" priority="medium" />
    <twig:bs:kanban-card label="Task 3" priority="low" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Doing" column_key="doing">
    <twig:bs:kanban-card label="Task 4" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Done" column_key="done">
    <twig:bs:kanban-card label="Task 5" />
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### Collapsible Columns

```twig
<twig:bs:kanban>
  
  <twig:bs:kanban-column 
    title="Archive" 
    column_key="archive"
    :collapsible="true"
    :collapsed="true">
    <twig:bs:kanban-card title="Old Task 1" />
    <twig:bs:kanban-card title="Old Task 2" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Active" column_key="active">
    <twig:bs:kanban-card title="Current Task" />
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### Clickable Cards with Links

```twig
<twig:bs:kanban>
  
  <twig:bs:kanban-column title="Projects" column_key="projects">
    
    <twig:bs:kanban-card 
      title="Website Redesign"
      description="Complete redesign of company website"
      href="/projects/website-redesign"
      badge="In Progress"
      badge_variant="primary"
      priority="high" />
    
    <twig:bs:kanban-card 
      title="Mobile App"
      description="iOS and Android app development"
      href="/projects/mobile-app"
      badge="Planning"
      priority="medium" />
    
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

### Vertical Layout

```twig
<twig:bs:kanban variant="vertical">
  
  <twig:bs:kanban-column title="Stage 1" column_key="stage1">
    <twig:bs:kanban-card title="Item A" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Stage 2" column_key="stage2">
    <twig:bs:kanban-card title="Item B" />
  </twig:bs:kanban-column>
  
  <twig:bs:kanban-column title="Stage 3" column_key="stage3">
    <twig:bs:kanban-card title="Item C" />
  </twig:bs:kanban-column>
  
</twig:bs:kanban>
```

## Accessibility

The kanban component includes several accessibility features:

- **ARIA Labels**: Proper labeling for screen readers
- **Keyboard Navigation**: Cards can be focused and activated with keyboard
- **Semantic HTML**: Uses appropriate HTML5 elements
- **Drag Handles**: Visual indicators for draggable items
- **Focus Management**: Clear focus states for interactive elements

## Drag and Drop

### Events

The Stimulus controller dispatches custom events you can listen to:

```javascript
// Card moved event
document.querySelector('[data-controller="bs-kanban"]')
  .addEventListener('kanban:card-moved', (event) => {
    console.log('Card moved:', event.detail.cardId);
    console.log('To column:', event.detail.targetColumn);
    
    // Make AJAX call to update backend
    fetch('/api/tasks/move', {
      method: 'POST',
      body: JSON.stringify({
        cardId: event.detail.cardId,
        targetColumn: event.detail.targetColumn
      })
    });
  });

// Add card event
document.querySelector('[data-controller="bs-kanban"]')
  .addEventListener('kanban:add-card', (event) => {
    console.log('Add card to column:', event.detail.column);
    
    // Show modal or form to create new card
    showCreateCardModal(event.detail.column);
  });
```

### Disabling Drag and Drop

```twig
{# Disable all dragging #}
<twig:bs:kanban :draggable="false">
  {# ... #}
</twig:bs:kanban>

{# Disable dragging for specific card #}
<twig:bs:kanban-card title="Locked Task" :draggable="false" />

{# Disable dropping in specific column #}
<twig:bs:kanban-column title="Read Only" :disabled="true">
  {# ... #}
</twig:bs:kanban-column>
```

## Configuration

Default settings can be configured in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  kanban:
    variant: 'horizontal'
    scrollable: true
    draggable: true
    allow_cross_column: true
    responsive: true
    mobile_breakpoint: 'md'
    gap: '3'
    show_column_count: true
    compact_mode: false
    
  kanban_column:
    border: true
    show_count: true
    show_add_button: true
    
  kanban_card:
    shadow: true
    hover_effect: true
    show_drag_handle: true
    draggable: true
    badge_variant: 'secondary'
```

## Testing

```php
public function testKanbanRendering(): void
{
    $component = new Kanban($this->config);
    $component->draggable = true;
    $component->mount();
    $options = $component->options();

    $this->assertStringContainsString('kanban-board', $options['classes']);
    $this->assertSame('bs-kanban', $options['attrs']['data-controller']);
}
```

## Related Components

- **Card**: For individual content cards
- **ListGroup**: For list-based layouts
- **Accordion**: For collapsible content sections
- **Timeline**: For chronological event display

## References

- [Trello](https://trello.com/) - Original kanban board inspiration
- [Jira](https://www.atlassian.com/software/jira) - Agile project management
- [Monday.com](https://monday.com/) - Work management platform
- [Drag and Drop API](https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API)

