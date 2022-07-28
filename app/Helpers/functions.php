<?php


/**
 * Obter idade pela data de nascimento
 *
 * @param  mixed $dataNas Data de nascimento no formato americano, ex: 2010-01-01
 * @return int
 */
function idade($dataNas = '2010-01-01'): int
{
    return \Carbon\Carbon::parse($dataNas)->diff(\Carbon\Carbon::now())->y;
}
