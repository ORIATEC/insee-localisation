<?php


namespace ORIATEC\InseeLocalisation\Models;


/**
 * Class LocalisationCity
 * @package ORIATEC\InseeLocalisation\Models
 */
class LocalisationCity
{

    /**
     * @var
     */
    public $insee_code;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $zipcode;
    /**
     * @var string
     */
    public $normalized_name;
    /**
     * @var string
     */
    public $normalized_locality;
    /**
     * @var null
     */
    public $lat;
    /**
     * @var null
     */
    public $lng;

    /**
     * @var LocalisationDepartment
     */
    public $department;
    /**
     * @var LocalisationRegion
     */
    public $region;



    function __construct($data){
        $this->insee_code = $data->insee_city_code;
        $this->name = $data->city_name;
        $this->zipcode = $data->city_zipcode;
        $this->normalized_name = $data->city_name_normalize ?? '';
        $this->normalized_locality = $data->city_locality_name_normalize ?? '';
        $this->lat = $data->lat ?? null;
        $this->lng = $data->lng ?? null;

        $this->department = new LocalisationDepartment($data);
        $this->region = new LocalisationRegion($data);

    }

}
