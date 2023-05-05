<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

\Bitrix\Main\UI\Extension::load('up.recipe-list');

$user = $arResult['USER'];
$subCheck = $arResult['SUB_CHECK_SUCCESS'];

Loc::loadMessages(__FILE__);
?>

<style> .tags {display: none;}</style>

<?php if ($arResult["SUBS_ERROR"] === true): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Вы уже подписаны на этого пользователя!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["SUBS_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Вы успешно подписались на пользователя!</p>
	</div>
<?php elseif ($arResult["SUBS_SUCCESS"] === false): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Не удалось подписаться на пользователя!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["DELETE_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Вы отписались от пользователя!</p>
	</div>
<?php elseif ($arResult["DELETE_SUCCESS"] === false): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Не удалось отписаться от пользователя!</p>
	</div>
<?php endif; ?>

<div class="container mt-6">
	<div class="columns profile">
		<div id="image-box" class="column profile-img is-two-fifths image-profile-box">
					<?php if ($user['PERSONAL_PHOTO'] === null): ?>
					<?php if ($user['PERSONAL_GENDER']==='M'): ?>
					<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" height="500" width="500" alt="/">
					<?php else: ?>
					<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png" height="500" width="500" alt="/">
					<?php endif; ?>
					<?php endif; ?>
					<?= CFile::ShowImage($user['PERSONAL_PHOTO'], 500, 500, "border=0", "", true); ?>
		</div>
		<div class="column">
			<div class="card-content">
				<div class="profile-header">
					<p class="title is-3 mb-0"><?= htmlspecialcharsbx("{$user['NAME']} {$user['LAST_NAME']}")?> (<?= $user['LOGIN'] ?>)</p>

					<?php if ($subCheck === true): ?>
					<div class="field is-flex">
						<div class="field is-flex users-subs-icon">
							<figure class="image is-32x32 is-pulled-right">
								<img src="/local/modules/up.cake/install/templates/cake/images/subscribeSuccess.png" >
							</figure>
							<div class="users-subs-text-check">Вы подписаны</div>

							<a class="button is-danger" href="/users/<?= $user['ID'] ?>/?subsDel=Y">Отписаться</a>
						</div>

					</div>
					<?php else: ?>
						<a href="/users/<?= $user['ID'] ?>/?subs=Y">
						<div class="field is-flex users-subs-icon">
							<figure class="image is-32x32 is-pulled-right">
								<img src="/local/modules/up.cake/install/templates/cake/images/subscribe.png" >
							</figure>
							<div class="users-subs-text">Подписаться</div>
						</div>
						</a>
					<?php endif; ?>

				</div>

				<hr class="hr-profile">
				<div class="content profile-details">

					<div class="profile-detail-info"><p>Пол:</p><?= htmlspecialcharsbx(($user['PERSONAL_GENDER']==='M')?'Мужской':'Женский' ?? 'Не указан')?></div>
					<div class="profile-detail-info"><p>Город проживания:</p><?= htmlspecialcharsbx($user['PERSONAL_CITY'] ?? 'Не указан')?></div>
					<div class="profile-detail-info"><p>Описание:</p><?= htmlspecialcharsbx($user['PERSONAL_NOTES'] ?? 'Не указан')?></div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="your-recipe">
			<p>Рецепты</p>
		</div>
		<div id="recipe-list"></div>
	</div>

</div>


<script>
	let step = 1;
	BX.ready(function() {
		window.CakeRecipeList = new BX.Up.Cake.RecipeList({
			rootNodeId: 'recipe-list',
			type: 'anotherProfile',
			userId: <?= $arParams['USER']?>,
			anotherUserId: <?=$user['ID']?>
		});
	});

	function throttle(callee, timeout)
	{
		let timer = null;

		return function perform(...args) {
			if (timer)
			{
				return;
			}

			timer = setTimeout(() => {
				callee(...args);

				clearTimeout(timer);
				timer = null;
			}, timeout);
		};
	}

	async function checkPosition()
	{
		const height = document.body.offsetHeight;
		const screenHeight = window.innerHeight;
		const scrolled = window.scrollY;

		const threshold = height - screenHeight / 8;
		const position = scrolled + screenHeight;

		if (position >= threshold && !window.CakeRecipeList.END_PAGE)
		{
			step++;
			window.scrollBy(0, -100);
			await window.CakeRecipeList.reload(step);
		}
	}

	window.addEventListener('scroll', throttle(checkPosition));

</script>