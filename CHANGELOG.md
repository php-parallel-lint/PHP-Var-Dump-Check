# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

### Added

- Added .gitattributes from [@reedy](https://github.com/reedy).

### Internal

- Replaced array syntax with short array syntax from [@peter279k](https://github.com/peter279k).
- Added EOF (end of file) for some PHP files from [@peter279k](https://github.com/peter279k).
- Removed $loader variable on bootstrap.php file because it's unused from [@peter279k](https://github.com/peter279k).
- To be compatible with future PHPUnit version, using the ^4.8.36 version at least from [@peter279k](https://github.com/peter279k).
- Changed namespace to PHPunit\Framework\TestCase class namesapce from [@peter279k](https://github.com/peter279k).

## [v0.4] - 2020-04-25

### Added

- Added check for Symfony dump function `dd` from [@antograssiot](https://github.com/antograssiot).
- Added check for Laravel dump function `dump` from [@Douglasdc3](https://github.com/Douglasdc3).
- Added changelog.
- Added support for PHP 7.4.

### Internal

- Fixed running tests in PHP 5.4 and PHP 5.5 in CI.
