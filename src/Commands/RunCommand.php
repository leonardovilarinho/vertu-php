<?php

namespace PHPMetric\Commands;

use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\Command\Command;
use Webmozart\Console\Api\IO\IO;
use PHPMetric\Core\ApplicationCore;
use Webmozart\Console\UI\Component\Table;

class RunCommand
{
    private $classes = [];

    private $metrics = [
        '\PHPMetric\Metrics\DetourMetric',
    ];

    private $components = [
        '\PHPMetric\Components\NameComponent',
        '\PHPMetric\Components\MethodsComponent',
        '\PHPMetric\Components\AttributesComponent',
        '\PHPMetric\Components\TypeComponent',
        '\PHPMetric\Components\NamespaceComponent',
    ];

    public function handle(Args $args, IO $io, Command $command)
    {
        $io->writeLine( 'Loading files...' );

        if( ! file_exists( config()['project'] ) )
            return 1;

        $finder = new \Symfony\Component\Finder\Finder;
        $finder
            ->files()
            ->in( config()['project'] )
            ->exclude( explode('|', config()['exclude_dir']) )
            ->name( config()['extension'] )
        ;

        $step = (int)(100 / count( $finder ));
        $progress = 0;

        $io->writeLine( 'Calculating metrics:' );
        foreach ($finder as $file) {

            $class = new \PHPMetric\Collector(
                $file->getRealPath(), $this->metrics, $this->components
            );

            progress($step, $progress, '|');

            $this->classes[] = $class;
        }
        $io->writeLine(' 100%');

        if( ! $args->isOptionSet('html') ) {
            $io->writeLine('Analyzing classes...');
            $step = (int)(100 / count( $this->classes ));
            $progress = 0;

            $output = [];
            $cont = -1;


            $omits = explode( '|', config()['omit'] );
            if( ! is_array($omits) )
                $omits = [$omits];

            foreach ($this->classes as $class) {
                if( ! in_array($class->el('type')->value(), $omits) )
                {
                    $price = 0;
                    $cont ++;
                    $output[$cont]['type'] = $class->el('type')->value();
                    if($class->el('namespace')->value() != '') {
                        $output[$cont]['namespace'] = $class->el('namespace')->value();
                        $output[$cont]['name'] = $class->el('name')->value();
                    }
                    else {
                        $output[$cont]['namespace'] = '\\';
                        $output[$cont]['name'] = explode('/', $class->file());

                        if( is_array($output[$cont]['name']) )
                            $output[$cont]['name'] = end( $output[$cont]['name'] );

                        $output[$cont]['name'] = str_replace('.php', '', $output[$cont]['name']);
                    }

                    if( ! $class->hasMetrics() ) {
                        foreach ($class->el('methods')->value() as $method) {
                            foreach ($method['metrics'] as $metric)
                                $price += $metric->total();
                        }
                    }
                    else {
                        foreach ($class->metrics() as $metric)
                            $price += $metric->total();
                    }

                    $output[$cont]['price'] = $price;
                }
            }

            usort($output, function($a, $b) {
                return $a['price'] - $b['price'];
            });
            $output = array_reverse($output);
            $lower = $output[0]['price'];
            $interval = number_format($lower/5, 1);


            $io->writeLine( color('The '.config()['ranking'].' most smelly files:')->bold->red );
            $table = new Table();

            $table->setHeaderRow(['Name', 'Type', 'Namespace', 'Rating']);

            for ($i = 0; $i < config()['ranking']; $i++) {
                $txt = '';
                $star = 0;
                for ($k = $lower; $k > 0 ; $k -= $interval) {
                    $star ++;
                    if($k >= $output[$i]['price']){
                        if($star < 2)
                            $txt .= color('*')->red;
                        else if($star < 4)
                            $txt .= color('*')->yellow;
                        else
                            $txt .= color('*')->green;
                    }
                    else
                        $txt .= color('*')->white;
                }
                $table->addRow([
                    $output[$i]['name'],
                    $output[$i]['type'],
                    $output[$i]['namespace'],
                     trim($txt),
                ]);
            }
            $table->render($io);
        }
        return 0;
    }
}