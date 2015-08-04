<?php

namespace Vanilla;

class Vanilla
{
    public $vanilla_routes;
    public $vanilla_modules;

    function __construct()
    {
        $this -> vanilla_routes = new \ArrayObject([]);
        $this -> vanilla_modules = new \ArrayObject([]);
    }

    /** @param $vanilla_route Route */
    public function add( $vanilla_route )
    {
        if( $vanilla_route instanceof Route )
        {
            $vanilla_route -> route_uri = dirname( $_SERVER['PHP_SELF'] ) . $vanilla_route -> route_uri;
            $vanilla_route -> route_method = strtoupper( $vanilla_route -> route_method );
            $this -> vanilla_routes[] = $vanilla_route;
        }
    }

    public function play()
    {
        $vanilla_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
        $vanilla_method = strtoupper( $_SERVER['REQUEST_METHOD'] );

        /** @var $route Route */
        foreach( $this -> vanilla_routes as $route )
        {
            if( !strcmp( $route -> route_uri, $vanilla_uri ) && !strcmp( $route -> route_method, $vanilla_method ) )
            {
                call_user_func( $route -> route_callback );
            }
        }
    }
}

class Route
{
    public $route_method;
    public $route_uri;
    public $route_callback;

    function __construct( $route_method, $route_uri, $route_callback )
    {
        $this -> route_uri = $route_uri;
        $this -> route_method = $route_method;
        $this -> route_callback = $route_callback;
    }
}

class Module
{
    private $module_methods = [];

    function __construct()
    {

    }

    function __call( $module_name, $module_arguments )
    {
        print 'Calling ' . $module_name . 'with arguments ' . implode( ', ', $module_arguments );
    }
}