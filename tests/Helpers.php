<?php

function useDatabase()
{
    app('config')->set('database.default', 'tests');
    app('config')->set('database.connections.tests', [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
    ]);

    include_once __DIR__ . '/../database/migrations/create_heartbeats_table.php';
    (new CreateHeartbeatsTable())->up();
}
