# Contributing to Symfony UX Bootstrap Bundle

Thank you for considering contributing to the Symfony UX Bootstrap Bundle! This document provides guidelines and instructions for contributing.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Pull Request Process](#pull-request-process)
- [Reporting Issues](#reporting-issues)

---

## Code of Conduct

This project follows the Symfony Code of Conduct. Be respectful, constructive, and professional in all interactions.

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer 2.7+
- Docker & Docker Compose (for local development)
- Node.js 18+ (if working with JavaScript/Stimulus)

### Fork and Clone

1. Fork the repository on GitHub
2. Clone your fork locally:

```bash
git clone git@github.com:YOUR-USERNAME/ux-bootstrap.git
cd ux-bootstrap
```

3. Add upstream remote:

```bash
git remote add upstream git@github.com:neuralglitch/ux-bootstrap.git
```

### Setup Development Environment

```bash
# Install PHP dependencies
composer install

# Start Docker containers (if using Docker)
docker compose up -d

# Install Bootstrap 5.3 (REQUIRED for testing components)
php bin/console importmap:require bootstrap
php bin/console importmap:require @popperjs/core

# Install Stimulus (if working on interactive components)
php bin/console importmap:require @hotwired/stimulus

# Build assets
php bin/console asset-map:compile
```

---

## Development Workflow

### Branching Strategy

- `main` - Stable production code
- `develop` - Integration branch for features
- `feature/*` - New features
- `bugfix/*` - Bug fixes
- `hotfix/*` - Critical production fixes

### Creating a Feature Branch

```bash
git checkout main
git pull upstream main
git checkout -b feature/your-feature-name
```

### Making Changes

1. **Write code** following the [Coding Standards](#coding-standards)
2. **Write tests** for new functionality
3. **Update documentation** if needed
4. **Run tests** to ensure nothing breaks

```bash
# Run PHPUnit tests
./bin/php-in-docker vendor/bin/phpunit

# Run PHPStan (static analysis)
vendor/bin/phpstan analyse

# Run code style fixer
vendor/bin/php-cs-fixer fix
```

### Commit Messages

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: add new Button size prop
fix: resolve tooltip positioning issue
docs: update installation guide
test: add tests for Alert component
refactor: simplify Config service
```

Examples:
- `feat(button): add loading state support`
- `fix(navbar): resolve mobile menu toggle`
- `docs(readme): update installation steps`

---

## Coding Standards

### PHP

This project follows **Symfony Coding Standards**:

- PHP 8.2+ strict typing: `declare(strict_types=1);`
- Public constructors, not final by default
- Typed properties and parameters
- Return type declarations
- DocBlocks for complex logic

#### File Structure

```php
<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap;

use NeuralGlitch\UxBootstrap\Service\Bootstrap\Config;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(name: 'bs:example', template: 'components/bootstrap/example.html.twig')]
final class Example
{
    public ?string $variant = null;
    
    public function __construct(private readonly Config $config)
    {
    }
    
    public function mount(): void
    {
        $defaults = $this->config->for('example');
        $this->variant ??= $defaults['variant'] ?? 'primary';
    }
}
```

### Naming Conventions

- **Classes/Interfaces**: `PascalCase`
- **Methods/Properties**: `camelCase`
- **Constants**: `UPPER_SNAKE_CASE`
- **Component names**: `kebab-case` (e.g., `bs:my-component`)
- **File names**: Match class name

### Twig

- Use Twig components syntax: `<twig:bs:component />`
- Always use `{% block content %}` for slot content
- Provide both prop and slot alternatives

### JavaScript/Stimulus

- Controller names: `snake_case_controller.js`
- Stimulus identifiers: `kebab-case` (e.g., `data-controller="bs-alert"`)
- Use ES6+ features
- Document complex logic

### Configuration

- YAML format for configuration files
- Snake_case for parameter keys
- Provide comprehensive defaults

---

## Pull Request Process

### Before Submitting

1. **Ensure all tests pass**:
   ```bash
   ./bin/php-in-docker vendor/bin/phpunit
   vendor/bin/phpstan analyse
   ```

2. **Update documentation** if needed:
   - README.md
   - CHANGELOG.md
   - Component-specific docs

3. **Add yourself** to contributors (if first contribution)

### Submitting PR

1. Push your branch:
   ```bash
   git push origin feature/your-feature-name
   ```

2. Create Pull Request on GitHub:
   - Use a descriptive title
   - Reference related issues (#123)
   - Describe changes clearly
   - Add screenshots for UI changes
   - List breaking changes (if any)

3. **PR Template**:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Related Issue
Fixes #(issue number)

## Testing
- [ ] Tests added/updated
- [ ] All tests pass
- [ ] Manual testing completed

## Checklist
- [ ] Code follows project style
- [ ] Documentation updated
- [ ] CHANGELOG.md updated
- [ ] No breaking changes (or documented)
```

### Review Process

- Maintainers will review your PR
- Address feedback and update PR
- Once approved, maintainer will merge

---

## Reporting Issues

### Bug Reports

Include:
- Symfony version
- PHP version
- Bundle version
- Steps to reproduce
- Expected vs actual behavior
- Error messages/logs
- Minimal code example

### Feature Requests

Include:
- Clear description of feature
- Use cases and benefits
- Possible implementation approach
- Examples from other projects

### Security Issues

**Do NOT** open public issues for security vulnerabilities.

Email: dev@neuralglit.ch

---

## Development Tips

### Testing Components

Create a test route and template:

```php
// src/Controller/TestController.php
#[Route('/test-components', name: 'test_components')]
public function test(): Response
{
    return $this->render('test/components.html.twig');
}
```

```twig
{# templates/test/components.html.twig #}
<twig:bs:badge variant="success">Test Badge</twig:bs:badge>
```

### Docker Commands

```bash
# Start containers
docker compose up -d

# Execute PHP commands
./bin/php-in-docker php -v
./bin/php-in-docker bin/console cache:clear

# Run tests
./bin/php-in-docker vendor/bin/phpunit

# Stop containers
docker compose down
```

### Debugging

- Use Symfony Profiler for Twig debugging
- Check `var/log/` for errors
- Use Xdebug for step debugging
- Browser DevTools for Stimulus issues

---

## Recognition

Contributors will be recognized in:
- CHANGELOG.md (per release)
- GitHub contributors page
- Future project credits page

---

## Questions?

- Open a [Discussion](https://github.com/neuralglitch/ux-bootstrap/discussions)
- Check [existing issues](https://github.com/neuralglitch/ux-bootstrap/issues)
- Email: dev@neuralglit.ch

---

**Thank you for contributing! 🙏**

Together we build better tools for the Symfony community.

