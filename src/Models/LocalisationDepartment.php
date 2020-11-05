<?php


namespace ORIATEC\InseeLocalisation\Models;


class LocalisationDepartment
{
    public $code;
    public $name;

    public $region;

    function __construct($data){
        $this->code = $data->department_code;
        $this->name = $data->department_name;

        $this->region = new LocalisationRegion($data);
    }

}
