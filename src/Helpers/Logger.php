<?php 

namespace App\Helpers;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as Monologger;


class Logger{

    private $channel;

    public function __construct($channel = ''){

        $this->channel = $channel;
    }

    public function info($data){
        $logger = new Monologger($this->channel);
        $stream = new StreamHandler(ABSPATH . '/logger/' . date('Y-m-d') . '.log', Level::Info);
        $logger->pushHandler($stream);
        $logger->pushHandler(new FirePHPHandler());
        $logger->info($data);
    }
    
}