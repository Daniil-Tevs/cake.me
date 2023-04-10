<?php
/**
 * @var CMain $APPLICATION
 */
?><!doctype html>
<html lang="<?= LANGUAGE_ID; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php $APPLICATION->ShowTitle(); ?></title>

	<?php
	$APPLICATION->ShowHead();
	?>
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>

<div class="centrator">
	<div class="container">
		<div class="layout">

			<div class="header">
				<div class="header-one">
					<div class="logo-container">
						<a href="/" class="logo-link">
							<img src="local/modules/up.cake/install/templates/cake/images/logo.png" alt="/">
														<div class="logo-name">Cake.Me</div>
						</a>
					</div>
					<div class="search-container">
						<form action="/find" class="search-form" >
							<input type="text" name="search-string" class="search-input" placeholder="найти">
							<img class="search-form-image" src="local/modules/up.cake/install/templates/cake/images/search.png" alt="/">
						</form>
					</div>
				</div>

				<div class="header-two">
					<?php global $USER;
					// if (!$USER->IsAuthorized()): ?>
						<a href="/register" class="button-header button-register button-header-two">Регистрация</a>
						<a href="/login" class="button-header button-header-two">Войти</a>
					<?php //else: ?>
						<a href="/add" class="button-header button-header-two">+ добавить рецепт</a>
						<a href="/profile" class="button-header-two">
							<img class="profile-image " src="local/modules/up.cake/install/templates/cake/images/profile.png" alt="/">
						</a>
						<a href="/logout" class="button-header button-header-two button-delete">Выйти</a>
					<?php //endif; ?>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="layout">
		<div class="header header-filter">
			<div class="collection-filter">
				<a href="/tag/salad" class="header-tag">салаты</a>
				<a href="/tag/bakery" class="header-tag">выпечка</a>
				<a href="/tag/soup" class="header-tag">супы</a>
				<a href="/tag/hotter" class="header-tag">горячие блюда</a>
				<a href="/tag/snacks" class="header-tag">закуски</a>
				<a href="/tag/vegan" class="header-tag"></a>
			</div>
		</div>
	</div>
</div>

<section class="section">
	<div class="container">
