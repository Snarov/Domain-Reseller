<?php

include 'Client.php';

use JsonRPC\Client;

$client = new Client('https://dms1.ok.by/api/v1/json-rpc');
// $client->debug = true;
$client->ssl_verify_peer = false;

$client->authentication('snarov', '108108');
$result = $client->CheckDomain(['domain' => 'test.by']);

var_dump($result);