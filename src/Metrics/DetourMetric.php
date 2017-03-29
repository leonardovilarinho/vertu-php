<?php

namespace PHPMetric\Metrics;

class DetourMetric implements Metric
{
	private $counter = [
		'T_IF',
		'T_ELSEIF',
		'T_ELSE',
		'T_FOR',
		'T_FOREACH',
		'T_WHILE',
		'T_CASE',
		'T_GOTO',
	];

	private $total = 0;

	public function run(array $token)
	{
		return $this->calculate($token);
	}

	private function calculate(array $token)
	{
		$number = 0;

		foreach ($token as $value)
		{
			$tag = is_int($value[0])
				? token_name($value[0])
				: ''
			;

			if($value == '?' or $value == ':' or in_array($tag, $this->counter))
				$number ++;
		}

		$this->total = $number;
	}

	public function total()
	{
		return $this->total;
	}
}