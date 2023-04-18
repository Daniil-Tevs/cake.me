<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

	//каталог
	$routes->get('/', new PublicPageController('/local/modules/up.cake/views/cake-list.php'));
	$routes->get('/catalog/', new PublicPageController('/local/modules/up.cake/views/cake-list.php'));
	$routes->get('/detail/{id}/', new PublicPageController('/local/modules/up.cake/views/cake-detail.php'));
	$routes->get('/search/', new PublicPageController('/local/modules/up.cake/views/cake-search.php'));

	//авторизация
	$routes->get('/register/', new PublicPageController('/local/modules/up.cake/views/cake-register.php'));
	$routes->get('/auth/', new PublicPageController('/local/modules/up.cake/views/cake-auth.php'));
	$routes->post('/register/', new PublicPageController('/local/modules/up.cake/views/cake-register.php'));
	$routes->post('/auth/', new PublicPageController('/local/modules/up.cake/views/cake-auth.php'));
	$routes->get('/logout/', new PublicPageController('/local/modules/up.cake/views/cake-logout.php'));

	//профиль
	$routes->get('/profile/', new PublicPageController('/local/modules/up.cake/views/cake-profile.php'));

};