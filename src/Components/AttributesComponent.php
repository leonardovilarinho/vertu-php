<?php

namespace PHPMetric\Components;

class AttributesComponent implements Component
{
	private $value = [];

	private $filter = ['T_PUBLIC', 'T_PRIVATE', 'T_PROTECTED', 'T_CONSTANT'];

	public function find(array $token)
	{
		return $this->handler($token);
	}

	private function handler(array $tokenArray)
	{
		$scope = '';
		foreach ($tokenArray as $item) {
			$c_token = is_int($item[0]) ? token_name($item[0]) : '';

			if( $scope != '' and $c_token != 'T_WHITESPACE' and isset($item[1]) ) {
				if($c_token != 'T_FUNCTION')
					$this->value[] = [
						'name' => $item[1],
						'scope' => scope( $scope )
					];

				$scope = '';
			}
			else if( in_array($c_token, $this->filter))
				$scope = $c_token;
		}
	}

	public function value()
	{
		return $this->value;
	}
}