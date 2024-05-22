# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## [7.0.3](https://github.com/Datamedrix/support-toolset/compare/v7.0.2...v7.0.3) (2024-05-22)

### Bug Fixes

* **database/schema:** Unable to define the index name for uuid columns. ([4926c96](https://github.com/Datamedrix/support-toolset/commit/4926c96db63ea81c80da9097dbc4761596af26ab))

## [7.0.2](https://github.com/Datamedrix/support-toolset/compare/v7.0.1...v7.0.2) (2024-05-22)

### Enhancements

* **database/schema:** Add switch to `uuid` blueprint function to be able to define an uuid column as non-unique. ([4db4a5d6](https://github.com/Datamedrix/support-toolset/commit/4db4a5d623ef6f226b3bfda87778d1c0b4ef3f6c))

## [7.0.1](https://github.com/Datamedrix/support-toolset/compare/v7.0.0...v7.0.1) (2024-04-24)

### Bug Fixes

* **eloquent/models/concerns:** Define the same property ($casts, $attributes) in `HasSnakeCaseAttributes`! ([a959e86](https://github.com/Datamedrix/support-toolset/commit/a959e8655b0898c296928d21b11907d4d4e1590b))

## [7.0.0](https://github.com/Datamedrix/support-toolset/compare/v6.1.0...v7.0.0) (2024-04-16)

### BREAKING CHANGES:
* Set minimum PHP version to ^8.3
* Rename schema blueprint helper method `userAudit` to `blamable`
* Rename schema blueprint helper method `userAuditInclTimestamps` to `blamableInclTimestamps`
* Rename migration property `dbm` to `databaseManager`

### Features

* Add support for Laravel v11. ([6860d35](https://github.com/Datamedrix/support-toolset/commit/6860d35153335862e7a618ad9ed9577df0f54497))
* Add helper method `rawColumn` to blueprint.

## [6.1.0](https://github.com/Datamedrix/support-toolset/compare/v6.0.0...v6.1.0) (2023-12-12)

### Features

* Add support for Laravel v10. ([3cdfb91](https://github.com/Datamedrix/support-toolset/commit/3cdfb913d13f021cb8385ed679ad4e21517f4932))

## [6.0.0](https://github.com/Datamedrix/support-toolset/compare/v5.2.1...v6.0.0) (2023-01-30)

### Features

* Migrate to PHP v8.2. ([a1b15d5](https://github.com/Datamedrix/support-toolset/commit/a1b15d51d8b80a8de7107e6d5182699a6fb4c054))

## [5.2.1](https://github.com/Datamedrix/support-toolset/compare/v5.2.0...v5.2.1) (2022-08-29)

### Bug Fixes

* **database/schema/blueprint:** Define column "original_import_id" as string to be able to save uuid like ids. ([ac4ef4c](https://github.com/Datamedrix/support-toolset/commit/ac4ef4cb7dc14b753ef45a326258124c4cfa32e1))

## [5.2.0](https://github.com/Datamedrix/support-toolset/compare/v5.1.1...v5.2.0) (2022-08-26)

### Features

* **database/schema/blueprint:** Add column "original_import_id" if the option "inclImportedBy" is set to true using the userAudit functions. ([7b5513f](https://github.com/Datamedrix/support-toolset/commit/7b5513febc42f881f29d809b03fe54a75e1cee5a))

## [5.1.1](https://github.com/Datamedrix/support-toolset/compare/v5.1.0...v5.1.1) (2022-07-26)

### Bug Fixes

* **database/schema/blueprint:** Add missing column definition for "imported_by". ([f2114d9](https://github.com/Datamedrix/support-toolset/commit/f2114d9615610d7c3978fa26cd43c9eb4821d85d))

## [5.1.0](https://github.com/Datamedrix/support-toolset/compare/v5.0.1...v5.1.0) (2022-07-26)

### Features

* **database/schema/blueprint:** Add option to add "imported_by" and "imported_at" when using the userAudit functions. ([1c44981](https://github.com/Datamedrix/support-toolset/commit/1c449816579b42c4c382b29a21bababb7aec7373))

### Examples
```php
$table->userAudit('users', 0, ['inclImportedBy' => true]);
```
or
```php
$table->userAuditInclTimestamps('users', 0, ['inclImportedBy' => true]);
```

## [5.0.1](https://github.com/Datamedrix/support-toolset/compare/v5.0.0...v5.0.1) (2022-06-10)

### Bug Fixes

* **database/schema/blueprint:** Use correct parameter order for precision, when add soft deletes timestamps. ([d4d8886](https://github.com/Datamedrix/support-toolset/commit/d4d88861718466954ca4568b7112a11da40de012))

## [5.0.0](https://github.com/Datamedrix/support-toolset/compare/v4.3.1...v5.0.0) (2022-05-31)

### Features

* **schema/blueprint:** Add option to include soft delete columns. ([dc30dea](https://github.com/Datamedrix/support-toolset/commit/dc30deaec6f479ce9edb0d820c76ac9f58535fd0))

#### BREAKING CHANGE(s)
* The method parameters declaration of `DMX\Support\Database\Schema::userAudit()` has changed!
  * **old:** `userAudit(string $referencedTo = 'users', array $referenceRestrictions = ['onUpdate' => 'no action', 'onDelete' => 'no action']): void`
  * **new:** `userAudit(string $referencedTo = 'users', array $options = []): void`
* The method parameters declaration of `DMX\Support\Database\Schema::userAuditInclTimestamps()` has changed!
  * **old:** `userAuditInclTimestamps(string $referencedTo = 'users', int $precision = 0, array $referenceRestrictions = ['onUpdate' => 'no action', 'onDelete' => 'no action']): void`
  * **new:** `userAuditInclTimestamps(string $referencedTo = 'users', int $precision = 0, array $options = []): void`

## [4.3.1](https://github.com/Datamedrix/support-toolset/compare/v4.3.0...v4.3.1) (2021-07-21)

### Bug Fixes

* **eloquent/model/concerns:** Use array_key_exists() instead of isset() to determine if data set in request, to be able to save fields set to null! ([709f987](https://github.com/Datamedrix/support-toolset/commit/709f987bffda12404298b1f1dfc0f05be98cd00b))

## [4.3.0](https://github.com/Datamedrix/support-toolset/compare/v4.2.1...v4.3.0) (2021-07-16)

### Features

* **database/blueprint:** Make the user audit reference restrictions configurable. ([0832864](https://github.com/Datamedrix/support-toolset/commit/0832864fff2eb8ace336fc58f0fdf4afc74af2cf))

## [4.2.1](https://github.com/Datamedrix/support-toolset/compare/v4.2.0...v4.2.1) (2021-07-16)

### Bug Fixes

* **database/schema:** Use ANSI-SQL "no action" for on delete reference restrictions to be more compatible to MS SQL Server. ([db5a51d](https://github.com/Datamedrix/support-toolset/commit/db5a51d316af2ecf334a75d6236888bbb04302da))

## [4.2.0](https://github.com/Datamedrix/support-toolset/compare/v4.1.0...v4.2.0) (2021-07-14)

### Features

* **database/migration:** Add methods to create and drop database schemas if the driver supports it. ([bed749d](https://github.com/Datamedrix/support-toolset/commit/bed749d4a665adf9df2bcad038722dd13aa1b2e5))

## [4.1.0](https://github.com/Datamedrix/support-toolset/compare/v4.0.1...v4.1.0) (2021-07-06)

### Features

* **eloquent:** Use optional schemas also with MSSQL databases. ([71de35d](https://github.com/Datamedrix/support-toolset/commit/71de35d13fd9926adad64eca36f7016026aa1cb2))

## [4.0.1](https://github.com/Datamedrix/support-toolset/compare/v4.0.0...v4.0.1) (2021-07-06)

### Bug Fixes

* **database/schema:** Use Laravel's built-in methods to set the current timestamp instead of using a expression to make them more compatible to other database systems. ([487c5d2](https://github.com/Datamedrix/support-toolset/commit/487c5d274863759d17424cc6792068554990f73e))

## [4.0.0](https://github.com/Datamedrix/support-toolset/compare/v3.4.0...v4.0.0) (2021-06-22)

### Features

* **eloquent:** Add 2 new traits. ([0e5a5b6](https://github.com/Datamedrix/support-toolset/commit/0e5a5b6d71692e6f14d40383676f4bd0e6783ccf))

### BREAKING CHANGES

* **eloquent:** Move trait HasSnakeCaseAttributes to \DMX\Support\Database\Eloquent\Models\Concerns. ([e3ce4f74](https://github.com/Datamedrix/support-toolset/commit/e3ce4f749cf9cbc19c6ab3c780a12f5b1e3913a4))


## [3.4.0](https://github.com/Datamedrix/support-toolset/compare/v3.3.0...v3.4.0) (2021-06-09)

### Features

* **eloquent/models:** Enhance the HasSnakeCaseAttributes trait. ([f0b8080](https://github.com/Datamedrix/support-toolset/commit/f0b8080b4f9d227be72cd714bfb647fab9c9ae2b))

## [3.3.0](https://github.com/Datamedrix/support-toolset/compare/v3.2.1...v3.3.0) (2020-10-29)

### Features

* Add support for laravel framework 7.x and 8.x. ([2d28091](https://github.com/Datamedrix/support-toolset/commit/2d28091))

## [3.2.1](https://github.com/Datamedrix/support-toolset/compare/v3.2.0...v3.2.1) (2020-01-22)


### Bug Fixes

* **model/concerns/DbSchema:** Do not add the db schema twice to the table name! ([3471869](https://github.com/Datamedrix/support-toolset/commit/3471869))

## [3.2.0](https://github.com/Datamedrix/support-toolset/compare/v3.1.0...v3.2.0) (2020-01-21)

### Features

* **eloquent:** Add optional schema name to table name if the database engine does not support db-schemas. ([45d1581](https://github.com/Datamedrix/support-toolset/commit/45d1581))

## [3.1.0](https://github.com/Datamedrix/support-toolset/compare/v3.0.0...v3.1.0) (2020-01-17)

### Features

* **database/schema:** Enhance the blueprint and provide methods to columns used for user audit. ([96cc4d5](https://github.com/Datamedrix/support-toolset/commit/96cc4d5))

## [3.0.0](https://github.com/Datamedrix/support-toolset/compare/v2.3.0...v3.0.0) (2020-01-17)

* **\*:** Move the package to PHP 7.4.

## [2.3.0](https://github.com/Datamedrix/support-toolset/compare/v2.2.1...v2.3.0) (2019-10-31)

### Features

* **database/eloquent:** Add trait to add a optional schema name property to a model. ([9d60f15](https://github.com/Datamedrix/support-toolset/commit/9d60f15))

## [2.2.1](https://github.com/Datamedrix/support-toolset/compare/v2.2.0...v2.2.1) (2019-10-30)

### Bug Fixes

* **database/migrations:** Throw the exception correctly only if no database manager is set and no Laravel helper functions are available. ([74010d5](https://github.com/Datamedrix/support-toolset/commit/74010d5))

## [2.2.0](https://github.com/Datamedrix/support-toolset/compare/v2.1.1...v2.2.0) (2019-10-30)

### Features

* **database:** Add lightly adopted Laravel based migration and blueprint classes. ([83cb5f1](https://github.com/Datamedrix/support-toolset/commit/83cb5f1))

## [2.1.1](https://github.com/Datamedrix/support-toolset/compare/v2.1.0...v2.1.1) (2019-10-25)

### Bug Fixes

* **database:** Remove misplaced migration and blueprint classes. ([05d6d64](https://github.com/Datamedrix/support-toolset/commit/05d6d64))

## [2.1.0](https://github.com/Datamedrix/support-toolset/compare/v2.0.0...v2.1.0) (2019-10-25)

### Features

* **database:** Add lightly adopted (Laravel)migration base class and (Laravel)blueprint. ([f57443e](https://github.com/Datamedrix/support-toolset/commit/f57443e))

## 2.0.0 (2019-09-09)

### Features

* **\*:** Move package to support laravel 6.0.

## 1.1.3 (2019-09-09)

### Fixes

* **\*:** Remove support for laravel 6.0, cause of an deprecated function issue.

## 1.1.2 (2019-09-09)

### Chore

* **\*:** Dependencies updated to support laravel 6.0.

## 1.1.1 (2019-06-06)

### Fixes

* **traits:** Check for an potentially existing method defined within the model before snake case the designated attribute (`getAttribute()`).

## 1.1.0 (2018-09-10)

### Features

* **traits:** add HasSnakeCaseAttributes to use within Eloquent models
    * overloads getAttribute() and setAttribute() to use snake case attribute names
        * Example:
            * **Field in the database:** "my_awesome_field"
            * **Use on model:** $myModel->myAwesomeField

### Refactor

* **traits:** rename ProvidesIdentifierTrait to ProvidesIdentifier

## 1.0.0 (2018-06-21)

### Features

* **traits:** add ProvidesIdentifierTrait
    * Add basic methods to handle text based identifiers like UUID
        * $obj->identifier()  ... returns the identifier saved within the object
