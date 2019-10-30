# Change Log

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## [2.2.1](https://github.com/Datamedrix/support-toolset/compare/v2.2.0...v2.2.1) (2019-10-30)

### Bug Fixes

* **database/migrations:** Throw the exception correctly only if no database manager is set and no Laravel helper functions are available. ([74010d5](https://github.com/Datamedrix/support-toolset/commit/74010d5))

# [2.2.0](https://github.com/Datamedrix/support-toolset/compare/v2.1.1...v2.2.0) (2019-10-30)

### Features

* **database:** Add lightly adopted Laravel based migration and blueprint classes. ([83cb5f1](https://github.com/Datamedrix/support-toolset/commit/83cb5f1))

## [2.1.1](https://github.com/Datamedrix/support-toolset/compare/v2.1.0...v2.1.1) (2019-10-25)

### Bug Fixes

* **database:** Remove misplaced migration and blueprint classes. ([05d6d64](https://github.com/Datamedrix/support-toolset/commit/05d6d64))

# [2.1.0](https://github.com/Datamedrix/support-toolset/compare/v2.0.0...v2.1.0) (2019-10-25)

### Features

* **database:** Add lightly adopted (Laravel)migration base class and (Laravel)blueprint. ([f57443e](https://github.com/Datamedrix/support-toolset/commit/f57443e))

# 2.0.0 (2019-09-09)

### Features

* **\*:** Move package to support laravel 6.0.

# 1.1.3 (2019-09-09)

### Fixes 

* **\*:** Remove support for laravel 6.0, cause of an deprecated function issue.

# 1.1.2 (2019-09-09)

### Chore

* **\*:** Dependencies updated to support laravel 6.0.

# 1.1.1 (2019-06-06)

### Fixes

* **traits:** Check for an potentially existing method defined within the model before snake case the designated attribute (`getAttribute()`).

<a name="1.1.0"></a>
# 1.1.0 (2018-09-10)

### Features

* **traits:** add HasSnakeCaseAttributes to use within Eloquent models
    * overloads getAttribute() and setAttribute() to use snake case attribute names
        * Example: 
            * **Field in the database:** "my_awesome_field"
            * **Use on model:** $myModel->myAwesomeField

### Refactor

* **traits:** rename ProvidesIdentifierTrait to ProvidesIdentifier

<a name="1.0.0"></a>
# 1.0.0 (2018-06-21)

### Features

* **traits:** add ProvidesIdentifierTrait
    * Add basic methods to handle text based identifiers like UUID
        * $obj->identifier()  ... returns the identifier saved within the object
