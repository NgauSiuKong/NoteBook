<?php

if (!function_exists('d')) {
    /**
     * Dump.
     *
     * @param  mixed
     * @return void
     */
    function d(...$arguments)
    {
        $dumper = new Dumper();

        foreach ($arguments as $x) {
            $dumper->dump($x);
        }
    }
}


if (!function_exists('dd')) {
    /**
     * Dump and die.
     *
     * @param  mixed
     * @return void
     */
    function dd(...$arguments)
    {
        $dumper = new Dumper();

        foreach ($arguments as $x) {
            $dumper->dump($x);
        }

        die(1);
    }
}
