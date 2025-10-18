# Timeline Component

## Overview

The Timeline component (`bs:timeline`) is an Extra component for displaying chronological events, activities, and milestones. It provides a flexible and customizable way to visualize sequences of events over time.

**Use Cases:**
- Order tracking and delivery status
- Activity logs and user history
- Event timelines and project history
- Project milestones and roadmaps
- Process flows and step-by-step guides

## Basic Usage

### Simple Vertical Timeline

```twig
<twig:bs:timeline>
  <twig:bs:timeline-item
    title="Order Placed"
    time="Jan 15, 2024"
    state="completed"
    icon="✓">
    Your order has been successfully placed.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Processing"
    time="Jan 16, 2024"
    state="completed"
    icon="📦">
    Order is being prepared for shipment.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Shipped"
    time="Jan 17, 2024"
    state="active"
    icon="🚚">
    Package is on its way.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Delivered"
    time="Jan 19, 2024"
    state="pending"
    icon="📍">
    Expected delivery date.
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

### Horizontal Timeline

```twig
<twig:bs:timeline variant="horizontal">
  <twig:bs:timeline-item
    title="Q1 2024"
    badge="1"
    state="completed">
    Phase 1 completed
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Q2 2024"
    badge="2"
    state="active">
    Current phase
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Q3 2024"
    badge="3"
    state="pending">
    Upcoming phase
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

## Timeline Component Props

### `bs:timeline`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'vertical'` | Layout variant: `'vertical'`, `'horizontal'`, `'alternating'`, `'compact'` |
| `align` | `string` | `'start'` | Alignment for vertical timelines: `'start'`, `'center'`, `'end'` |
| `showLine` | `bool` | `true` | Show connecting line between items |
| `lineStyle` | `string` | `'solid'` | Line style: `'solid'`, `'dashed'`, `'dotted'` |
| `lineVariant` | `string\|null` | `null` | Line color variant: `'primary'`, `'secondary'`, `'success'`, etc. |
| `size` | `string\|null` | `null` | Size variant: `null` (default), `'sm'`, `'lg'` |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

### `bs:timeline-item`

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string\|null` | `null` | Title/heading for the item |
| `description` | `string\|null` | `null` | Description text (fallback if no content block) |
| `time` | `string\|null` | `null` | Time/date label |
| `timePosition` | `string` | `'inline'` | Time position: `'inline'`, `'below'`, `'opposite'` |
| `icon` | `string\|null` | `null` | Icon HTML or emoji |
| `badge` | `string\|null` | `null` | Badge text (alternative to icon) |
| `variant` | `string\|null` | `null` | Color variant: `'primary'`, `'secondary'`, `'success'`, etc. |
| `state` | `string\|null` | `null` | State: `'pending'`, `'active'`, `'completed'` |
| `showLine` | `bool` | `true` | Show connecting line to next item |
| `markerSize` | `string\|null` | `null` | Marker size: `null` (default), `'sm'`, `'lg'` |
| `class` | `string\|null` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### Order Tracking Timeline

```twig
<twig:bs:timeline variant="vertical" align="start">
  <twig:bs:timeline-item
    title="Order Confirmed"
    time="Jan 15, 2024 - 10:30 AM"
    state="completed"
    icon="✓"
    variant="success">
    <p class="mb-0">Order #12345 has been confirmed.</p>
    <small class="text-muted">Confirmation email sent to user@example.com</small>
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Payment Received"
    time="Jan 15, 2024 - 10:31 AM"
    state="completed"
    icon="💳"
    variant="success">
    Payment of $99.99 processed successfully.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Order Processing"
    time="Jan 16, 2024 - 9:00 AM"
    state="completed"
    icon="📦"
    variant="info">
    Items are being picked and packed.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Shipped"
    time="Jan 17, 2024 - 2:15 PM"
    state="active"
    icon="🚚"
    variant="primary"
    :markerSize="'lg'">
    <p class="mb-1 fw-semibold">Package is in transit</p>
    <p class="mb-0">Tracking #: 1Z999AA10123456784</p>
    <small class="text-muted">Estimated delivery: Jan 19, 2024</small>
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Out for Delivery"
    time="Jan 19, 2024"
    state="pending"
    icon="📍">
    Package will be delivered today.
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Delivered"
    time="Expected: Jan 19, 2024"
    state="pending"
    icon="🏠">
    Package will be delivered to your address.
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

### Activity Log Timeline

```twig
<twig:bs:timeline variant="vertical" align="start" size="sm">
  <twig:bs:timeline-item
    title="John Doe updated the document"
    time="2 minutes ago"
    icon="📝"
    variant="primary">
    Changed 15 lines in project-plan.md
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Sarah Smith commented"
    time="15 minutes ago"
    icon="💬"
    variant="info">
    "Looks good to me! Ready to merge."
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Mike Johnson pushed to main"
    time="1 hour ago"
    icon="🚀"
    variant="success">
    3 commits added to main branch
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Build completed"
    time="1 hour ago"
    icon="✓"
    variant="success">
    Build #1234 passed all tests
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Deployment started"
    time="2 hours ago"
    icon="⚙️"
    variant="warning">
    Deploying to production environment
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

### Project Milestones (Alternating)

```twig
<twig:bs:timeline variant="alternating">
  <twig:bs:timeline-item
    title="Project Kickoff"
    time="January 2024"
    timePosition="opposite"
    state="completed"
    badge="1"
    variant="success">
    <p class="mb-0">Initial planning and team formation</p>
    <ul class="mb-0 mt-2">
      <li>Team assigned</li>
      <li>Goals defined</li>
      <li>Timeline approved</li>
    </ul>
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Design Phase"
    time="February 2024"
    timePosition="opposite"
    state="completed"
    badge="2"
    variant="success">
    <p class="mb-0">UI/UX design and architecture planning</p>
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Development Sprint"
    time="March - April 2024"
    timePosition="opposite"
    state="active"
    badge="3"
    variant="primary">
    <p class="mb-0">Core features implementation</p>
    <div class="progress mt-2" style="height: 10px;">
      <div class="progress-bar" role="progressbar" style="width: 65%"></div>
    </div>
    <small class="text-muted">65% complete</small>
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Testing & QA"
    time="May 2024"
    timePosition="opposite"
    state="pending"
    badge="4">
    Comprehensive testing and bug fixes
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Launch"
    time="June 2024"
    timePosition="opposite"
    state="pending"
    badge="5">
    Production deployment and go-live
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

### Event History (Horizontal Mobile-Friendly)

```twig
<twig:bs:timeline variant="horizontal">
  <twig:bs:timeline-item
    title="Account Created"
    time="Jan 2023"
    state="completed"
    icon="👤">
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="First Purchase"
    time="Feb 2023"
    state="completed"
    icon="🛍️">
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Premium Member"
    time="Mar 2023"
    state="completed"
    icon="⭐">
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Referral Bonus"
    time="Apr 2023"
    state="completed"
    icon="🎁">
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

### Compact Timeline

```twig
<twig:bs:timeline variant="compact">
  <twig:bs:timeline-item title="Item 1" time="10:00" state="completed" />
  <twig:bs:timeline-item title="Item 2" time="10:30" state="completed" />
  <twig:bs:timeline-item title="Item 3" time="11:00" state="active" />
  <twig:bs:timeline-item title="Item 4" time="11:30" state="pending" />
</twig:bs:timeline>
```

### Custom Line Styling

```twig
{# Dashed line with color #}
<twig:bs:timeline 
  lineStyle="dashed" 
  lineVariant="primary">
  {# timeline items #}
</twig:bs:timeline>

{# Dotted line #}
<twig:bs:timeline 
  lineStyle="dotted" 
  lineVariant="success">
  {# timeline items #}
</twig:bs:timeline>
```

### Centered Timeline

```twig
<twig:bs:timeline variant="vertical" align="center">
  <twig:bs:timeline-item
    title="Event 1"
    time="2024-01-15"
    timePosition="opposite"
    state="completed"
    icon="1">
    Description on the left
  </twig:bs:timeline-item>
  
  <twig:bs:timeline-item
    title="Event 2"
    time="2024-02-20"
    timePosition="opposite"
    state="active"
    icon="2">
    Description on the right
  </twig:bs:timeline-item>
</twig:bs:timeline>
```

## Accessibility

### Screen Reader Support

The Timeline component is designed with accessibility in mind:

```twig
<div class="timeline" role="list" aria-label="Order status timeline">
  <div class="timeline-item" role="listitem">
    {# Timeline content #}
  </div>
</div>
```

### Best Practices

1. **Provide meaningful time labels**: Use clear, descriptive time/date formats
2. **Use semantic markup**: The component uses proper HTML structure
3. **Include text alternatives**: When using icons, ensure context is clear from surrounding text
4. **State indicators**: Use both visual (color) and textual indicators for states
5. **Keyboard navigation**: Ensure interactive elements (links, buttons) are keyboard accessible

## Configuration

You can set global defaults in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  timeline:
    variant: 'vertical'
    align: 'start'
    show_line: true
    line_style: 'solid'
    line_variant: null
    size: null
    class: null
    attr: {}
  
  timeline_item:
    time_position: 'inline'
    variant: null
    state: null
    show_line: true
    marker_size: null
    class: null
    attr: {}
```

## Layout Variants

### Vertical (Default)

The vertical layout displays timeline items in a vertical stack with the timeline line running vertically.

**Alignment options:**
- `start`: Timeline line on the left (default)
- `center`: Timeline line in the center with alternating content
- `end`: Timeline line on the right

### Horizontal

The horizontal layout displays timeline items in a horizontal scrollable row. Great for mobile-first designs and when space is limited vertically.

### Alternating

The alternating layout places items alternately on left and right sides of a central timeline. Best for larger screens where you want to maximize horizontal space usage.

### Compact

The compact layout is a space-efficient version of the vertical timeline with reduced spacing and smaller markers.

## Styling Customization

### Custom CSS Classes

```twig
<twig:bs:timeline class="my-custom-timeline">
  <twig:bs:timeline-item class="featured-item" ... />
</twig:bs:timeline>
```

### Custom Colors

```twig
{# Using Bootstrap variants #}
<twig:bs:timeline-item variant="success" ... />
<twig:bs:timeline-item variant="danger" ... />
<twig:bs:timeline-item variant="warning" ... />

{# Custom line color #}
<twig:bs:timeline lineVariant="primary">
  {# items #}
</twig:bs:timeline>
```

### Size Variants

```twig
{# Small timeline #}
<twig:bs:timeline size="sm"> ... </twig:bs:timeline>

{# Large timeline #}
<twig:bs:timeline size="lg"> ... </twig:bs:timeline>

{# Individual marker sizes #}
<twig:bs:timeline-item markerSize="lg" ... />
```

## State System

Timeline items support three states that affect their visual appearance:

1. **`pending`**: Grayed out, indicates not yet started
2. **`active`**: Highlighted with pulsing animation, indicates current step
3. **`completed`**: Success color (green), indicates finished step

```twig
<twig:bs:timeline-item state="pending" ... />
<twig:bs:timeline-item state="active" ... />
<twig:bs:timeline-item state="completed" ... />
```

## Testing

The Timeline component has comprehensive test coverage. Run tests with:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/TimelineTest.php
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/TimelineItemTest.php
```

## Related Components

- **Breadcrumbs**: For navigation hierarchies
- **Progress**: For completion indicators
- **List Group**: For simple sequential lists
- **Nav**: For tabbed navigation

## Browser Support

The Timeline component uses modern CSS (Flexbox, Grid) and is compatible with:
- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Considerations

- Use the `compact` variant for timelines with many items
- Consider pagination for timelines with 50+ items
- The `horizontal` variant is scrollable and performs well with many items
- Icons are rendered as HTML/emoji for best performance

## References

- [Bootstrap 5.3 Documentation](https://getbootstrap.com/docs/5.3/)
- [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
- Component source: `src/Twig/Components/Extra/Timeline.php`
- Template: `templates/components/extra/timeline.html.twig`
- Styles: `assets/styles/_timeline.scss`

