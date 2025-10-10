# Changelog

## [1.6.5] - 2025-10-10
Adds:
- feat(build): add configurable PHP version input and artifact ID output

Fixes:
- fix(workflow): correct syntax for readme_path field in changelog dispatch step
- fix(workflow): correct variable assignment syntax in prepare-tag.yml
- fix(workflow): correct version output reference in changelog dispatch step
- fix(workflow): correct variable assignment syntax in changelog dispatch step
- fix(workflow): update file path in version job to use composer.json instead of package.json
- fix(workflow): streamline version job by removing unnecessary steps and correcting version variable usage
- fix(workflow): correct path for next version workflow in prepare-tag.yml
- fix(workflow): refactor tag version computation and streamline changelog dispatch process
- fix(workflow): update version retrieval to use composer.json instead of package.json
- fix(workflow): update tag version retrieval to use package.json and handle beta versions
- fix(translentor): remove unnecessary blank lines for cleaner code
- fix(readme): remove duplicate PHP requirement and format changelog entries
- fix(workflow): update comment action to use codesnippetspro version
- fix(release): refactor job dependencies and streamline artifact handling
- fix(release): correct zip archive creation path and filename format


## [1.6.4] - 2025-10-03

### Added
* Various improvements in UI feedback for end users (f7e2421)

### Changed
* Code formatting enhancements across multiple modules for consistency (e5879d3, bded28e, fc2efed, e4f4538)

### Fixed
* Improved CSS formatting for consistent style application (2caaa37, a87bc2f)

## [1.6.3] (2025-10-02)

### Added
* Enhanced toast notifications to provide better user feedback (4c3dbfb)

### Changed
* Cleanup of commented-out code throughout the codebase to improve maintainability (d3b4455)

### Fixed
* Minor bug fixes and performance optimizations in codebase

## [1.6.2] (2025-10-02)

### Fixed
* Updated widget registration to use modern Elementor API
* Fixed widget asset dependency names to match registered CSS/JS handles (resolved loading issues)
* Removed buggy option check that prevented widget rendering in some cases
* Ensured widget renders consistently when added to pages via Elementor editor
* Improved widget compatibility with Elementor 3.x and newer WordPress versions

## [1.6.1] (2024-11-11)

### Changed
* Ajax loading issue corrected
* Optimized code for faster on page translations
* Additional Elementor styling
* Improved Elementor styling
* Updated flag icons
