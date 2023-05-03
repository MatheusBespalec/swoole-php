<?php

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

$server = new Server("1270.0.0.1:8080", 8080);

$server->on("message", function (Server $server, Frame $message) {
    foreach ($server->connections as $connection) {
        if ($message->fd == $connection) {
            continue;
        }

        $server->push($connection, json_encode(["type" => "chat", "text" => "User ID {$message->fd}: {$message->data}"]));
    }
});

$server->start();