<?php

namespace Google\Cloud\Samples\PubSub;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
$app = new Application();

$app->post('/receive_message', function () use ($app)
{
	$json = $app['request']->getContent();
	$request = json_decode($json, true); //['message'=>['data'=>'data']];
	if (
		!isset($request['message']['data'])
		|| !$message = base64_decode($request['message']['data'])
	)
	{
		return new Response('', 400);
	}

	file_put_contents(__DIR__."/log.txt", json_encode(['server' => $_SERVER, 'get' => $_GET, 'post' => $_POST], JSON_PRETTY_PRINT));
	$message = [];
	$message['cmd'] = __DIR__."/../every-1-min.sh > /dev/null 2>/dev/null &";
	$output = [];
	$return_var = 0;
	$ret = exec($message['cmd'], $output, $return_var);

	$message['output'] = $output;
	$message['ret'] = $ret;

	file_put_contents("./topic.json", json_encode($message));

	return new Response();
});

return $app;