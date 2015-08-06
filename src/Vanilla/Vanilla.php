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

    public function get( $route_uri, $route_callback )
    {
        $this -> add_route('GET', $route_uri, $route_callback );
    }

    public function post( $route_uri, $route_callback )
    {
        $this -> add_route('POST', $route_uri, $route_callback );
    }

    private function add_route( $route_method, $route_uri, $route_callback )
    {
        $vanilla_route = new Route( $route_method, $route_uri, $route_callback );
        $this -> vanilla_routes[] = $vanilla_route;
    }

    public function before( $event_callback )
    {
        $this -> add_event( 'before', $event_callback );
    }

    public function after( $event_callback )
    {
        $this -> add_event( 'after', $event_callback );
    }

    private function add_event( $event_name, $event_callback )
    {
        $vanilla_event = new Event( $event_name, $event_callback );
        $this -> vanilla_events[] = $vanilla_event;
    }

    public function event( $event_name )
    {
        $event_name = strtoupper( $event_name );

        /** @var $vanilla_event Event */
        foreach( $this -> vanilla_events as $vanilla_event )
        {
            if( !strcmp( $vanilla_event -> event_name , $event_name ) )
            {
                call_user_func( $vanilla_event -> event_callback );
            }
        }
    }

    public function run()
    {
        $this -> event('after');

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

        $this -> event('before');
    }
}