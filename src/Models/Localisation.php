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
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereCityLocalityNameNormalize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereCityNameNormalize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereCityNameUppercase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereCityZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereDepartmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereInseeCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localisation whereRegionName($value)
 * @mixin \Eloquent
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

    static function cityIsInDepartment($zipcode, $department_code) : bool{
        return Localisation::where('city_zipcode', '=', $zipcode)->where('department_code', '=', $department_code)->count() > 0;
    }

    static function cityIsInRegion($zipcode, $region_code) : bool{
        return Localisation::where('city_zipcode', '=', $zipcode)->where('region_code', '=', $region_code)->count() > 0;
    }

    static function departmentIsInRegion($department_code, $region_code) : bool{
        return Localisation::where('department_code', '=', $department_code)->where('region_code', '=', $region_code)->count() > 0;
    }

    static function cities($zipcode) : Collection{
        return Localisation::where('city_zipcode', '=', $zipcode)->get()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    static function citiesInRegion($region_code) : Collection{
        return Localisation::where('region_code', '=', $region_code)->get()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    static function citiesInDepartment($department_code) : Collection{
        return Localisation::where('department_code', '=', $department_code)->get()->map(function($data){
            return new LocalisationCity($data);
        });
    }

    static function departmentForCity($zipcode) : LocalisationDepartment{
        $data =  Localisation::query()->select(['department_code', 'department_name'])->where('city_zipcode', '=', $zipcode)->firstOrFail();
        return new LocalisationDepartment($data);
    }

    static function department($department_code) : LocalisationDepartment{
        $data = Localisation::query()->select(['department_code', 'department_name'])->where('department_code', '=', $department_code)->firstOrFail();
        return new LocalisationDepartment($data);
    }

    static function departments() : Collection{
        return Localisation::query()->selectRaw('department_code, department_name, region_code, region_name')->distinct('department_code')->get()->map(function($data){
            return new LocalisationDepartment($data);
        });
    }

    static function departmentsInRegion($region_code) : Collection{
        return Localisation::query()->selectRaw('department_code, department_name, region_code, region_name')->where('region_code', '=', $region_code)->distinct('department_code')->get()->map(function($data){
            return new LocalisationDepartment($data);
        });
    }

    static function region($region_code) : LocalisationRegion{
        $data =  Localisation::query()->select(['region_code', 'region_name'])->where('region_code', '=', $region_code)->firstOrFail();

        return new LocalisationRegion($data);
    }

    static function regionForDepartment($department_code) : LocalisationRegion{
        $data = Localisation::query()->select(['region_code', 'region_name'])->where('department_code', '=', $department_code)->firstOrFail();

        return new LocalisationRegion($data);
    }

    static function regionForCity($zipcode) : LocalisationRegion{
        $data = Localisation::query()->select(['region_code', 'region_name'])->where('city_zipcode', '=', $zipcode)->firstOrFail();

        return new LocalisationRegion($data);
    }

    static function regions() : Collection{
        return Localisation::query()->select(['region_code', 'region_name'])->groupBy('region_code', 'region_name')->get()->map(function($data){
            return new LocalisationRegion($data);
        });
    }
}
