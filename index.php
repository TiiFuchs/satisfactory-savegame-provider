<?php

use Tii\SatisfactorySaveGame\Config;
use Tii\SatisfactorySaveGame\SaveGame;

require_once 'vendor/autoload.php';

$config = new Config;

function abort(int $statusCode = 404): never
{
    http_response_code($statusCode);
    exit;
}

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/latest') {
    // deliver latest save file
    $file = SaveGame::latest();

    if (! $file) {
        abort(404);
    }

    $file->download();

} elseif (str_starts_with($requestUri, '/save/')) {
    // deliver save with specific name
    $filename = urldecode(mb_substr($requestUri, 6));

    $file = SaveGame::get($filename);

    if (! $file) {
        abort(404);
    }

    $file->download();

} elseif ($requestUri === '/map') {
    // redirect to map
    $appUrl = $config->get('APP_URL');
    header("Location: https://satisfactory-calculator.com/en/interactive-map?url=$appUrl/latest");

    abort(302);

} else {

    abort(404);

}
