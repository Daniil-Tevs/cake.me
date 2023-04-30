<?php
/**
 * @var CMain $APPLICATION
 * @var array $tags
 * @global CUser $USER
 */
?>
<!doctype html>
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
			<form action="/" class="search-form" method="get">
				<input type="text" name="search-string" class="search-input" placeholder="Search" oninput="window.CakeRecipeList.changeTitle(this.value);window.step=1;">
				<input type="image" class="search-form-image" name="search-string"  src="/local/modules/up.cake/install/templates/cake/images/search.png" alt="Submit Form" />
			</form>
		</div>

		<div class="header-two">
			<!--  adding!-->
			<a href="/recipe/create/" class="logo-add">
				<figure class="image is-32x32">
					<img class="profile-image" aria-controls="dropdown-menu4" src="/local/modules/up.cake/install/templates/cake/images/adding.png">
				</figure>
			</a>
			<!--  filter!-->
			<div class="dropdown is-right profile-icon" id="category">
				<div class="dropdown-trigger" >
					<figure class="image is-32x32">
						<img class="profile-image " onclick="displayCategory()" aria-controls="dropdown-menu5" src="/local/modules/up.cake/install/templates/cake/images/categories.png">
					</figure>
					</div>
				<div class="dropdown-menu profile header-category" id="dropdown-menu5" role="menu">
					<div class="dropdown-content">
						<form>
							<div class="columns">
								<?php foreach(\Up\Cake\Service\TagService::getWithCategory() as $category => $tags):?>
									<div class="column">
										<div class="dropdown-item">
											<div class="category-title">
												<h2><?=htmlspecialcharsbx($category)?>:</h2>
											</div>

											<div class="tags">
												<?php foreach ($tags as $tag):?>
													<div class="tag">
														<input type="radio" name="<?=htmlspecialcharsbx($category)?>" class="mr-2" oninput="window.CakeRecipeList.changeFilters(this.name,this.value);window.step=1;"   value="<?=htmlspecialcharsbx($tag->getId())?>"><?=htmlspecialcharsbx($tag->getName())?>
													</div>
												<?php endforeach;?>
												<div class="tag"><input type="radio" name="<?=htmlspecialcharsbx($category)?>" class="mr-2" oninput="window.CakeRecipeList.changeFilters(this.name);window.step=1;" checked="true">Всё</div>
											</div>
										</div>
									</div>
								<?php endforeach;?>

							</div>
						</form>
					</div>


				</div>
			</div>
			<!-- logo-profile !-->
			<div class="dropdown is-hoverable is-right profile-icon">
				<div class="dropdown-trigger">
					<figure class="image is-48x48">
						<img class="profile-image " aria-controls="dropdown-menu4" src="/local/modules/up.cake/install/templates/cake/images/profile.png">
					</figure>
				</div>
				<div class="dropdown-menu profile" id="dropdown-menu4" role="menu">

					<div class="dropdown-content">
						<?php if ($USER->IsAuthorized()): ?>
							<a href="/profile/" class="dropdown-item">
								профиль
							</a>
							<hr class="dropdown-divider">
							<a href="/logout/" class="dropdown-item">
								выйти
							</a>
						<?php else: ?>
						<a href="/auth/" class="dropdown-item">
							Log in
						</a>
						<hr class="dropdown-divider">
						<a href="/register/" class="dropdown-item">
							Sign up
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<section class="section">
	<div class="container">
		<div class="layout mt-3">
			<div class="container filters p-1">
				<div class="collection-filter">
					<input class="category-check" type="checkbox" id="popular" name="popular">
					<label class="label-filter" for="popular"><strong>Популярное</strong></label>
					<input class="category-check" type="checkbox" id="new-recipes" name="new-recipes">
					<label class="label-filter" for="new-recipes"><strong>Новинки</strong></label>
					<input class="category-check" type="checkbox" id="follow" name="follow">
					<label class="label-filter" for="follow"><strong>Подписки</strong></label>
			</div>
		</div>