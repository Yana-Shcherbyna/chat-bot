<?php
// This code sample uses the 'Unirest' library:
// http://unirest.io/php.html
$query = array(
  'key' => 'APIKey',
  'token' => 'APIToken'
);

$response = Unirest\Request::get(
  'https://api.trello.com/1/actions/{id}',
  $query
);

var_dump($response);