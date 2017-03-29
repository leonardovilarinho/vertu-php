<?php

namespace PHPMetric\Components;

class MethodsComponent implements Component
{
	private $value = [];

	private $filter = ['T_PUBLIC', 'T_PRIVATE', 'T_PROTECTED', 'T_CONSTANT'];

	public function find(array $token)
	{
		return $this->handler($token);
	}

	private function handler(array $tokenArray)
	{
		$count = 1;
		$method = false;
		$scope = '';
		$name = '';
		$content = [];

		foreach ($tokenArray as $item) {
			$count ++;

			$c_token = is_int($item[0]) ? token_name($item[0]) : '';

			if( ($count >= count($tokenArray) or $c_token == 'T_FUNCTION' or
				  in_array($c_token, $this->filter))
				and $scope != '' and $method and $name != '') {
				$this->value[] = [
					'scope'		=> scope( $scope ),
					'name'		=> $name,
					'content'	=> $content
				];

				$method = false;
				$scope = '';
				$name = '';
				$content = [];
			}
			else {

				$notW = $c_token != 'T_WHITESPACE';

				if( $scope != '' and $method and $name != '')
					$content[] = $item;

				else if($scope != '' and $method and $c_token == 'T_STRING' and isset($item[1]) and $name == '')
					$name = $item[1];

				else if( in_array($c_token, $this->filter) and !$method )
					$scope = $c_token;

				else if( $c_token == 'T_FUNCTION' and !$method ) {
					if($scope == '')
						$scope = 'T_PUBLIC';
					$method = true;
				}
			}
		}
	}

	public function value()
	{
		return $this->value;
	}

	public function set($value)
	{
		$this->value = $value;
	}
}