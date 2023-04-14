<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

	$routes->get('/', new PublicPageController('/local/modules/up.cake/views/cake-list.php'));
	$routes->get('/catalog/', new PublicPageController('/local/modules/up.cake/views/cake-list.php'));
	$routes->get('/detail/{id}/', new PublicPageController('/local/modules/up.cake/views/cake-detail.php'));
	$routes->get('/search/', new PublicPageController('/local/modules/up.cake/views/cake-search.php'));

};