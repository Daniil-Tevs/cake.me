<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/recipe-comments.bundle.css',
	'js' => 'dist/recipe-comments.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];