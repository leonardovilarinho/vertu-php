<?php

namespace PHPMetric;

use \PHPMetric\Helpers\Colors;

class Collector
{
	private $components;
	private $file;
	private $lines;
	private $metrics = [];

	public function __construct($filename, $metrics, $components)
	{
		$this->file = $filename;
		$buffer = file_get_contents($filename);
		syntax( $filename, $buffer );

		$token = token_get_all( $buffer );
		$this->lines = substr_count($buffer, "\n");
		unset( $buffer );

		$this->run($token, $metrics, $components);
	}

	private function run($token, $metrics, $components)
	{
		$this->components = $this->findComponents( _clone($components), $token );

		if( count( $this->el('methods')->value() ) > 0 )
			$this->metricsInMethods($metrics);
		else
			$this->metrics = $this->runMetrics( _clone($metrics), $token);
	}

	private function metricsInMethods($metrics)
	{
		$methods = $this->el('methods');

		$ms = [];
		foreach ($methods->value() as $m)
			$ms[] = [
				'metrics' 	=> $this->runMetrics(_clone($metrics), $m['content']),
				'name'		=> $m['name'],
				'scope'		=> $m['scope']
			];

		$methods->set($ms);
	}

	public function el($name)
	{
		$name = ucfirst( strtolower($name) );

		foreach ($this->components as $component)
			if(get_class($component) == 'PHPMetric\Components\\'.$name.'Component')
				return $component;

		return null;
	}

	private function findComponents($componentsList, $token)
	{
		foreach ($componentsList as &$component)
			if($component instanceof \PHPMetric\Components\Component)
				$component->find($token);

		return $componentsList;
	}

	private function runMetrics($metrics, $token)
	{
		foreach ($metrics as &$metric)
			if($metric instanceof \PHPMetric\Metrics\Metric)
				$metric->run($token);

		return $metrics;
	}

	public function lines()
	{
		return $this->lines;
	}

	public function metrics()
	{
		return $this->metrics;
	}

	public function file()
	{
		return $this->file;
	}

	public function hasMetrics()
	{
		return count( $this->metrics) > 0;
	}
}