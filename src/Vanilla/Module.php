<?php

namespace Vanilla;

class Module
{
    public $vanilla_application;
    public $module_name;

    function __construct( $vanilla_application )
    {
        $this -> vanilla_application = $vanilla_application;
        $this -> module_name = strtolower( get_class( $this ) );
    }
}