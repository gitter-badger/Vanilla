<?php

namespace Vanilla;

class Session
{
    function __construct( $session_name = null )
    {
        session_name( $session_name );
        session_start();
    }

    function write( $session_key, $session_value )
    {
        $_SESSION[ $session_key ] = $session_value;
    }

    function read( $session_key )
    {
        return $_SESSION[ $session_key ];
    }

    function delete( $session_key )
    {
        unset( $_SESSION[ $session_key ] );
    }

    function destroy()
    {
        session_destroy();
    }
}