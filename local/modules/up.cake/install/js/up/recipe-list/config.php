<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/recipe-list.bundle.css',
	'js' => 'dist/recipe-list.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];