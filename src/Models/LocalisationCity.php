<?php


namespace ORIATEC\InseeLocalisation\Models;


class LocalisationCity
{

    public $insee_code;
    public $name;
    public $zipcode;
    public $normalized_name;
    public $normalized_locality;
    public $lat;
    public $lng;

    public $department;
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
