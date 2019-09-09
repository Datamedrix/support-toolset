# Change Log

All notable changes to this project will be documented in this file.

# 1.1.2 (2019-09-09)

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
