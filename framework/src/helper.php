<?php

use Framework\Debug\Dumper;

/** @param mixed $args */
function d(...$args): void
{
    Dumper::d(...$args);
}

/** @param mixed $args */
function dd(...$args): void
{
    Dumper::dd(...$args);
}
