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

Loc::loadMessages(__FILE__);
?>

<style> .tags {display: none;}</style>

<div class="container mt-6">
	<div class="columns profile">
		<div class="column profile-img is-two-fifths">
			<div class="card-image">
				<figure class="image is-4by3">
					<img src="<?=$user['PERSONAL_PHOTO']?>" alt="Placeholder image">
				</figure>
			</div>
		</div>
		<div class="column">
			<div class="card-content">
				<div class="profile-header">
					<p class="title is-3 mb-0"><?= htmlspecialcharsbx("{$user['NAME']} {$user['LAST_NAME']}")?></p>
					<a href="/profile/edit/">
						<figure class="image is-32x32 is-pulled-right">
							<img src="/local/modules/up.cake/install/templates/cake/images/profile-edit-logo.png" >
						</figure>
					</a>

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
			<p>Ваши рецепты</p>
		</div>
		<div id="recipe-list"></div>
	</div>

</div>


<script>
	let step = 1;
	BX.ready(function() {
		window.CakeRecipeList = new BX.Up.Cake.RecipeList({
			rootNodeId: 'recipe-list',
			userId: <?= $user['ID']?>,
			type: 'profile',
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