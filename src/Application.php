<?php

namespace PHPMetric;

use Webmozart\Console\Config\DefaultApplicationConfig;
use Webmozart\Console\Api\Args\Format\Option;

class Application extends DefaultApplicationConfig
{
    protected function configure()
    {
        parent::configure();

        $app = \PHPMetric\Core::instance();

        $this
            ->setName('MetricPHP')
            ->setVersion('0.0.1')

            ->beginCommand('run')
                ->markDefault()
                ->setDescription('Run analizer metrics')
                ->setHandler(new \PHPMetric\Commands\RunCommand())
                ->addOption('html', null, Option::NO_VALUE, 'Export to HTML')
            ->end()
        ;

        echo PHP_EOL. '---' . PHP_EOL;
        echo '- '  . color('PHP Metrics')->bold->magenta . PHP_EOL;
        echo '- '  . color('By Leonardo Vilarinho')->bold . PHP_EOL;
        echo '---' . PHP_EOL.PHP_EOL;
    }
}