# Suggested Commands for Translentor Development

## Version Management

### Get Current Version
```bash
composer get-version
# or
php scripts/get-version.php
```

### Set New Version
```bash
composer set-version
# or with parameter
php scripts/set-version.php --v=1.6.3
```

## Package Management

### Install Dependencies
```bash
composer install
```

### Update Dependencies
```bash
composer update
```

### Dump Autoload
```bash
composer dump-autoload
```

## Git Commands (macOS)

### Basic Operations
```bash
# Check status
git status

# Stage changes
git add .

# Commit changes
git commit -m "commit message"

# Push to remote
git push origin main

# Pull latest changes
git pull origin main

# Create new branch
git checkout -b feature/branch-name

# Switch branches
git checkout branch-name

# View history
git log --oneline
```

### Tag Management
```bash
# List tags
git tag -l

# Create tag
git tag -a v1.6.3 -m "Version 1.6.3"

# Push tag
git push origin v1.6.3

# Delete tag
git tag -d v1.6.3
```

## File System Commands (macOS)

### Navigation
```bash
# List directory contents
ls -la

# Change directory
cd path/to/directory

# Print working directory
pwd

# Create directory
mkdir -p path/to/directory

# Remove directory
rm -rf directory_name
```

### File Operations
```bash
# Copy files
cp source destination

# Move/rename files
mv source destination

# Remove files
rm filename

# View file contents
cat filename
less filename

# Search in files
grep -r "search_term" ./src/
```

### Finding Files
```bash
# Find by name
find ./src/ -name "*.php"

# Find and execute
find ./src/ -name "*.php" -exec grep "function_name" {} \;
```

## WordPress/Plugin Testing

### Manual Testing
- Install plugin in local WordPress environment
- Activate plugin through WordPress admin
- Test with Elementor page builder
- Check widget functionality in Elementor editor

### Browser Testing
- Test on Chrome, Firefox, Safari, Edge
- Test responsive design (desktop, tablet, mobile)
- Check console for JavaScript errors

## Build Process

### Manual Build
```bash
# Create distribution package
mkdir -p bundle/translentor
cp -r src/* bundle/translentor/
```

### Automated Build (GitHub Actions)
- Triggered automatically on pull requests, tags, and releases
- See `.github/workflows/build.yml` for build configuration
- Creates artifact with plugin files

## No Testing Framework
**Note**: This project does not currently have:
- PHPUnit tests
- JavaScript test framework
- Automated testing suite
- Code linting configuration (PHPCS, ESLint)
- Code formatting tools (PHP-CS-Fixer, Prettier)

## Development Workflow
1. Make code changes in `src/` directory
2. Test locally in WordPress + Elementor environment
3. Update version using `php scripts/set-version.php --v=X.Y.Z`
4. Update CHANGELOG.md
5. Commit and push changes
6. Create tag for release
7. GitHub Actions will build and create release artifact