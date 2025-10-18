# Code Block Component

## Overview

The `bs:code-block` component provides a beautifully styled, feature-rich code block for displaying syntax-highlighted code snippets. It includes features like copy-to-clipboard, line numbers, code language display, and scrollable containers.

This is an **Extra Component** - a custom UI pattern built on Bootstrap but not part of the core Bootstrap component set.

## Basic Usage

### Simple Code Block

```twig
<twig:bs:code-block language="php">
echo "Hello, World!";
</twig:bs:code-block>
```

### With Code Prop

```twig
<twig:bs:code-block 
    language="javascript" 
    code="console.log('Hello!');" 
/>
```

### With Title

```twig
<twig:bs:code-block language="python" title="Python Example">
def greet(name):
    print(f"Hello, {name}!")
</twig:bs:code-block>
```

### With Filename

```twig
<twig:bs:code-block language="php" filename="index.php">
<?php
require_once 'vendor/autoload.php';

$app = new Application();
$app->run();
</twig:bs:code-block>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `language` | `?string` | `null` | Language identifier (e.g., 'php', 'javascript', 'python', 'html') |
| `code` | `?string` | `null` | Code content (alternative to content block) |
| `title` | `?string` | `null` | Display title above code |
| `filename` | `?string` | `null` | Display filename above code |
| `lineNumbers` | `bool` | `false` | Show line numbers |
| `copyButton` | `bool` | `true` | Show copy-to-clipboard button |
| `highlightLines` | `?string` | `null` | Comma-separated line numbers to highlight (e.g., '1,3-5,8') |
| `theme` | `?string` | `null` | Theme variant: `null` (auto), `'light'`, `'dark'` |
| `maxHeight` | `int` | `0` | Maximum height in pixels (0 = no limit, >0 = scrollable) |
| `wrapLines` | `bool` | `false` | Wrap long lines instead of horizontal scroll |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Examples

### With Line Numbers

```twig
<twig:bs:code-block language="javascript" :lineNumbers="true">
function fibonacci(n) {
  if (n <= 1) return n;
  return fibonacci(n - 1) + fibonacci(n - 2);
}
</twig:bs:code-block>
```

### Dark Theme

```twig
<twig:bs:code-block language="python" theme="dark">
class Employee:
    def __init__(self, name, salary):
        self.name = name
        self.salary = salary
</twig:bs:code-block>
```

### Scrollable Code Block

```twig
<twig:bs:code-block 
    language="php" 
    filename="LongController.php"
    :maxHeight="300">
{# Long code content here... #}
</twig:bs:code-block>
```

### With Wrapped Lines

```twig
<twig:bs:code-block 
    language="bash" 
    :wrapLines="true"
    title="Long Command">
docker run -d --name my-container -p 8080:80 -v /host/path:/container/path -e ENV_VAR=value my-image:latest
</twig:bs:code-block>
```

### Without Copy Button

```twig
<twig:bs:code-block 
    language="text" 
    :copyButton="false">
Output from command execution
Line 2
Line 3
</twig:bs:code-block>
```

### With Line Highlighting

```twig
<twig:bs:code-block 
    language="javascript" 
    :lineNumbers="true"
    highlightLines="2,4-6">
const numbers = [1, 2, 3, 4, 5];
const doubled = numbers.map(n => n * 2);
console.log(doubled);

const sum = numbers.reduce((a, b) => a + b, 0);
console.log(sum);
</twig:bs:code-block>
```

### Multiple Features Combined

```twig
<twig:bs:code-block 
    language="php"
    filename="UserController.php"
    :lineNumbers="true"
    theme="dark"
    :maxHeight="400"
    highlightLines="5-8">
<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function list(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
            
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
</twig:bs:code-block>
```

### With Custom Classes

```twig
<twig:bs:code-block 
    language="html"
    class="my-custom-block border-2"
    :attr="{'data-example': 'true'}">
<!DOCTYPE html>
<html>
<head>
    <title>Example</title>
</head>
<body>
    <h1>Hello World</h1>
</body>
</html>
</twig:bs:code-block>
```

## Supported Languages

Common language identifiers include:

- **Web**: `html`, `css`, `scss`, `javascript`, `typescript`, `jsx`, `tsx`
- **Backend**: `php`, `python`, `ruby`, `java`, `go`, `rust`, `c`, `cpp`, `csharp`
- **Shell/Config**: `bash`, `shell`, `yaml`, `json`, `xml`, `ini`, `toml`
- **SQL**: `sql`, `mysql`, `postgresql`
- **Other**: `markdown`, `text`, `diff`

The `language` prop adds a `language-{lang}` class to the `<code>` element, which can be used by syntax highlighters like Prism.js, Highlight.js, or similar libraries.

## Styling

The component applies the following CSS classes:

### Container Classes
- `code-block` - Base container class
- `code-block-light` - Light theme variant
- `code-block-dark` - Dark theme variant
- `code-block-line-numbers` - When line numbers enabled
- `code-block-wrap` - When line wrapping enabled

### Pre/Code Classes
- `code-block-pre` - The `<pre>` element
- `code-block-scrollable` - When `maxHeight` is set
- `code-block-code` - The `<code>` element
- `language-{lang}` - Language identifier class

### Header Classes
- `code-block-header` - Header container (when title/filename/language present)
- `code-block-header-minimal` - Minimal header (copy button only)
- `code-block-title` - Title text
- `code-block-filename` - Filename text
- `code-block-language` - Language text
- `code-block-copy` - Copy button

## Custom Styling

You can add custom styles to enhance the appearance:

```scss
// Custom code block theme
.code-block {
    border-radius: 0.5rem;
    overflow: hidden;
    
    &-header {
        background: var(--bs-gray-100);
        border-bottom: 1px solid var(--bs-border-color);
        padding: 0.5rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    &-pre {
        margin: 0;
        padding: 1rem;
        background: var(--bs-gray-100);
        
        &.code-block-scrollable {
            overflow-y: auto;
        }
    }
    
    &-code {
        font-family: 'Monaco', 'Menlo', 'Courier New', monospace;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    &-dark {
        .code-block-header {
            background: var(--bs-gray-900);
            color: var(--bs-white);
        }
        
        .code-block-pre {
            background: var(--bs-dark);
            color: var(--bs-light);
        }
    }
}
```

## Accessibility

The component includes several accessibility features:

- **Copy Button**: Has descriptive `title` attribute
- **Keyboard Navigation**: Copy button is keyboard accessible
- **Screen Readers**: Code content is readable by screen readers
- **Visual Feedback**: Copy success/failure shown visually and in text

### ARIA Recommendations

For enhanced accessibility, consider adding:

```twig
<twig:bs:code-block 
    language="php"
    :attr="{
        'role': 'region',
        'aria-label': 'Code example'
    }">
{# code here #}
</twig:bs:code-block>
```

## JavaScript Behavior

The component uses the `bs-code-block` Stimulus controller for copy functionality.

### Stimulus Controller

**Controller**: `bs-code-block`  
**File**: `assets/controllers/bs_code_block_controller.js`

### Targets

- `code` - The `<code>` element containing the text to copy
- `copyBtn` - The copy button element
- `copyText` - The text inside the copy button

### Actions

- `click->bs-code-block#copy` - Triggers copy to clipboard

### Copy Behavior

1. Uses modern `navigator.clipboard` API when available
2. Falls back to `document.execCommand('copy')` for older browsers
3. Shows visual feedback:
   - Button changes to green on success
   - Text changes to "Copied!" temporarily
   - Button changes to red on error
   - Returns to normal state after 2 seconds

## Integration with Syntax Highlighters

### Prism.js

```html
<!-- Include Prism.js in your base template -->
<link href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-php.min.js"></script>
```

```twig
<twig:bs:code-block language="php">
echo "This will be highlighted!";
</twig:bs:code-block>

<script>
// Highlight all code blocks
document.addEventListener('DOMContentLoaded', () => {
    Prism.highlightAll();
});
</script>
```

### Highlight.js

```html
<!-- Include Highlight.js in your base template -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/styles/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/highlight.min.js"></script>
```

```twig
<twig:bs:code-block language="javascript">
const greeting = "Hello, World!";
console.log(greeting);
</twig:bs:code-block>

<script>
// Highlight all code blocks
document.addEventListener('DOMContentLoaded', () => {
    hljs.highlightAll();
});
</script>
```

## Configuration

Configure default options in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  code_block:
    language: null
    code: null
    title: null
    filename: null
    line_numbers: true           # Enable line numbers by default
    copy_button: true             # Show copy button by default
    highlight_lines: null
    theme: 'dark'                 # Use dark theme by default
    max_height: 500               # Default max height
    wrap_lines: false
    class: 'shadow-sm'            # Add shadow to all code blocks
    attr: {}
```

## Testing

The component has comprehensive test coverage in `tests/Twig/Components/Extra/CodeBlockTest.php`.

Run tests:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/CodeBlockTest.php
```

## Related Components

- **`bs:alert`** - For displaying contextual messages
- **`bs:card`** - For wrapping code in card layout
- **`bs:collapse`** - For collapsible code examples

## Browser Support

- ✅ Modern browsers (Chrome, Firefox, Safari, Edge)
- ✅ Clipboard API with fallback for older browsers
- ✅ Works in both secure (HTTPS) and local contexts

## Example Usage Patterns

### Documentation Site

```twig
<div class="row">
    <div class="col-md-6">
        <h3>PHP Example</h3>
        <twig:bs:code-block language="php" :lineNumbers="true">
<?php
echo "Hello World";
        </twig:bs:code-block>
    </div>
    <div class="col-md-6">
        <h3>Output</h3>
        <twig:bs:code-block language="text" :copyButton="false">
Hello World
        </twig:bs:code-block>
    </div>
</div>
```

### Tutorial with Steps

```twig
<h4>Step 1: Create Controller</h4>
<twig:bs:code-block 
    language="php" 
    filename="src/Controller/HomeController.php"
    :lineNumbers="true">
// Controller code...
</twig:bs:code-block>

<h4>Step 2: Create Template</h4>
<twig:bs:code-block 
    language="twig" 
    filename="templates/home/index.html.twig">
{# Template code... #}
</twig:bs:code-block>
```

### Code Comparison

```twig
<div class="row">
    <div class="col-md-6">
        <h5>Before</h5>
        <twig:bs:code-block language="javascript">
var x = 10;
function add(a, b) {
    return a + b;
}
        </twig:bs:code-block>
    </div>
    <div class="col-md-6">
        <h5>After (ES6)</h5>
        <twig:bs:code-block language="javascript">
const x = 10;
const add = (a, b) => a + b;
        </twig:bs:code-block>
    </div>
</div>
```

## References

- [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/)
- [Prism.js](https://prismjs.com/)
- [Highlight.js](https://highlightjs.org/)
- [Clipboard API](https://developer.mozilla.org/en-US/docs/Web/API/Clipboard_API)

