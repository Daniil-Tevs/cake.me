<?php
/**
 * @var CMain $APPLICATION
 * @var array $tags
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
	<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
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
			<form action="/" class="search-form">
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


<section class="section">
	<div class="container">
		<div class="layout tags mt-3">
			<div class="header header-filter p-1">
				<div class="collection-filter">
					<?php foreach (\Up\Cake\Service\TagService::get() as $tag):?>
					<a href="/tag/<?=htmlspecialcharsbx($tag->getId())?>/" class="header-tag"><strong><?=htmlspecialcharsbx($tag->getName())?></strong></a>
					<?php endforeach;?>
				</div>
			</div>
		</div>