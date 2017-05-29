<?php

return [
	//setting display error
	'displayErrorDetails'	=> true,

	'addContentLengthHeader' => false,

	//setting timezone
	'timezone'	=> 'Asia/Jakarta',

	//setting db (with doctrine)
	'db'	=> [
		'url'	=> getenv('DB_URL'),
	],

	'determineRouteBeforeAppMiddleware' => true,
];
