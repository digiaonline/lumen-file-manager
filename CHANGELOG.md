# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

NOTE: Always keep an Unreleased version at the top of this CHANGELOG for easy updating.
Don't forget to update the links at the bottom of the CHANGELOG.

## [Unreleased] - YYYY-MM-DD
### Added
- For new features.
### Changed
- For changes in existing functionality.
### Deprecated
- For once-stable features removed in upcoming releases.
### Removed
- For deprecated features removed in this release.
### Fixed
- For any bug fixes.
### Security
- To invite users to upgrade in case of vulnerabilities.

## [2.0.0] - 2017-05-19
### Added
- ODM YAML mapping.
- CHANGELOG.md.
- Support for lumen framework 5.4.

### Changed
- shortId -> fileId in ODM mapping.
- README.md.

### Removed
- Container->make() function call. Use new $className() instead.

### Fixed
- Last parameter to function call put() in DiskAdapter.

## [1.1.4] - 2017-04-24
### Added
- Contributing files.
- Style CI.

### Changed
- Composer.lock.

### Removed
- Suggests for lumen-doctrine-mongodb-odm.
- Unused setId() function.
- Dependency on lumen-doctrine

## [1.1.3] - 2016-05-17
### Added
- ORM YAML mapping.

## [1.1.2] - 2016-03-03
### Changed
- Updated documentation.

## [1.1.1] - 2016-03-03
### Fixed
- Bug in Eloquent File model.

### Removed
- Log call.

## [1.1.0] - 2016-03-03
### Added
- Eloquent support.
- Fractal to suggests.
- Composer.lock.
- Example configuration.

## [1.0.2] - 2016-02-22
### Added
- Check for class_exists when registering facades.

## [1.0.1] - 2016-02-22
### Changed
- Update ShortId version.

## [1.0.0] - 2015-12-04
### Changed
- Move required adapters to suggests.

## [0.9.3] - 2015-12-04
### Added
- Doctrine ODM support.

### Fixed
- Do not read the files in memory, but use resources instead when saving to disk.

## [0.9.2] - 2015-09-10
### Changed
- Add S3 and Cloudinary adapters back, but comment them out.
## [0.9.1] - 2015-09-10
### Removed
- S3 and Cloudinary adapters from default adapters.

## [0.9.0] - 2015-08-27
### Changed
- Use AWS client v3.

## [0.8.0] - 2015-08-27
### Changed
- Revert back to AWS client v2.

## [0.7.0] - 2015-08-27
### Changed
- Use AWS client v3.

## [0.6.0] - 2015-08-25
### Changed
- Use Doctrine 2.x.

### Fixed
- Namespaces.

## [0.5.0] - 2015-07-10
### Added
- File::getUrl().

## [0.4.1] - 2015-07-07
### Removed
- Composer.lock.

## [0.4.0] - 2015-07-07
### Updated
- README.md.

### Removed
- FileManager references from File.

### Fixed
- FileManager Facade accessor.

## [0.3.0] - 2015-07-06
### Changed
- Inject FileManager instance into File instances.

## [0.2.3] - 2015-07-05
### Updated
- README.md.

## [0.2.2] - 2015-07-05
### Updated
- README.md.

## [0.2.1] - 2015-07-05
### Updated
- Composer.json.

## [0.2.0] - 2015-07-05
### Added
- FileFactory class.

## [0.1.0] - 2015-07-05
### Added
- Project files.

[Unreleased]: https://github.com/nordsoftware/lumen-file-manager/compare/2.0.0...HEAD
[0.2.0]: https://github.com/nordsoftware/lumen-file-manager/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/nordsoftware/lumen-file-manager/tree/0.1.0
