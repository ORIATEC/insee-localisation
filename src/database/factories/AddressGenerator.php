<?php


namespace ORIATEC\InseeLocalisation\Database\Factories;


use App\Models\Insee\Localisation;
use App\Models\Insee\LocalisationCity;

class AddressGenerator
{
    static function random($city_code=false) : LocalisationCity{
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
