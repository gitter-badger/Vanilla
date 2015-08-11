<?php

namespace Vanilla;

class Variables
{

    public $variables;

    function __construct()
    {
        $this -> variables = [];
    }

    public function set( $variable_key, $variable_value )
    {
        $this -> variables[ $variable_key ] = $variable_value;
    }

    public function delete( $variable_key )
    {
        unset( $this -> variables[ $variable_key ] );
    }

    public function get( $variable_key )
    {
        return $this -> variables[ $variable_key ];
    }
}