# Mega Footer Component

## Overview

The **Mega Footer** component (`bs:mega-footer`) simplifies creating complex, multi-column footers with branding, navigation links, social media, newsletter signup, and copyright information. It provides multiple layout variants for different footer styles.

**Component Type**: Extra  
**Namespace**: `NeuralGlitch\UxBootstrap\Twig\Components\Extra`  
**Twig Tag**: `<twig:bs:mega-footer>`

## Why Use This Component?

Complex footers with multiple columns are tedious to create manually:
- ❌ Repetitive Bootstrap grid markup
- ❌ Managing responsive layouts
- ❌ Inconsistent styling across pages
- ❌ Duplicating footer content

The Mega Footer component solves these problems:
- ✅ Multiple pre-built layout variants
- ✅ Flexible column system with named blocks
- ✅ Built-in brand, social, and newsletter sections
- ✅ Automatic copyright generation
- ✅ Fully responsive and accessible
- ✅ Consistent footer across your application

## Basic Usage

### Simple Footer with Brand and Links

```twig
<twig:bs:mega-footer
    brandName="Acme Corp"
    brandLogo="/logo.svg"
    brandDescription="Building amazing products since 2020"
    :socialLinks="[
        { icon: 'bi-facebook', href: 'https://facebook.com', label: 'Facebook' },
        { icon: 'bi-twitter', href: 'https://twitter.com', label: 'Twitter' },
        { icon: 'bi-linkedin', href: 'https://linkedin.com', label: 'LinkedIn' }
    ]">
    
    <twig:block name="column1">
        <h5>Products</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/features" class="nav-link p-0 text-body-secondary">Features</a></li>
            <li class="nav-item mb-2"><a href="/pricing" class="nav-link p-0 text-body-secondary">Pricing</a></li>
            <li class="nav-item mb-2"><a href="/faq" class="nav-link p-0 text-body-secondary">FAQ</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="column2">
        <h5>Company</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/about" class="nav-link p-0 text-body-secondary">About</a></li>
            <li class="nav-item mb-2"><a href="/team" class="nav-link p-0 text-body-secondary">Team</a></li>
            <li class="nav-item mb-2"><a href="/careers" class="nav-link p-0 text-body-secondary">Careers</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="bottom">
        <a href="/privacy" class="link-body-emphasis text-decoration-none small">Privacy</a>
        <a href="/terms" class="link-body-emphasis text-decoration-none small">Terms</a>
    </twig:block>
</twig:bs:mega-footer>
```

### Minimal Footer

```twig
<twig:bs:mega-footer
    variant="minimal"
    brandName="Acme Corp"
    brandLogo="/logo.svg">
    
    <twig:block name="column1">
        <a href="/about" class="link-body-emphasis text-decoration-none">About</a>
        <a href="/contact" class="link-body-emphasis text-decoration-none">Contact</a>
        <a href="/privacy" class="link-body-emphasis text-decoration-none">Privacy</a>
    </twig:block>
</twig:bs:mega-footer>
```

### Centered Footer with Social Links

```twig
<twig:bs:mega-footer
    variant="centered"
    brandName="Acme Corp"
    brandLogo="/logo.svg"
    brandDescription="Building amazing products"
    :socialLinks="[
        { icon: 'bi-facebook', href: 'https://facebook.com', label: 'Facebook' },
        { icon: 'bi-twitter', href: 'https://twitter.com', label: 'Twitter' },
        { icon: 'bi-github', href: 'https://github.com', label: 'GitHub' }
    ]">
    
    <twig:block name="column1">
        <div class="d-flex gap-3 justify-content-center">
            <a href="/about">About</a>
            <a href="/blog">Blog</a>
            <a href="/contact">Contact</a>
        </div>
    </twig:block>
</twig:bs:mega-footer>
```

### Footer with Newsletter

```twig
<twig:bs:mega-footer
    brandName="Acme Corp"
    brandLogo="/logo.svg"
    :showNewsletter="true"
    newsletterTitle="Stay Updated"
    newsletterPlaceholder="Enter your email"
    newsletterButtonText="Subscribe">
    
    <twig:block name="column1">
        <h5>Resources</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/docs" class="nav-link p-0 text-body-secondary">Documentation</a></li>
            <li class="nav-item mb-2"><a href="/guides" class="nav-link p-0 text-body-secondary">Guides</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="column2">
        <h5>Support</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/help" class="nav-link p-0 text-body-secondary">Help Center</a></li>
            <li class="nav-item mb-2"><a href="/contact" class="nav-link p-0 text-body-secondary">Contact Us</a></li>
        </ul>
    </twig:block>
</twig:bs:mega-footer>
```

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'default'` | Layout variant: `'default'`, `'minimal'`, `'centered'`, `'compact'` |
| `brandName` | `?string` | `null` | Company/brand name |
| `brandLogo` | `?string` | `null` | URL to brand logo image |
| `brandHref` | `?string` | `'/'` | Link destination for brand/logo |
| `brandDescription` | `?string` | `null` | Short description under brand |
| `socialLinks` | `array` | `[]` | Array of social media links: `[{ icon, href, label }]` |
| `copyrightText` | `?string` | `null` | Custom copyright text (auto-generated if null) |
| `showCopyright` | `bool` | `true` | Display copyright notice |
| `showNewsletter` | `bool` | `false` | Display newsletter signup section |
| `newsletterTitle` | `?string` | `'Subscribe to our newsletter'` | Newsletter section title |
| `newsletterPlaceholder` | `?string` | `'Email address'` | Newsletter input placeholder |
| `newsletterButtonText` | `?string` | `'Subscribe'` | Newsletter button text |
| `backgroundColor` | `string` | `'dark'` | Background color: `'dark'`, `'light'`, `'body'`, `'body-tertiary'`, or Bootstrap color |
| `textColor` | `string` | `'white'` | Text color: `'white'`, `'dark'`, `'body'`, `'body-secondary'` |
| `container` | `string` | `'container'` | Container type: `'container'`, `'container-fluid'`, `'container-{breakpoint}'` |
| `showDivider` | `bool` | `true` | Show top border divider |
| `class` | `?string` | `null` | Additional CSS classes |
| `attr` | `array` | `[]` | Additional HTML attributes |

## Layout Variants

### Default Variant

Multi-column layout with brand section, custom columns, and optional newsletter.

```twig
<twig:bs:mega-footer variant="default" brandName="Acme" :showNewsletter="true">
    <twig:block name="column1"><!-- Links --></twig:block>
    <twig:block name="column2"><!-- Links --></twig:block>
    <twig:block name="column3"><!-- Links --></twig:block>
</twig:bs:mega-footer>
```

### Minimal Variant

Compact layout with brand on left and links on right.

```twig
<twig:bs:mega-footer variant="minimal" brandName="Acme">
    <twig:block name="column1">
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
    </twig:block>
</twig:bs:mega-footer>
```

### Centered Variant

Everything centered - perfect for simple footers.

```twig
<twig:bs:mega-footer variant="centered" brandName="Acme">
    <twig:block name="column1">
        <div class="d-flex gap-3 justify-content-center">
            <a href="/about">About</a>
            <a href="/blog">Blog</a>
        </div>
    </twig:block>
</twig:bs:mega-footer>
```

### Compact Variant

Single row with brand, links, and social icons.

```twig
<twig:bs:mega-footer 
    variant="compact" 
    brandName="Acme"
    :socialLinks="[{ icon: 'bi-twitter', href: '#', label: 'Twitter' }]">
    <twig:block name="column1">
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
    </twig:block>
</twig:bs:mega-footer>
```

## Named Blocks

The component supports up to 6 custom columns plus a bottom section:

- `column1` through `column6`: Content columns for navigation links, info, etc.
- `bottom`: Additional content in the copyright/bottom section (e.g., legal links)

```twig
<twig:bs:mega-footer brandName="Acme Corp">
    <twig:block name="column1">
        <h5>Products</h5>
        <!-- Links -->
    </twig:block>
    
    <twig:block name="column2">
        <h5>Company</h5>
        <!-- Links -->
    </twig:block>
    
    <twig:block name="bottom">
        <a href="/privacy">Privacy Policy</a>
        <a href="/terms">Terms of Service</a>
    </twig:block>
</twig:bs:mega-footer>
```

## Social Links

Social links are provided as an array of objects:

```twig
{% set socials = [
    { icon: 'bi-facebook', href: 'https://facebook.com/mycompany', label: 'Facebook' },
    { icon: 'bi-twitter', href: 'https://twitter.com/mycompany', label: 'Twitter' },
    { icon: 'bi-linkedin', href: 'https://linkedin.com/company/mycompany', label: 'LinkedIn' },
    { icon: 'bi-github', href: 'https://github.com/mycompany', label: 'GitHub' },
    { icon: 'bi-instagram', href: 'https://instagram.com/mycompany', label: 'Instagram' }
] %}

<twig:bs:mega-footer brandName="Acme" :socialLinks="socials" />
```

**Icon Classes**: Use Bootstrap Icons (`bi-*`) or any icon library class.

## Copyright Text

### Auto-Generated Copyright

If `copyrightText` is `null` and `brandName` is provided, copyright is auto-generated:

```twig
<twig:bs:mega-footer brandName="Acme Corp" />
{# Generates: © 2025 Acme Corp. All rights reserved. #}
```

### Custom Copyright

```twig
<twig:bs:mega-footer copyrightText="© 2020-2025 Acme Corp. Licensed under MIT." />
```

### Disable Copyright

```twig
<twig:bs:mega-footer :showCopyright="false" />
```

## Newsletter Signup

Enable newsletter signup with `showNewsletter`:

```twig
<twig:bs:mega-footer
    brandName="Acme"
    :showNewsletter="true"
    newsletterTitle="Get Updates"
    newsletterPlaceholder="Your email"
    newsletterButtonText="Sign Up" />
```

**Note**: The form does not include action/method by default. You can add them via the `attr` prop or handle submission via JavaScript.

## Color Schemes

### Dark Footer (Default)

```twig
<twig:bs:mega-footer backgroundColor="dark" textColor="white" />
```

### Light Footer

```twig
<twig:bs:mega-footer backgroundColor="light" textColor="dark" />
```

### Tertiary Background

```twig
<twig:bs:mega-footer backgroundColor="body-tertiary" textColor="body" />
```

### Custom Colors

```twig
<twig:bs:mega-footer backgroundColor="primary" textColor="white" />
```

## Examples

### Complete Multi-Column Footer

```twig
<twig:bs:mega-footer
    brandName="Acme Corp"
    brandLogo="/assets/logo.svg"
    brandDescription="Building innovative solutions since 2020"
    :socialLinks="[
        { icon: 'bi-facebook', href: 'https://facebook.com', label: 'Facebook' },
        { icon: 'bi-twitter', href: 'https://twitter.com', label: 'Twitter' },
        { icon: 'bi-linkedin', href: 'https://linkedin.com', label: 'LinkedIn' },
        { icon: 'bi-github', href: 'https://github.com', label: 'GitHub' }
    ]"
    :showNewsletter="true"
    backgroundColor="dark"
    textColor="white">
    
    <twig:block name="column1">
        <h5 class="mb-3">Products</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/features" class="nav-link p-0 text-body-secondary">Features</a></li>
            <li class="nav-item mb-2"><a href="/pricing" class="nav-link p-0 text-body-secondary">Pricing</a></li>
            <li class="nav-item mb-2"><a href="/security" class="nav-link p-0 text-body-secondary">Security</a></li>
            <li class="nav-item mb-2"><a href="/roadmap" class="nav-link p-0 text-body-secondary">Roadmap</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="column2">
        <h5 class="mb-3">Company</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/about" class="nav-link p-0 text-body-secondary">About Us</a></li>
            <li class="nav-item mb-2"><a href="/team" class="nav-link p-0 text-body-secondary">Team</a></li>
            <li class="nav-item mb-2"><a href="/careers" class="nav-link p-0 text-body-secondary">Careers</a></li>
            <li class="nav-item mb-2"><a href="/press" class="nav-link p-0 text-body-secondary">Press Kit</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="column3">
        <h5 class="mb-3">Resources</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="/docs" class="nav-link p-0 text-body-secondary">Documentation</a></li>
            <li class="nav-item mb-2"><a href="/guides" class="nav-link p-0 text-body-secondary">Guides</a></li>
            <li class="nav-item mb-2"><a href="/api" class="nav-link p-0 text-body-secondary">API Reference</a></li>
            <li class="nav-item mb-2"><a href="/blog" class="nav-link p-0 text-body-secondary">Blog</a></li>
        </ul>
    </twig:block>
    
    <twig:block name="bottom">
        <a href="/privacy" class="link-body-emphasis text-decoration-none small">Privacy Policy</a>
        <a href="/terms" class="link-body-emphasis text-decoration-none small">Terms of Service</a>
        <a href="/cookies" class="link-body-emphasis text-decoration-none small">Cookie Policy</a>
    </twig:block>
</twig:bs:mega-footer>
```

### Light Footer with Compact Layout

```twig
<twig:bs:mega-footer
    variant="compact"
    brandName="Acme"
    brandLogo="/logo.svg"
    backgroundColor="light"
    textColor="dark"
    :socialLinks="[
        { icon: 'bi-twitter', href: 'https://twitter.com', label: 'Twitter' },
        { icon: 'bi-github', href: 'https://github.com', label: 'GitHub' }
    ]">
    
    <twig:block name="column1">
        <a href="/about" class="link-dark text-decoration-none">About</a>
        <a href="/blog" class="link-dark text-decoration-none">Blog</a>
        <a href="/contact" class="link-dark text-decoration-none">Contact</a>
    </twig:block>
</twig:bs:mega-footer>
```

## Accessibility

- Use semantic `<footer>` element
- Provide `label` in social links for screen readers
- Use proper link text (avoid "click here")
- Ensure sufficient color contrast
- Newsletter form should have proper labels (can be customized via blocks)

## Configuration

Global defaults can be set in `config/packages/ux_bootstrap.yaml`:

```yaml
neuralglitch_ux_bootstrap:
  mega_footer:
    variant: 'default'
    brand_name: 'My Company'
    brand_logo: '/assets/logo.svg'
    brand_href: '/'
    brand_description: null
    social_links:
      - { icon: 'bi-twitter', href: 'https://twitter.com/mycompany', label: 'Twitter' }
      - { icon: 'bi-github', href: 'https://github.com/mycompany', label: 'GitHub' }
    copyright_text: null
    show_copyright: true
    show_newsletter: false
    newsletter_title: 'Subscribe to our newsletter'
    newsletter_placeholder: 'Email address'
    newsletter_button_text: 'Subscribe'
    background_color: 'dark'
    text_color: 'white'
    container: 'container'
    show_divider: true
    class: null
    attr: {}
```

## Testing

Run tests for the Mega Footer component:

```bash
bin/php-in-docker vendor/bin/phpunit tests/Twig/Components/Extra/MegaFooterTest.php
```

## Related Components

- **Hero**: For page headers and hero sections
- **CTA**: For call-to-action sections
- **Navbar**: For site navigation

## References

- [Bootstrap Footer Examples](https://getbootstrap.com/docs/5.3/examples/footers/)
- [Symfony UX TwigComponent Documentation](https://symfony.com/bundles/ux-twig-component/current/index.html)

