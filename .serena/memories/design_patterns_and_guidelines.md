# Design Patterns and Guidelines

## WordPress Plugin Patterns

### Plugin Architecture
- **Entry Point Pattern**: Main plugin file (`src/translentor.php`) contains plugin header and initialization
- **Modular Structure**: Separate directories for widgets, assets, and modules
- **Autoloading**: PSR-4 autoloading via Composer for classes in `Translentor\` namespace

### WordPress Hooks Pattern
- Uses action hooks for initialization:
  - `elementor/elements/categories_registered` - Register custom category
  - `elementor/widgets/register` - Register widgets (modern API)
  - `elementor/frontend/after_enqueue_styles` - Enqueue styles
  - `elementor/frontend/after_register_scripts` - Enqueue scripts
  - `admin_notices` - Display admin notifications
  - `activated_plugin` - Handle activation redirect

### Security Patterns
- **Direct Access Prevention**: All PHP files check `ABSPATH` constant
  ```php
  if (!defined('ABSPATH')) exit;
  ```
- **Session Management**: Checks headers before starting session
  ```php
  if (!session_id() && !headers_sent()) {
      session_start();
  }
  ```

## Elementor Widget Pattern

### Widget Extension Pattern
- Extend `\Elementor\Widget_Base` class
- Implement required methods:
  - `get_name()` - Unique widget identifier
  - `get_title()` - Widget display name
  - `get_icon()` - Widget icon
  - `get_categories()` - Widget category assignment
  - `get_style_depends()` - Required stylesheets
  - `get_script_depends()` - Required scripts
  - `_register_controls()` - Widget settings (not shown but expected)
  - `render()` - Widget output (not shown but expected)

### Asset Dependency Management
- Styles and scripts registered separately
- Dependencies declared via `get_style_depends()` and `get_script_depends()`
- Proper handle naming convention: `translentor-website-translator-{type}`

## Frontend Patterns

### Google Translate Integration
- Script loading prevention: Static flag to avoid duplicate loads
  ```php
  private static $script_loaded = false;
  ```
- Initialization on `DOMContentLoaded`
- URL cleanup to remove translation hash fragments

### State Management
- **LocalStorage Pattern**: Used for persisting language preferences
  - Stores: `img_src`, `lang_name`, `check_onetime`, `default_language`
  - Checks for language changes between sessions

### UI Patterns
- **Toast Notifications**: Using jquery.toast library for user feedback
- **Customizable Widget**: Options for position, style, colors, transitions
- **Flag Icons**: SVG flags for visual language representation

## Code Organization Patterns

### File Naming
- Widget files: Lowercase with underscores (e.g., `tanslentor_widget.php`)
- Asset files: Descriptive names with type suffix (e.g., `translentor-css.css`)
- Minified assets: `.min.css` or `.min.js` extension
- Flags: Language name format (e.g., `English.svg`, `Chinese Simplified.svg`)

### Constants Pattern
- Plugin-specific constants with prefix:
  - `translentor_DIR_Main` - Plugin directory path
  - `translentor_URL` - Plugin URL
  - `translentor_VERSION` - Plugin version
  - `translentor_slug` - Text domain
  - `translentor_category` - Widget category name
  - `translentor_category_icon` - Category icon class

### Version Management Pattern
- Version stored in multiple locations for consistency
- Centralized scripts to get/set version across all files
- Regex pattern matching to find and replace version strings

## Coding Guidelines

### WordPress Best Practices
1. **Internationalization**: Use `__()` function with text domain
2. **Escaping Output**: Should escape output (not always done consistently)
3. **Sanitization**: Should sanitize input (verify in actual implementations)
4. **Nonces**: Should use nonces for form submissions (verify in actual implementations)

### Elementor Best Practices
1. **Modern API**: Updated to use `elementor/widgets/register` hook (v1.6.2)
2. **Asset Dependencies**: Proper dependency declaration
3. **Category Registration**: Custom category for plugin widgets
4. **Widget Isolation**: Each widget in separate file

### Performance Considerations
1. **Script Loading**: Prevent duplicate Google Translate script loads
2. **Minification**: Provide minified CSS/JS versions
3. **Asset Versioning**: Use plugin version for cache busting
4. **Lazy Loading**: Assets loaded only when widget used

### Compatibility Patterns
1. **Browser Compatibility**: Support for modern browsers and legacy IE (event handling)
2. **PHP Compatibility**: Code compatible with PHP 7.4+
3. **WordPress Compatibility**: Tested up to WordPress 6.8.3
4. **Theme Agnostic**: Works with all major WordPress themes

## Known Issues/Technical Debt

### Naming Inconsistencies
- Main widget file has typo: `tanslentor_widget.php` (should be `translentor`)
- Variable naming mixed between camelCase and snake_case

### Commented Code
- Some commented-out code blocks in files (e.g., `src/widgets/index.php`)
- Should be cleaned up or properly documented

### Code Style Inconsistencies
- Mixed use of tabs and spaces for indentation
- Inconsistent bracket placement
- Some files lack proper formatting

## Development Principles
1. **Simplicity**: Plugin designed for easy use without coding knowledge
2. **Customization**: Highly customizable through Elementor controls
3. **Compatibility**: Works with themes, plugins, and WooCommerce
4. **Progressive Enhancement**: Free version with pro add-ons
5. **User Experience**: Loading indicators, responsive design, visual feedback