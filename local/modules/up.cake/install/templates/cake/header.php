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
	<title><?php
		$APPLICATION->ShowTitle(); ?></title>

	<?php
	$APPLICATION->ShowHead();
	?>
</head>
<body>
<?php
$APPLICATION->ShowPanel(); ?>

<div class="navbar">
	<div class="header">
		<div class="header-one">
			<div class="logo-container ml-5">
				<a href="/" class="logo-link">
					<img src="/local/modules/up.cake/install/templates/cake/images/logo.png">
					<div class="logo-name">Cake.Me</div>
				</a>
			</div>
		</div>

		<div class="search-container">
			<form action="/find" class="search-form">
				<input type="text" name="search-string" class="search-input" placeholder="Search">
				<img class="search-form-image" src="/local/modules/up.cake/install/templates/cake/images/search.png" alt="/">
			</form>
		</div>

		<div class="header-two">
			<div class="dropdown is-hoverable is-right">
				<div class="dropdown-trigger">
					<img class="profile-image " aria-controls="dropdown-menu4" src="/local/modules/up.cake/install/templates/cake/images/profile.png">
				</div>
				<div class="dropdown-menu profile" id="dropdown-menu4" role="menu">
					<div class="dropdown-content">
<!--						<div class="dropdown-item">-->
<!--							<p><strong>Profile:</strong></p>-->
<!--						</div>-->
<!--						<hr class="dropdown-divider">-->
						<a href="/login/" class="dropdown-item">
							Log in
						</a>
						<hr class="dropdown-divider">
						<a href="/registration/" class="dropdown-item">
							Sign up
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!--<div class="container">-->
<!--	<div class="layout">-->
<!--		<div class="header header-filter">-->
<!--			<div class="collection-filter">-->
<!--				<a href="/tag/salad" class="header-tag">салаты</a>-->
<!--				<a href="/tag/bakery" class="header-tag">выпечка</a>-->
<!--				<a href="/tag/soup" class="header-tag">супы</a>-->
<!--				<a href="/tag/hotter" class="header-tag">горячие блюда</a>-->
<!--				<a href="/tag/snacks" class="header-tag">закуски</a>-->
<!--				<a href="/tag/vegan" class="header-tag"></a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<section class="section">
	<div class="container mt-95">
