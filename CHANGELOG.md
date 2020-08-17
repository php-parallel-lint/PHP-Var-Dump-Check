# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

## [v0.5] - 2020-08-17

### Added

- Added `--custom-function` parameter to check custom debug functions [#10](https://github.com/php-parallel-lint/PHP-Var-Dump-Check/pull/10) from [@umutphp](https://github.com/umutphp). 
- Added .gitattributes from [@reedy](https://github.com/reedy).

### Fixed

-  PHP 7.4: fix compatibility issue [#7](https://github.com/php-parallel-lint/PHP-Var-Dump-Check/pull/7) from [@jrfnl](https://github.com/jrfnl).

### Internal

- Replaced array syntax with short array syntax from [@peter279k](https://github.com/peter279k).
- Added EOF (end of file) for some PHP files from [@peter279k](https://github.com/peter279k).
- Removed $loader variable on bootstrap.php file because it's unused from [@peter279k](https://github.com/peter279k).
- To be compatible with future PHPUnit version, using the ^4.8.36 version at least from [@peter279k](https://github.com/peter279k).
- Changed namespace to PHPunit\Framework\TestCase class namesapce from [@peter279k](https://github.com/peter279k).
- Composer: allow installation of more recent Parallel Lint [#9](https://github.com/php-parallel-lint/PHP-Var-Dump-Check/pull/9) from [@jrfnl](https://github.com/jrfnl).
- Travis: removed sudo [#8](https://github.com/php-parallel-lint/PHP-Var-Dump-Check/pull/8) from [@jrfnl](https://github.com/jrfnl).
- Travis: removed Composer option `--prefer-source` [#8](https://github.com/php-parallel-lint/PHP-Var-Dump-Check/pull/8) from [@jrfnl](https://github.com/jrfnl).

## [v0.4] - 2020-04-25

### Added

- Added check for Symfony dump function `dd` from [@antograssiot](https://github.com/antograssiot).
- Added check for Laravel dump function `dump` from [@Douglasdc3](https://github.com/Douglasdc3).
- Added changelog.
- Added support for PHP 7.4.

### Internal

- Fixed running tests in PHP 5.4 and PHP 5.5 in CI.
