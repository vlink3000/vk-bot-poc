<?php declare(strict_types=1);

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->get('/', function() use($app) {
    return getResponse('application up and running :)');
});

$app->post('/1SYu4H4BG2SA0CL5i9Gm', function() use($app) {

    $request = json_decode(file_get_contents('php://input'));

    if(!$request) {
        return getResponse('empty request');
    }

    if($request->secret !== getenv('VK_SECRET_TOKEN') && $request->type !== 'confirmation') {
        return getResponse('invalid secret and request type');
    }

    switch ($request->type) {
        case 'confirmation':
            return '1c96ca0e';
            break;
        case 'message_new':
            break;
    }

    return getResponse('unknown request');
});

$app->run();

function getResponse(string $message): string
{
    return json_encode(array('message' => $message));
}