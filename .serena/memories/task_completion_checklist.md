# Task Completion Checklist

When completing a development task for Translentor, follow this checklist:

## Code Changes

### 1. Code Quality
- [ ] Code follows WordPress PHP coding standards
- [ ] Functions and variables use appropriate naming conventions (snake_case)
- [ ] Classes use PascalCase
- [ ] Direct access security check included: `if (!defined('ABSPATH')) exit;`
- [ ] WordPress hooks used correctly (`add_action`, `add_filter`)
- [ ] Text strings wrapped with `__()` for translation support
- [ ] PHPDoc comments added for new classes/methods
- [ ] Inline comments added for complex logic

### 2. Compatibility
- [ ] PHP 7.4+ compatible code
- [ ] WordPress 6.6+ compatible
- [ ] Elementor compatibility maintained
- [ ] WooCommerce compatibility considered (if applicable)
- [ ] Cross-browser compatibility (Chrome, Firefox, Safari, Edge)
- [ ] Responsive design (desktop, tablet, mobile)

### 3. Testing
- [ ] Manual testing in local WordPress environment
- [ ] Test with Elementor page builder
- [ ] Test widget drag-and-drop functionality
- [ ] Test translation functionality
- [ ] Check browser console for JavaScript errors
- [ ] Test on different screen sizes
- [ ] Verify no PHP errors/warnings

## Version Control

### 4. Documentation
- [ ] Update CHANGELOG.md with changes
- [ ] Add entry with date: `## [X.Y.Z] (YYYY-MM-DD)`
- [ ] Categorize changes: Fixed, Changed, Added, Removed, Security
- [ ] Update README.md if features changed
- [ ] Update src/readme.txt if WordPress plugin info changed

### 5. Version Management
If releasing a new version:
- [ ] Update version using: `php scripts/set-version.php --v=X.Y.Z`
- [ ] Verify version updated in all files:
  - `src/translentor.php` (plugin header and constant)
  - `composer.json`
  - `src/readme.txt`
- [ ] Confirm version with: `composer get-version`

### 6. Git Workflow
- [ ] Create feature branch: `git checkout -b feature/descriptive-name`
- [ ] Stage changes: `git add .`
- [ ] Commit with descriptive message: `git commit -m "description"`
- [ ] Push branch: `git push origin feature/descriptive-name`
- [ ] Create pull request on GitHub
- [ ] Wait for GitHub Actions build to pass
- [ ] Merge after review

### 7. Release Process (if applicable)
- [ ] Merge to main branch
- [ ] Create version tag: `git tag -a vX.Y.Z -m "Version X.Y.Z"`
- [ ] Push tag: `git push origin vX.Y.Z`
- [ ] GitHub Actions will create release artifact automatically
- [ ] Verify release artifact on GitHub

## Asset Changes

### 8. Frontend Assets
If CSS/JS files changed:
- [ ] Test minified versions still work
- [ ] Verify assets load correctly in WordPress
- [ ] Check asset dependencies in `get_style_depends()` and `get_script_depends()`
- [ ] Ensure proper asset versioning for cache busting

### 9. Files/Flags
If adding new languages:
- [ ] Add SVG flag to `src/translentor/website-translator/flags/`
- [ ] Update language array in widget
- [ ] Test flag display in widget

## Security

### 10. Security Checks
- [ ] No SQL injection vulnerabilities
- [ ] Proper data sanitization/escaping
- [ ] ABSPATH check in all PHP files
- [ ] No hardcoded credentials
- [ ] Session security considered
- [ ] User permissions checked where applicable

## Final Verification

### 11. Before Committing
- [ ] Remove debug code and console.log statements
- [ ] Remove commented-out code (clean code)
- [ ] Check for TODO/FIXME comments
- [ ] Verify no merge conflict markers
- [ ] Ensure proper file permissions

### 12. Post-Deployment
- [ ] Monitor for errors in production
- [ ] Check support channels for issues
- [ ] Document known issues if any
- [ ] Plan follow-up fixes if needed

## Notes
- This project does NOT have automated testing, linting, or formatting
- Manual testing is critical
- Always test in a WordPress + Elementor environment before releasing