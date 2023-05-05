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

<style> .recently,.search-container,.filter {display: none;}</style>

<?php if ($arResult['DATA_SAVED'] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Изменения сохранены</p>
	</div>
<?php endif; ?>

<div class="container mt-6">
	<div class="columns profile">
		<div id="image-box" class="column profile-img image-profile-box">

					<?php if ($arResult['DEFAULT_IMAGE'] === true): ?>
					<?php if ($user['PERSONAL_GENDER']==='M'): ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" height="500" width="500" alt="/">
					<?php else: ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png" height="500" width="500" alt="/">
					<?php endif; ?>
					<?php endif; ?>
					<?= CFile::ShowImage($user['PERSONAL_PHOTO'], 500, 500, "border=0", "", true); ?>


		</div>
		<div class="column is-9">
			<div class="card-content">
				<div class="profile-header">
					<p class="title is-3 mb-0"><?= htmlspecialcharsbx("{$user['NAME']} {$user['LAST_NAME']}")?> (<?= $user['LOGIN'] ?>)</p>
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
	<div class="your-recipe">
		<p>Ваши рецепты</p>
	</div>
	<div id="recipe-list" class="card-lists"></div>
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

	window.addEventListener('scroll', throttle(checkPosition,2000));

</script>