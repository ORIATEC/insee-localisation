<?php

namespace ORIATEC\InseeLocalisation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Insee\Localisation
 *
 * @property int $id
 * @property string $insee_city_code
 * @property string $city_name
 * @property string $city_name_uppercase
 * @property string $city_zipcode
 * @property string|null $city_name_normalize
 * @property string|null $city_locality_name_normalize
 * @property string $department_code
 * @property string $department_name
 * @property string $region_code
 * @property string $region_name
 * @property string|null $lat
 * @property string|null $lng
 */
class Localisation extends Model
{
    use HasFactory;

    protected $table = "insee_localisations";

    public $timestamps = false;

    protected $fillable = [
        'insee_city_code',
        'city_name','city_name_uppercase', 'city_zipcode',
        'city_name_normalize','city_locality_name_normalize',
        'department_code', 'department_name',
        'region_code', 'region_name',
        'lat', 'lng'
    ];

    /**
     * @return LocalisationCity
     */
    static function randomCity(): LocalisationCity{
        $data = Localisation::inRandomOrder()->firstOrFail();
        return new LocalisationCity($data);
    }

    /**
     * @return LocalisationDepartment
     */
    static function randomDepartment(): LocalisationDepartment{
        $data = Localisation::query()->selectRaw('department_code, department_name, region_code, region_name')->distinct('department_code')->inRandomOrder()->firstOrFail();
        return new LocalisationDepartment($data);
    }

    /**
     * @return LocalisationRegion
     */
    static function randomRegion(): LocalisationRegion{
        $data = Localisation::query()->select(['region_code', 'region_name'])->groupBy('region_code', 'region_name')->inRandomOrder()->firstOrFail();
        return new LocalisationRegion($data);
    }

    /**
     * @param $zipcode
     * @param $department_code
     * @return bool
     */
    static function cityIsInDepartment($zipcode, $department_code) : bool{
        return Localisation::where('city_zipcode', '=', $zipcode)->where('department_code', '=', $department_code)->count() > 0;
    }

    /**
     * @param $zipcode
     * @param $region_code
     * @return bool
     */
    static function cityIsInRegion($zipcode, $region_code) : bool{
        return Localisation::where('city_zipcode', '=', $zipcode)->where('region_code', '=', $region_code)->count() > 0;
    }

    /**
     * @param $department_code
     * @param $region_code
     * @return bool
     */
    static function departmentIsInRegion($department_code, $region_code) : bool{
        return Localisation::where('department_code', '=', $department_code)->where('region_code', '=', $region_code)->count() > 0;
    }

    /**
     * @param $zipcode
     * @return Collection
     */
    static function city($zipcode) : LocalisationCity{
        $data = Localisation::where('city_zipcode', '=', $zipcode)->firstOrFail();
        return new LocalisationCity($data);
    }

    /**
     * @param $zipcode
     * @return Collection
     */
    static function cities() : Collection{
        return Localisation::all()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    /**
     * @param $region_code
     * @return Collection
     */
    static function citiesInRegion($region_code) : Collection{
        return Localisation::where('region_code', '=', $region_code)->get()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    /**
     * @param $department_code
     * @return Collection
     */
    static function citiesInDepartment($department_code) : Collection{
        return Localisation::where('department_code', '=', $department_code)->get()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    /**
     * @param $zipcode
     * @return LocalisationDepartment
     */
    static function departmentForCity($zipcode) : LocalisationDepartment{
        $data =  Localisation::query()->select(['department_code', 'department_name'])->where('city_zipcode', '=', $zipcode)->firstOrFail();
        return new LocalisationDepartment($data);
    }

    /**
     * @param $department_code
     * @return LocalisationDepartment
     */
    static function department($department_code) : LocalisationDepartment{
        $data = Localisation::query()->select(['department_code', 'department_name'])->where('department_code', '=', $department_code)->firstOrFail();
        return new LocalisationDepartment($data);
    }

    /**
     * @return Collection
     */
    static function departments() : Collection{
        return Localisation::query()->selectRaw('department_code, department_name, region_code, region_name')->distinct('department_code')->get()->map(function($data){
            return new LocalisationDepartment($data);
        });
    }

    /**
     * @param $region_code
     * @return Collection
     */
    static function departmentsInRegion($region_code) : Collection{
        return Localisation::query()->selectRaw('department_code, department_name, region_code, region_name')->where('region_code', '=', $region_code)->distinct('department_code')->get()->map(function($data){
            return new LocalisationDepartment($data);
        });
    }

    /**
     * @param $region_code
     * @return LocalisationRegion
     */
    static function region($region_code) : LocalisationRegion{
        $data =  Localisation::query()->select(['region_code', 'region_name'])->where('region_code', '=', $region_code)->firstOrFail();

        return new LocalisationRegion($data);
    }

    /**
     * @param $department_code
     * @return LocalisationRegion
     */
    static function regionForDepartment($department_code) : LocalisationRegion{
        $data = Localisation::query()->select(['region_code', 'region_name'])->where('department_code', '=', $department_code)->firstOrFail();

        return new LocalisationRegion($data);
    }

    /**
     * @param $zipcode
     * @return LocalisationRegion
     */
    static function regionForCity($zipcode) : LocalisationRegion{
        $data = Localisation::query()->select(['region_code', 'region_name'])->where('city_zipcode', '=', $zipcode)->firstOrFail();

        return new LocalisationRegion($data);
    }

    /**
     * @return Collection
     */
    static function regions() : Collection{
        return Localisation::query()->select(['region_code', 'region_name'])->groupBy('region_code', 'region_name')->get()->map(function($data){
            return new LocalisationRegion($data);
        });
    }
}
