# Changelog

This library adheres to [Semantic Versioning](https://semver.org/) and [Keep a CHANGELOG](https://keepachangelog.com/en/1.0.0/).

## Unreleased

### Added

- `Widget_Feature` feature. #32
- `Widget_Features` feature. #32
- Ignore `.idea` dir from source control for PHPStorm users.
- CI: support PHP 8.4. #35

### Changed

- PHPStan: upgraded to 2.0. [#37](https://github.com/alleyinteractive/wp-type-extensions/issues/37)
- PHPCS: The minimum PHP version is now 8.2.
- Unit test: `WidgetFeatureTest` test works por PHP 8.3 and 8.4.

## 4.0.0

### Added

- `Blocks::from_parsed_blocks()` secondary constructor for use with an array of parsed blocks.

### Changed

- `GTM_Script` feature now preconnects to `https://www.googletagmanager.com`.

### Removed

- `Matched_Blocks` class, now part of the [Match Blocks](https://packagist.org/packages/alleyinteractive/wp-match-blocks) library.

## 3.0.0

### Added

- `Features` interface.
- `Effect` feature.
- `Ordered` feature.
- `Each_Replaced` serialized blocks class.
- `Alley\WP\Features\Library` namespace to hold a library of concrete feature implementations.
- `Allowed_Blocks` library feature.
- `Block_Content_Filter` library feature.
- `Plugin_Loader` library feature.

### Changed

- The minimum PHP version is now 8.2.
- `Group` class now implements `Features`.
- `GTM_Script` class moved to feature library.
- `Each_Appended_Blocks` class renamed `Each_Appended`.

### Removed

- `Conditional_Feature` class (use `Effect` instead).
- `Used_Post_IDs` class.

## 2.2.0

### Added

- `GTM_Script` feature.

## 2.1.0

### Changed

- Support use of `WP_CLI_Feature` in WP-CLI packages.

## 2.0.0

### Changed

- `Features` class renamed `Group`.

## 1.0.0

Initial release.
