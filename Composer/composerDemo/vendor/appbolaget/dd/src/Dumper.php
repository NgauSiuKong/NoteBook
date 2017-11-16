<?php

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class Dumper
{
    /**
     * Construct.
     */
    public function __construct()
    {
        $initiator = debug_backtrace()[1];

        echo '<code>' . $initiator['file'] . ':' . $initiator['line'] . '</code>';
    }

    /**
     * Dump.
     *
     * @param  mixed $value
     * @return void
     */
    public function dump($value)
    {
        if (class_exists(CliDumper::class)) {
            $dumper = 'cli' === PHP_SAPI ? new CliDumper : new HtmlDumper;
            $dumper->dump((new VarCloner)->cloneVar($value));
        } else {
            var_dump($value);
        }
    }
}
