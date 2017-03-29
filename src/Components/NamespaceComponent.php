<?php

namespace PHPMetric\Components;

class NamespaceComponent implements Component
{
	private $value = '';

	public function find(array $token)
	{
		return $this->handler($token);
	}

	private function handler(array $tokenArray)
	{
		$namespace = false;
		foreach ($tokenArray as $item) {
			$c_token = is_int($item[0]) ? token_name($item[0]) : '';

			if( $namespace and $c_token != 'T_WHITESPACE' and isset($item[1]) )
				$this->value .= $item[1];
			else if( $namespace and $item == ';' )
				break;
			else if( $c_token == 'T_NAMESPACE' )
				$namespace = true;
		}
	}

	public function value()
	{
		return $this->value;
	}
}