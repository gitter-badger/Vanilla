<?php

namespace Vanilla;

class Event
{
    public $event_name;
    public $event_callback;

    function __construct( $event_name, $event_callback )
    {
        $this -> event_name = strtoupper( $event_name );
        $this -> event_callback = $event_callback;
    }
}