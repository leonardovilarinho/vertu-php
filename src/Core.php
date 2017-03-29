<?php

namespace PHPMetric;

use PHPMetric\Patterns\Singleton;
use PHPMetric\Helpers\EnvHelper;


class Core extends Singleton
{
	public static $color;
	public static $classes = [];
	private static $config;

	protected function init()
	{
		self::$color = new \Colors\Color;

		self::$config['project'] = EnvHelper::run([
			'key' => 'PROJECT',
			'default' => function() {
				die( color('Projeto não encontrado')->bold->bg_red );
			}
		]);

		self::$config['exclude_dir'] = EnvHelper::run([
			'key' => 'EXCLUDE_DIR',
			'default' => 'php'
		]);

		self::$config['extension'] = EnvHelper::run([
			'key' => 'EXTENSION',
			'default' => '*.php'
		]);

		self::$config['ranking'] = EnvHelper::run([
			'key' => 'RANKING',
			'default' => '5'
		]);

		self::$config['omit'] = EnvHelper::run([
			'key' => 'OMIT',
			'default' => 'interface'
		]);

	}

	public static function config()
	{
		return self::$config;
	}
}