<?php

namespace PHPMetric\Components;

interface Component
{
	public function find(array $token);
	public function value();
}