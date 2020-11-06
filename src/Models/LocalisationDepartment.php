<?php


namespace ORIATEC\InseeLocalisation\Models;


/**
 * Class LocalisationDepartment
 * @package ORIATEC\InseeLocalisation\Models
 */
class LocalisationDepartment
{
    /**
     * @var
     */
    public $code;
    /**
     * @var
     */
    public $name;

    /**
     * @var LocalisationRegion
     */
    public $region;

    function __construct($data){
        $this->code = $data->department_code;
        $this->name = $data->department_name;

        $this->region = new LocalisationRegion($data);
    }

}
