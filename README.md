# Pimcore YML fixtures

Based on [Alice](https://github.com/nelmio/alice)

### How to install

```sh
composer require --dev youwe/pimcore-fixtures
```
*This plugin is only for DEV, do NOT install on a production server*

### How to load fixtures
Make sure "PimcoreFixtures" is enabled in `/website/var/config/extensions.php`
Place your fixtures in `/website/var/plugins/PimcoreFixtures/fixtures` named "001_object_name.yml", "002_object_name.yml" etc.

Load them with:
#### Console
```sh
php pimcore/cli/console.php fixture:load --with-cache
```
Load individual files with --files comma separated files without yml extension:
#### Console
```sh
php pimcore/cli/console.php fixture:load --files filename1,filename2
```

#### Backend
Go to Extensions \ PimcoreFixtures \ plugin settings \ Load fixtures

### Fixtures generator (still beta)

#### Backend
Go to Extensions \ PimcoreFixtures \ plugin settings

1. Object path: the root where to start generating fixtures
2. Object name: Recommended would be the object class ex. product, will translate into at [PIMCORE_ROOT]/website/var/plugins/PimcoreFixtures/fixtures/000_product.yml
3. Max level deep: Will stop at the specified level (default 1) and if greater then 1 then level will be appended to filename
4. Click generate. The generated files should be at [PIMCORE_ROOT]/website/var/plugins/PimcoreFixtures/fixtures/*.yml

#### Console
```sh
php pimcore/cli/console.php fixtures:generate
```

### Delete object/assets/documents

```sh****
php pimcore/cli/console.php fixtures:delete-path  -t object -p /products
```


### Useful links 
* [Alice documentation](https://github.com/nelmio/alice)
* [Faker documentation](https://github.com/fzaninotto/Faker)
* [Yml documentation](http://symfony.com/doc/current/components/yaml/yaml_format.html)


Todo:
* Support for following fields one fixtures:generate
    * Object\ClassDefinition\Data\Classificationstore
    * Object\ClassDefinition\Data\Fieldcollection
    * Object\ClassDefinition\Data\ObjectsMetadata
    * Object\ClassDefinition\Data\MultihrefMetadata
    * Object\ClassDefinition\Data\Objectbricks

* security checks / user restrictions
* better error handling in ext-js interface
* live progress when loading fixtures
