<?php

namespace PHPMetric\Components;

class NameComponent implements Component
{
	private $value = '';

	public function find(array $token)
	{
		return $this->handler($token);
	}

	private function handler(array $tokenArray)
	{
		$class = false;
		foreach ($tokenArray as $item) {
			$c_token = is_int($item[0]) ? token_name($item[0]) : '';

			if( $class and $c_token != 'T_WHITESPACE' and isset($item[1]) ) {
				$this->value = $item[1];
				break;
			}

			if( $c_token == 'T_CLASS' or $c_token == 'T_INTERFACE')
				$class = true;
		}
	}

	public function value()
	{
		return $this->value;
	}
}