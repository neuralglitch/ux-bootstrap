# Installation Guide

Complete installation guide for the Symfony UX Bootstrap Bundle.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation Steps](#installation-steps)
- [Configuration](#configuration)
- [Troubleshooting](#troubleshooting)

---

## Prerequisites

### ⚠️ Important: Bootstrap 5.3 Required

**This bundle requires Bootstrap 5.3 to be already installed in your project.**

The bundle provides Twig Components and Stimulus controllers for Bootstrap, but **does not install Bootstrap itself**. You must have Bootstrap 5.3 in your project before installing this bundle.

### System Requirements

- **PHP**: 8.1 or higher
- **Composer**: 2.7 or higher
- **Symfony**: 6.4 LTS or 7.x
- **Bootstrap**: 5.3.x (must be pre-installed)

### Required PHP Extensions

```bash
php -m | grep -E 'ctype|iconv'
```

If missing, install them:

```bash
# Ubuntu/Debian
sudo apt-get install php8.1-ctype php8.1-iconv
# Or for PHP 8.2+: sudo apt-get install php8.2-ctype php8.2-iconv

# macOS (Homebrew)
brew install php@8.1
# Or for PHP 8.2+: brew install php@8.2
```

### Required Symfony Bundles

The following bundles are **automatically installed** as dependencies:

- `symfony/config`
- `symfony/dependency-injection`
- `symfony/http-kernel`
- `symfony/routing`
- `symfony/twig-bundle`
- `symfony/ux-twig-component`
- `symfony/ux-icons`

### Optional Dependencies

For full functionality, you may want:

- `symfony/stimulus-bundle` - For JavaScript controllers (tooltips, popovers, etc.)
- `symfony/asset-mapper` - For asset management
- `symfonycasts/sass-bundle` - For SCSS compilation

---

## Installation Steps

### Step 0: Ensure Bootstrap 5.3 is Installed

**If you already have Bootstrap 5.3, skip to Step 1.**

If not, install Bootstrap first:

```bash
# Using Asset Mapper (recommended)
php bin/console importmap:require bootstrap
php bin/console importmap:require @popperjs/core

# Or using npm/yarn
npm install bootstrap @popperjs/core
```

Make sure Bootstrap CSS is loaded in your templates:

```twig
{# templates/base.html.twig #}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
{# Or your local Bootstrap build #}
```

### Step 1: Install the Bundle

```bash
composer require neuralglitch/ux-bootstrap
```

### Step 2: Verify Bundle Registration

**With Symfony Flex** (automatic):
The bundle is automatically registered in `config/bundles.php`.

**Without Symfony Flex** (manual):
Add this line to `config/bundles.php`:

```php
<?php

return [
    // ... other bundles
    NeuralGlitch\UxBootstrap\NeuralGlitchUxBootstrapBundle::class => ['all' => true],
];
```

### Step 3: Install Stimulus (Optional)

**Only needed for interactive components** (tooltips, popovers, alerts with auto-hide, etc.):

```bash
# Using Asset Mapper
php bin/console importmap:require @hotwired/stimulus

# Or using npm/yarn
npm install @hotwired/stimulus
```

### Step 4: Import Stimulus Controllers (Optional)

If using Stimulus for interactive components:

**`assets/app.js`:**

```javascript
import { Application } from '@hotwired/stimulus';
import { registerControllers } from '@symfony/stimulus-bundle/loader';

const app = Application.start();

// Register bundle controllers
registerControllers(
    app,
    import.meta.glob('./controllers/**/*_controller.js', { eager: true })
);
```

---

## Configuration

### Default Configuration

The bundle works out-of-the-box with sensible defaults. To customize, create:

**`config/packages/ux_bootstrap.yaml`:**

```yaml
parameters:
  neuralglitch.ux_bootstrap:
    # Badge Component
    badge:
      variant: 'secondary'
      pill: false
      class: null
      attr: {  }
    
    # Button Component
    button:
      variant: 'primary'
      outline: false
      size: null
      tooltip:
        placement: 'bottom'
        trigger: 'hover'
    
    # Link Component
    link:
      variant: null
      underline: null
      tooltip:
        placement: 'bottom'
    
    # Alert Component
    alert:
      variant: 'primary'
      dismissible: false
      auto_hide: false
      auto_hide_delay: 5000
    
    # ... more components
```

### Component Service Registration

Services are automatically registered. If you need custom service configuration:

**`config/services.yaml`:**

```yaml
services:
    # Custom configuration
    NeuralGlitch\UxBootstrap\Service\Bootstrap\Config:
        arguments:
            $config: '%neuralglitch.ux_bootstrap%'
```

### Template Paths

Templates are automatically loaded from the bundle. To override:

1. Create the same path structure in your `templates/` directory
2. The bundle uses `templates/components/bootstrap/` for component templates

Example override:

```
your-project/
  templates/
    components/
      bootstrap/
        badge.html.twig  # Overrides bundle template
```

---

## Troubleshooting

### Issue: Components Not Found

**Error:**
```
Unknown "bs:badge" tag.
```

**Solution:**
1. Verify bundle is registered in `config/bundles.php`
2. Clear cache: `php bin/console cache:clear`
3. Check that `symfony/ux-twig-component` is installed

### Issue: Styles Not Applied

**Solution:**
1. Ensure Bootstrap CSS is imported in your layout
2. Compile assets: `php bin/console asset-map:compile`
3. Check browser console for asset loading errors

### Issue: Stimulus Controllers Not Working

**Solution:**
1. Verify `symfony/stimulus-bundle` is installed
2. Check `assets/controllers.json` contains bundle controllers
3. Rebuild assets: `npm run build` or `php bin/console asset-map:compile`

### Issue: Configuration Not Applied

**Solution:**
1. Verify configuration file path: `config/packages/ux_bootstrap.yaml`
2. Ensure parameter key is `neuralglitch.ux_bootstrap` (not `app.bootstrap_components`)
3. Clear cache: `php bin/console cache:clear`

### Issue: Namespace Errors

**Error:**
```
Class "NeuralGlitch\UxBootstrap\..." not found
```

**Solution:**
1. Run `composer dump-autoload`
2. Verify autoload in `composer.json`:
   ```json
   "autoload": {
       "psr-4": {
           "NeuralGlitch\\UxBootstrap\\": "src/"
       }
   }
   ```

### Issue: Docker/PHPUnit Issues

**Solution:**
1. Ensure `bin/php-in-docker` is executable: `chmod +x bin/php-in-docker`
2. Verify Docker container is running: `docker compose ps`
3. Check `compose.yml` environment variables are set

### Getting Help

If you encounter issues not covered here:

1. Check [GitHub Issues](https://github.com/neuralglitch/ux-bootstrap/issues)
2. Review [Symfony UX Documentation](https://ux.symfony.com/)
3. Open a new issue with:
   - Symfony version (`php bin/console --version`)
   - PHP version (`php -v`)
   - Error message and stack trace
   - Configuration files

---

## Verification

To verify the bundle is correctly installed:

### 1. Check Bundle Status

```bash
php bin/console debug:config NeuralGlitchUxBootstrapBundle
```

### 2. List Available Components

```bash
php bin/console debug:twig | grep "bs:"
```

Should show:
```
bs:alert
bs:badge
bs:button
bs:card
bs:link
# ... more components
```

### 3. Test in a Template

Create `templates/test.html.twig`:

```twig
<!DOCTYPE html>
<html>
<head>
    <title>Bundle Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <h1>Bundle Test</h1>
    <twig:bs:badge variant="success">Success!</twig:bs:badge>
    <twig:bs:button variant="primary">Test Button</twig:bs:button>
</body>
</html>
```

Access via route to verify components render correctly.

---

## Next Steps

- Read the [Component Reference](docs/components.md)
- Explore [Configuration Options](docs/configuration.md)
- Learn about [Stimulus Controllers](docs/stimulus.md)
- Review [Best Practices](docs/best-practices.md)

---

**Installation complete! 🎉**

You're now ready to use Bootstrap components in your Symfony application.

