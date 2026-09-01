# Codebase Structure

## Directory Layout

```
translentor/
├── src/                          # Main source directory
│   ├── translentor.php           # Main plugin file (entry point)
│   ├── readme.txt                # WordPress plugin readme
│   ├── widgets/
│   │   └── index.php             # Widget registration handler
│   └── translentor/
│       ├── assets/               # Static assets
│       │   ├── css/              # Stylesheets
│       │   │   ├── translentor-css.css
│       │   │   ├── translentor-css.min.css
│       │   │   ├── jquery.toast.min.css
│       │   ├── js/               # JavaScript files
│       │   │   ├── translentor-js.js
│       │   │   ├── jquery.toast.min.js
│       │   ├── image/            # Images
│       │   └── logo/             # Plugin logos
│       └── website-translator/   # Translation module
│           ├── widget.php        # Widget module class
│           ├── flags/            # Country flag SVG files (70+ languages)
│           └── widget/
│               └── tanslentor_widget.php  # Main widget implementation
├── scripts/                      # Utility scripts
│   ├── set-version.php           # Version update script
│   └── get-version.php           # Version retrieval script
├── vendor/                       # Composer dependencies
├── .github/workflows/            # CI/CD workflows
├── composer.json                 # Composer configuration
├── README.md                     # Project readme
├── CHANGELOG.md                  # Version history
└── SECURITY.md                   # Security policies

## Key Files

### Main Plugin File
- `src/translentor.php`: Plugin header, constants definition, Elementor integration hooks

### Widget Implementation
- `src/translentor/website-translator/widget/tanslentor_widget.php`: Main Elementor widget class extending `Widget_Base`

### Registration & Loading
- `src/widgets/index.php`: Registers widget with Elementor, enqueues styles and scripts

### Frontend Assets
- `src/translentor/assets/js/translentor-js.js`: Google Translate integration and UI logic
- `src/translentor/assets/css/translentor-css.css`: Widget styling

## Architecture Pattern
- WordPress plugin architecture
- Elementor widget extension pattern
- PSR-4 autoloading with namespace `Translentor\`
- Modular structure separating concerns (widget, assets, flags)