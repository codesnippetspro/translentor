# Changelog


## [1.6.5] - 2025-10-11

### Added
* Build workflow now accepts a php input (default 8.3) to run builds against different PHP versions.
* Automated generation of changelog and readme entries via centralized reusable workflow dispatch.

### Changed
* Replaced ad-hoc tag/version logic with reusable next_version workflow reading composer.json.
* Added artifact_id to build outputs and propagated version output reliably across jobs.
* Pull request comments now use a maintained codesnippetspro action for improved stability.

### Removed
* Release asset filename now includes the tag name (<artifact_name>.<tag_name>.zip); update any consuming scripts/tools.

### Fixed
* Release pipeline downloads artifacts by ID instead of parsing from URL, preventing fetch failures.
* Zip creation step sets and exposes zip_name output consistently for subsequent steps.

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
