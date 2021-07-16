# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

### [4.2.1](https://github.com/Datamedrix/support-toolset/compare/v4.2.0...v4.2.1) (2021-07-16)

### Bug Fixes

* **database/schema:** Use ANSI-SQL "no action" for on delete reference restrictions to be more compatible to MS SQL Server. ([db5a51d](https://github.com/Datamedrix/support-toolset/commit/db5a51d316af2ecf334a75d6236888bbb04302da))

## [4.2.0](https://github.com/Datamedrix/support-toolset/compare/v4.1.0...v4.2.0) (2021-07-14)

### Features

* **database/migration:** Add methods to create and drop database schemas if the driver supports it. ([bed749d](https://github.com/Datamedrix/support-toolset/commit/bed749d4a665adf9df2bcad038722dd13aa1b2e5))

## [4.1.0](https://github.com/Datamedrix/support-toolset/compare/v4.0.1...v4.1.0) (2021-07-06)

### Features

* **eloquent:** Use optional schemas also with MSSQL databases. ([71de35d](https://github.com/Datamedrix/support-toolset/commit/71de35d13fd9926adad64eca36f7016026aa1cb2))

### [4.0.1](https://github.com/Datamedrix/support-toolset/compare/v4.0.0...v4.0.1) (2021-07-06)

### Bug Fixes

* **database/schema:** Use Laravel's built in methods to set the current timestamp instead of using a expression to make them more compatible to other database systems. ([487c5d2](https://github.com/Datamedrix/support-toolset/commit/487c5d274863759d17424cc6792068554990f73e))

## [4.0.0](https://github.com/Datamedrix/support-toolset/compare/v3.4.0...v4.0.0) (2021-06-22)

### Features

* **eloquent:** Add 2 new traits. ([0e5a5b6](https://github.com/Datamedrix/support-toolset/commit/0e5a5b6d71692e6f14d40383676f4bd0e6783ccf))

### BREAKING CHANGES

* **eloquent:** Move trait HasSnakeCaseAttributes to \DMX\Support\Database\Eloquent\Models\Concerns. ([e3ce4f74](https://github.com/Datamedrix/support-toolset/commit/e3ce4f749cf9cbc19c6ab3c780a12f5b1e3913a4))


## [3.4.0](https://github.com/Datamedrix/support-toolset/compare/v3.3.0...v3.4.0) (2021-06-09)

### Features

* **eloquent/models:** Enhance the HasSnakeCaseAttributes trait. ([f0b8080](https://github.com/Datamedrix/support-toolset/commit/f0b8080b4f9d227be72cd714bfb647fab9c9ae2b))

# [3.3.0](https://github.com/Datamedrix/support-toolset/compare/v3.2.1...v3.3.0) (2020-10-29)

### Features

* Add support for laravel framework 7.x and 8.x. ([2d28091](https://github.com/Datamedrix/support-toolset/commit/2d28091))

## [3.2.1](https://github.com/Datamedrix/support-toolset/compare/v3.2.0...v3.2.1) (2020-01-22)


### Bug Fixes

* **model/concerns/DbSchema:** Do not add the db schema twice to the table name! ([3471869](https://github.com/Datamedrix/support-toolset/commit/3471869))

# [3.2.0](https://github.com/Datamedrix/support-toolset/compare/v3.1.0...v3.2.0) (2020-01-21)

### Features

* **eloquent:** Add optional schema name to table name if the database engine does not support db-schemas. ([45d1581](https://github.com/Datamedrix/support-toolset/commit/45d1581))

# [3.1.0](https://github.com/Datamedrix/support-toolset/compare/v3.0.0...v3.1.0) (2020-01-17)

### Features

* **database/schema:** Enhance the blueprint and provide methods to columns used for user audit. ([96cc4d5](https://github.com/Datamedrix/support-toolset/commit/96cc4d5))

# [3.0.0](https://github.com/Datamedrix/support-toolset/compare/v2.3.0...v3.0.0) (2020-01-17)

* **\*:** Move the package to PHP 7.4.

# [2.3.0](https://github.com/Datamedrix/support-toolset/compare/v2.2.1...v2.3.0) (2019-10-31)

### Features

* **database/eloquent:** Add trait to add a optional schema name property to a model. ([9d60f15](https://github.com/Datamedrix/support-toolset/commit/9d60f15))

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
