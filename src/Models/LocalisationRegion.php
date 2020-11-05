<?php


namespace ORIATEC\InseeLocalisation\Models;


class LocalisationRegion
{

    public $code;
    public $name;

    function __construct($data){
        $this->code = $data->region_code;
        $this->name = $data->region_name;
    }



}
