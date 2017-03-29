<?php

namespace PHPMetric\Helpers;

class EnvHelper implements Helper
{
	public static function run(array $args)
	{
		return self::handler($args);
	}

	private static function handler(array $args)
	{
		$value = getenv($args['key']);

        if ($value !== false)
        	return $value;

 		if(!is_callable($args['default']))
        	return $args['default'];

        $args['default']();
	}
}