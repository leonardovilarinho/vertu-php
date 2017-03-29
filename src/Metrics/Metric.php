<?php

namespace PHPMetric\Metrics;

interface Metric
{
	public function run(array $token);
	public function total();
}