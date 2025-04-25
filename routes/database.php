<?php 


$app->get('/migrate', [App\Database\Migrations\Migrations::class, 'migrate'])->setName('migration.index');
$app->get('/seed', [App\Database\Seeders\Seed::class, 'seed'])->setName('seed.index');