<?php

if( ! function_exists('config') ) {
	function config() {
		return \PHPMetric\Core::config();
	}
}

if( ! function_exists('color') ) {
	function color($msg) {
		$c = \PHPMetric\Core::$color;
		return $c($msg);
	}
}

if( ! defined('TAB') )
	define('TAB', "\t");


if( ! function_exists('syntax') ) {
	function syntax($name, $file) {
		$syntax = new \Syntax\Php();
		$resultCheck = $syntax->check($file);

		if( ! $resultCheck['validity'] ) {
			echo color( '!! Syntax Error !!' )->bold->bg_red . PHP_EOL;
			echo 'File: ' . $name . PHP_EOL;
			foreach ($resultCheck['errors'] as $value)
				echo TAB . '> '. color( $value['message'] )->bold->red . PHP_EOL;
			die();
		}
	}
}


if( ! function_exists('_clone') ) {
	function _clone($var) {
		if( ! is_array($var) )
			return new $var();

		$clone = [];
		foreach ($var as $value)
			$clone[] = new $value();

		return $clone;
	}
}


if( ! function_exists('scope') ) {
	function scope($var) {
		return strtolower( str_replace('T_', '', $var) );
	}
}


if( ! function_exists('progress') ) {
	function progress($step, &$progress, $char) {
		$progress += $step;
		for ($i = 0; $i < $step; $i++) {
		    if($progress <= 25)
		        echo color($char)->bg_red;
		    else if($progress <= 60)
		        echo color($char)->bg_yellow;
		    else
		        echo color($char)->bg_green;
		}
	}
}

