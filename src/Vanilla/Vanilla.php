<?php

namespace Vanilla;

class Vanilla
{
    /** @var \ArrayObject $vanilla_routes */
    public $vanilla_routes;

    /** @var \ArrayObject $vanilla_events */
    public $vanilla_events;

    /** @var \ArrayObject $vanilla_modules */
    public $vanilla_modules;

    /** @var Session $vanilla_session */
    public $vanilla_session;

    /** @var string $vanilla_application */
    public $vanilla_application;

    function __construct( $vanilla_application = 'Vanilla' )
    {
        $this -> vanilla_routes = new \ArrayObject([]);
        $this -> vanilla_events = new \ArrayObject([]);
        $this -> vanilla_modules = new \ArrayObject([]);
        $this -> vanilla_session = new Session( $vanilla_application );
        $this -> vanilla_application = $vanilla_application;
    }

    public function get( $route_uri, $route_callback )
    {
        $this -> add_route('get', $route_uri, $route_callback );
    }

    public function post( $route_uri, $route_callback )
    {
        $this -> add_route('post', $route_uri, $route_callback );
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

    public function ops( $event_callback )
    {
        $this -> add_event( 'ops', $event_callback );
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

    public function extend( $module )
    {
        if( $module instanceof Module )
        {
            /** @var Module $vanilla_module */
            foreach( $this -> vanilla_modules as $vanilla_module )
            {
                if( !strcmp( $vanilla_module -> module_name, $module -> module_name ) )
                {
                    return $vanilla_module;
                }
            }

            $this -> vanilla_modules[] = $module;
        }
    }

    public function module( $module_name )
    {
        /** @var Module $vanilla_module */
        foreach( $this -> vanilla_modules as $vanilla_module )
        {
            if( !strcmp( $vanilla_module -> module_name, $module_name ) )
            {
                return $vanilla_module;
            }
        }
    }

    public function run()
    {
        $vanilla_uri = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
        $vanilla_method = strtoupper( $_SERVER['REQUEST_METHOD'] );
        $vanilla_ops = true;

        /** @var $vanilla_route Route */
        foreach( $this -> vanilla_routes as $vanilla_route )
        {
            if( $vanilla_route -> uricmp( $vanilla_uri ) && !strcmp( $vanilla_route -> route_method, $vanilla_method ) )
            {
                $this -> event('before');

                $vanilla_parameters = $vanilla_route -> parameters( $vanilla_uri );
                call_user_func_array( $vanilla_route -> route_callback, $vanilla_parameters );
                $vanilla_ops = false;

                $this -> event('after');
            }
        }

        if( $vanilla_ops )
        {
            $this -> event('ops');
        }
    }
}