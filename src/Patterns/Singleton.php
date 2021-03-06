<?php

namespace PHPMetric\Patterns;

class Singleton
{
	public static function instance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    protected function init()
    {
    }

    protected function __construct()
    {
        $this->init();
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}