<?php
/**
 * @var CMain $APPLICATION
 * @var array $tags
 * @global CUser $USER
 */
$categories = \Up\Cake\Service\TagService::getWithCategory();
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
			<form id="search-form" action="/" class="search-form" method="get">
				<input type="text" name="search-string" class="search-input" placeholder="Search" oninput="window.CakeRecipeList.changeTitle(this.value);window.step=1;">
				<input type="image" class="search-form-image" name="search-string"  src="/local/modules/up.cake/install/templates/cake/images/search.png" alt="Submit Form" />
			</form>
		</div>

		<div class="header-two">
			<!--  adding!-->
			<a href="/recipe/create/" class="logo-add">
				<figure class="image is-32x32">
					<img class="profile-image" title="Добавить рецепт" aria-controls="dropdown-menu4" src="/local/modules/up.cake/install/templates/cake/images/adding.png">
				</figure>
			</a>
			<!--  recent!-->
			<div class="recently">
				<?php if ($USER->IsAuthorized()): ?>
					<a onclick="displayRecentRecipes()">
						<div class="logo-add recent-recipe-icon">
							<figure class="image is-32x32">
								<img class="profile-image" title="Недавние рецепты" aria-controls="dropdown-menu4" src="/local/modules/up.cake/install/templates/cake/images/recentRecipe.png">
							</figure>
						</div>
					</a>
					<div class="box box-recent-recipe-header recent-recipe-none " id="recent-recipe">
						<?php $APPLICATION->IncludeComponent('up:cake.recentRecipes', '', []); ?>
					</div>
				<? endif; ?>
			</div>

			<!--  filter!-->
			<div class="dropdown is-right profile-icon filter" id="category">
				<div class="dropdown-trigger" >
					<figure class="image is-32x32">
						<img title="Категории" class="profile-image " onclick="displayCategory()" aria-controls="dropdown-menu5" src="/local/modules/up.cake/install/templates/cake/images/categories.png">
					</figure>
					</div>
				<div class="dropdown-menu profile header-category" id="dropdown-menu5" role="menu">
					<div class="dropdown-content">
						<form>
							<div class="columns">
								<?php foreach($categories as $category => $tags):?>
									<div class="column" <?= (array_key_last($categories)!==$category)?'style="border-right: 3px solid white;"': ''?>>
										<div class="dropdown-item">
											<div class="category-title">
												<h2><?=htmlspecialcharsbx($category)?>:</h2>
											</div>

											<div class="tags">
												<?php foreach ($tags as $tag):?>
													<div class="tag">
														<input id="tag-<?=htmlspecialcharsbx($tag->getId())?>" type="radio" name="<?=htmlspecialcharsbx($category)?>" class="mr-2" oninput="window.CakeRecipeList.changeFilters(this.name,this.value);window.step=1;"   value="<?=htmlspecialcharsbx($tag->getId())?>"><label for="tag-<?=htmlspecialcharsbx($tag->getId())?>"><?=htmlspecialcharsbx($tag->getName())?></label>
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
			<!--  notification!-->
				<?php if ($USER->IsAuthorized()): ?>
					<div class="dropdown is-right profile-icon user-notification" id="all-notification">
						<div class="dropdown-trigger" >
							<div id="notif-img" title='Уведомления' class="image is-32x32 notification-image<?=(session()->get('IS_USER_NOTIFICATION'))?'-active':''?>" onclick="displayNotification()" aria-controls="dropdown-menu6">
							</div>
						</div>
						<div class="dropdown-menu profile notification-header" id="dropdown-menu6" role="menu">
							<div id="notification-list" class="dropdown-content notification-list">
								<?php if(empty(session()->get('USER_NOTIFICATION'))||session()->get('USER_NOTIFICATION' === null)):?>
									<div class='notification-data'>Здесь пока ничего нет</div>
								<?php endif;?>
								<?php foreach (session()->get('USER_NOTIFICATION') as $notification):?>
									<?=\Up\Cake\Service\NotificationService::render($notification)?>
								<?php endforeach;?>
							</div>
						</div>
					</div>
				<? endif; ?>
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
								Профиль
							</a>
							<hr class="dropdown-divider">
							<a href="/favorites/" class="dropdown-item">
								Понравившиеся
							</a>
							<hr class="dropdown-divider">
							<a href="/profile/subs/" class="dropdown-item">
								Подписки
							</a>
							<hr class="dropdown-divider">
							<a href="/search/users/" class="dropdown-item">
								Найти пользователя
							</a>
							<hr class="dropdown-divider">
							<a href="/logout/" class="dropdown-item">
								Выйти
							</a>
						<?php else: ?>
						<a href="/auth/" class="dropdown-item">
							Войти
						</a>
						<hr class="dropdown-divider">
						<a href="/register/" class="dropdown-item">
							Регистрация
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<script>

	function getNotification()
	{
		if(<?= $USER->IsAuthorized()?>)
		{
			BX.ajax.runAction('up:cake.notification.getListAfterAuth');
		}
	}
	getNotification();
	function displayRecentRecipes()
	{
		let recentRecipe = document.getElementById('recent-recipe');
		if (recentRecipe.classList.contains('recent-recipe-none'))
		{
			recentRecipe.classList.remove('recent-recipe-none');
			recentRecipe.classList.add('recent-recipe-active');
			return;
		}

		if (recentRecipe.classList.contains('recent-recipe-active'))
		{
			recentRecipe.classList.remove('recent-recipe-active');
			recentRecipe.classList.add('recent-recipe-none');
		}
	}

	document.notificationActive = false;
	document.notificationChecked = false;

	async function displayNotification()
	{
		if(!document.notificationActive)
		{
			document.getElementById('all-notification').classList.add('is-active');
			document.notificationActive = true;
			if(!document.notificationChecked)
			{
				BX.ajax.runAction('up:cake.notification.setUncheck', {});
				document.getElementById('notif-img').classList.replace('notification-image-active','notification-image');
			}
		}
		else{
			document.getElementById('all-notification').classList.remove('is-active');
			document.notificationActive = false;
		}
	}

	document.getElementById('search-form').addEventListener('submit', stopSend);

	function stopSend(event)
	{
		event.preventDefault();
	}

</script>

<section class="section">
	<div class="container" style="max-width: 92%;">
