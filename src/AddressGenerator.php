<?php


namespace ORIATEC\InseeLocalisation;


use ORIATEC\InseeLocalisation\Models\Localisation;
use ORIATEC\InseeLocalisation\Models\LocalisationCity;

class AddressGenerator
{
    static function random() : LocalisationCity{
        $data = Localisation::query()->inRandomOrder()->first();

        return new LocalisationCity($data);
    }

    static function city($zipcode) : LocalisationCity{
        return Localisation::cities($zipcode)->first();
    }

    static function inDepartment($department_code) : LocalisationCity{
        return Localisation::citiesInDepartment($department_code)->random();
    }

    static function inRegion($region_code) : LocalisationCity{
        return Localisation::citiesInRegion($region_code)->random();
    }
}
