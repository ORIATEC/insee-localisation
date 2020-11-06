<?php


namespace ORIATEC\InseeLocalisation\Models;


/**
 * Class LocalisationRegion
 * @package ORIATEC\InseeLocalisation\Models
 */
class LocalisationRegion
{

    /**
     * @var
     */
    public $code;
    /**
     * @var
     */
    public $name;

    function __construct($data){
        $this->code = $data->region_code;
        $this->name = $data->region_name;
    }



}
