<?php

namespace PHPMetric\Components;

class TypeComponent implements Component
{
	private $value = '';

	public function find(array $token)
	{
		return $this->handler($token);
	}

	private function handler(array $tokenArray)
	{
		$type = '';
		$abstract = false;
		foreach ($tokenArray as $item) {
			$c_token = is_int($item[0]) ? token_name($item[0]) : '';

			if( $c_token == 'T_CLASS' or $c_token == 'T_INTERFACE' ) {

				if($abstract)
					$this->value = 'abstract class';
				else if($c_token != '')
					$this->value = strtolower( explode('_', $c_token)[1] );
				break;
			}
			else
				$this->value = 'file';

			if( $c_token == 'T_ABSTRACT' )
				$abstract = true;
		}
	}

	public function value()
	{
		return $this->value;
	}
}