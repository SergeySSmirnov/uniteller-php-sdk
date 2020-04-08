<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 */

use Rusproj\Uniteller\Cancel\CancelBuilder;

require __DIR__ . '/credentials.php';

/** @var \Rusproj\Uniteller\Client $uniteller */

$builder = (new CancelBuilder())->setBillNumber('RRN Number, (12 digits)');
$results = $uniteller->cancel($builder);

// or ...
/*
$results = $uniteller->cancel([
    'Billnumber' => 'RRN Number, (12 digits)',
    // ...
]);
*/

var_dump($results);
