# Code Style and Conventions

## PHP Code Style

### General Conventions
- **PHP Version**: Minimum 7.4, code should be compatible with PHP 7.4+
- **WordPress Coding Standards**: Follows WordPress PHP coding standards
- **Naming Conventions**:
  - Functions: `snake_case` (e.g., `cyb_activation_redirect`, `translentor_admin_notices`)
  - Classes: `PascalCase` (e.g., `translentor_elementor_widget`)
  - Constants: `snake_case` with prefix (e.g., `translentor_DIR_Main`, `translentor_VERSION`)
  - Variables: `snake_case` (e.g., `$elementsManager`, `$widgets_manager`)

### Namespace
- Root namespace: `Translentor\`
- PSR-4 autoloading configured in composer.json
- Subnamespaces: `Translentor\Modules\Translentor`

### File Headers
PHP files start with proper docblocks:
```php
<?php
/**
 * Description of the file
 *
 * @package PackageName
 */
```

### Plugin Header (main file)
- Contains WordPress plugin header with metadata
- Defines constants for paths, URLs, and version
- Uses `define()` for global constants

### Comments
- PHPDoc style for classes and methods
- `@since` tags for version tracking
- `@access` tags for visibility
- `@return` tags for return types
- Inline comments for complex logic

### WordPress Integration
- Uses WordPress hooks: `add_action()`, `add_filter()`
- WordPress translation functions: `__()` with text domain
- Security: Direct access checks with `if (!defined('ABSPATH')) exit;`
- Session handling: `session_start()` with header checks

### Elementor Integration
- Extends `\Elementor\Widget_Base`
- Uses Elementor namespaces and classes
- Implements required methods: `get_name()`, `get_title()`, `get_icon()`, `get_categories()`
- Modern API: Uses `elementor/widgets/register` hook (updated in v1.6.2)

## JavaScript Code Style

### General Conventions
- Vanilla JavaScript with jQuery support
- ES5 compatible (no ES6+ features observed)
- Event-driven architecture with DOMContentLoaded
- Variables: `camelCase` or `snake_case` (mixed style observed)

### Structure
- Document ready handlers for initialization
- Function declarations for reusable logic
- jQuery used for DOM manipulation
- localStorage for state persistence

### Naming
- Functions: `camelCase` (e.g., `googleTranslateElementInit`, `triggerHtmlEvent`)
- Variables: Mixed `snake_case` and `camelCase` (e.g., `toast_title`, `selected_img_src`)

## CSS Code Style

### Conventions
- Standard CSS (not preprocessor)
- Minified versions available (.min.css)
- Prefixed classes likely used (translentor-)

## Documentation
- No formal code documentation system detected
- README.md for project overview
- CHANGELOG.md for version history
- Inline comments in code files

## Version Management
- Version defined in multiple places:
  - Plugin header in `src/translentor.php`
  - `composer.json`
  - `src/readme.txt`
- Scripts available to get/set version consistently across files