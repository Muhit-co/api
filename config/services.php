<?php

return [

	/*
		|--------------------------------------------------------------------------
		| Third Party Services
		|--------------------------------------------------------------------------
		|
		| This file is for storing the credentials for third party services such
		| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
		| default location for this type of information, allowing packages
		| to have a conventional place to find your various credentials.
		|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => env('MANDRILL'),
	],

	'ses' => [
		'key' => env('SES_KEY', ''),
		'secret' => env('SES_SECRET', ''),
		'region' => env('SES_REGION', 'eu-west-1'),
	],

	'stripe' => [
		'model' => 'Muhit\Models\User',
		'secret' => '',
	],

	'facebook' => [
		'client_id' => env('FB_ID'),
		'client_secret' => env('FB_SECRET'),
		'redirect' => env('URL') . 'login/facebook/return',
	],

	'raven' => [
		'dsn' => env('SENTRY_DSN', ''),
		'level' => env('SENTRY_LEVEL', 'error'),
	],

];
