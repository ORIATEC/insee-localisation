# Laravel Insee Localisation

This package provide an implementation of Insee French Localisation Data with a import command

## Installation

Add the ORIATEC private packagist repositories

```bash
composer config repositories.private-packagist composer https://repo.packagist.com/oriatec/
```

Install the package

```bash
composer require oriatec/laravel-insee-localisation
```

Run migrations

```bash
php artisan migrate
```
## Usage

### Import Insee Data

To import Insee Data, run

```bash
php artisan insee:import
```

### Use the data in your application

#### Model LocalisationCity

Represent a city with all informations, the department and region.

#### Model LocalisationDepartment

Represent a department with all informations and region

#### Model LocalisationRegion

Represent a region

#### Eloquent Model Localisation

Is the Eloquent Model use to request the database. 

It provides static method to generate LocalisationCity, LocalisationDepartment or LocalisationRegion

```php
use ORIATEC\InseeLocalisation\Models\Localisation;

// Random Localisation
$city = Localisation::randomCity();
$department = Localisation::randomDepartment();
$region = Localisation::randomRegion();

// Localisation Check
Localisation::cityIsInDepartment($zipcode, $department_code);
Localisation::cityIsInRegion($zipcode, $region_code);
Localisation::departmentIsInRegion($department_code, $region_code);

// City 
$cities = Localisation::cities();
$cities = Localisation::citiesInDepartment($department_code);
$cities = Localisation::citiesInRegion($region_code);

$city = Localisation::city($zipcode);

// Department
$departments = Localisation::departments();
$departments = Localisation::departmentsInRegion($region_code);
$department = Localisation::department($department_code);
$department = Localisation::departmentForCity($zipcode);

// Region

$regions = Localisation::regions();
$region = Localisation::region();
$region = Localisation::regionForDepartment($department_code);
$region = Localisation::regionForCity($zipcode);
```


## Changelog

Please see [changelog.md](changelog.md) for what has changed recently.

## License

This package belongs to [ORIATEC SARL](https://oriatec.fr). You must have an authorization to use it.
