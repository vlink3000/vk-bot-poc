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

    if ($request->type == 'message_new') {
        $requestParams = [
            'user_id' => $request->object->user_id,
            'message' => 'ok',
            'access_token' => getenv('VK_TOKEN'),
            'v' => '5.69'
        ];

        file_get_contents('https://api.vk.com/method/messages.send?' . http_build_query($requestParams));

        return getResponse('request has been processed');
    }

    return getResponse('unknown request');
});

$app->run();

/**
 * @param string $message
 *
 * @return string
 */
function getResponse(string $message): string
{
    return json_encode(array('message' => $message));
}