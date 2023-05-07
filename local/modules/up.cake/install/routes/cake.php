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
	$routes->get('/profile/edit/', new PublicPageController('/local/modules/up.cake/views/cake-profile-edit.php'));
	$routes->post('/profile/edit/', new PublicPageController('/local/modules/up.cake/views/cake-profile-edit.php'));
	$routes->get('/profile/subs/', new PublicPageController('/local/modules/up.cake/views/cake-profile-subs.php'));

	//рецепт
	$routes->get('/recipe/create/', new PublicPageController('/local/modules/up.cake/views/cake-recipe-create.php'));
	$routes->post('/recipe/create/', new PublicPageController('/local/modules/up.cake/views/cake-recipe-create.php'));

	$routes->get('/recipe/edit/{id}/', new PublicPageController('/local/modules/up.cake/views/cake-recipe-update.php'));
	$routes->post('/recipe/edit/{id}/', new PublicPageController('/local/modules/up.cake/views/cake-recipe-update.php'));

	//Страница пользователя
	$routes->get('/users/{id}/', new PublicPageController('/local/modules/up.cake/views/cake-users.php'));
	$routes->get('/search/users/', new PublicPageController('/local/modules/up.cake/views/cake-search-users.php'));

};