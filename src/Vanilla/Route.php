<?php

namespace Vanilla;

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

    function uricmp( $route_uri )
    {
        $route_uri_this = array_filter( explode( '/', $this -> route_uri ) );
        $route_uri_comp = array_filter( explode( '/', $route_uri ) );

        if( count( $route_uri_this ) != count( $route_uri_comp ) )
        {
            return false;
        }

        $route_uri_combine = array_combine( $route_uri_this, $route_uri_comp );
        foreach( $route_uri_combine as $key => $value )
        {
            if( strcmp( substr( $key, 0, 1 ), '$' ) && strcmp( $key, $value ) )
            {
                return false;
            }
        }

        return true;
    }

    function parameters( $route_uri )
    {
        $vanilla_parameters = [];

        $route_uri_this = array_filter( explode( '/', $this -> route_uri ) );
        $route_uri_comp = array_filter( explode( '/', $route_uri ) );

        $route_uri_combine = array_combine( $route_uri_this, $route_uri_comp );
        foreach( $route_uri_combine as $key => $value )
        {
            if( !strcmp( substr( $key, 0, 1 ), '$') )
            {
                $vanilla_parameters[ substr( $key, 1 ) ] = $value;
            }
        }

        return $vanilla_parameters;
    }
}