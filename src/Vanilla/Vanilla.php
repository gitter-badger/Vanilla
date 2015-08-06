<?php

namespace Vanilla;

class Vanilla
{
    public $vanilla_routes;
    public $vanilla_events;

    function __construct()
    {
        $this -> vanilla_routes = new \ArrayObject([]);
        $this -> vanilla_events = new \ArrayObject([]);
    }

    public function add( $vanilla_object )
    {
        if( $vanilla_object instanceof Route )
        {
            $vanilla_object -> route_uri = dirname( $_SERVER['PHP_SELF'] ) . $vanilla_object -> route_uri;
            $vanilla_object -> route_method = strtoupper( $vanilla_object -> route_method );
            $this -> vanilla_routes[] = $vanilla_object;
        }
        else if( $vanilla_object instanceof Event )
        {
            $this -> vanilla_events[] = $vanilla_object;
        }
    }

    public function trig( $event_name )
    {
        /** @var $vanilla_event Event */
        foreach( $this -> vanilla_events as $vanilla_event )
        {
            if( !strcmp( strtoupper( $vanilla_event -> event_name ), strtoupper( $event_name ) ) )
            {
                call_user_func( $vanilla_event -> event_callback );
            }
        }
    }

    public function play()
    {
        $this -> trig('after');

        $vanilla_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
        $vanilla_method = strtoupper( $_SERVER['REQUEST_METHOD'] );

        /** @var $vanilla_route Route */
        foreach( $this -> vanilla_routes as $vanilla_route )
        {
            if( $vanilla_route -> uricmp( $vanilla_uri ) && !strcmp( $vanilla_route -> route_method, $vanilla_method ) )
            {
                $vanilla_parameters = $vanilla_route -> parameters( $vanilla_uri );
                call_user_func_array( $vanilla_route -> route_callback, $vanilla_parameters );
            }
        }

        $this -> trig('before');
    }
}