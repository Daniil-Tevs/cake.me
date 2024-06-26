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

$userList = $arResult['USERS'];
$userRequest = $arResult['USER_REQUEST'];

Loc::loadMessages(__FILE__);
?>

<style> .tags {display: none;}</style>

<?php if ($arResult["SUBS_ERROR"] === true): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Вы уже подписаны на этого пользователя!</p>
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

<div class="content">


	<div id="box-search-user" class="box box-search-user">
		<h1>Поиск пользователей</h1>
		<p>(Введите имя, фамилию или логин пользователя. Если хотите найти пользователя только по нику, перед поиском укажите @)</p>
		<hr>
		<div class="field">
			<form name="form_user_search" action="/search/users/" method="get">
				<?=bitrix_sessid_post() ?>
			<div class="field has-addons">
				<div class="control">
					<input class="input input-search-user" type="text" id="search-input" name="search" placeholder="поиск по имени">
				</div>
				<button type="submit" class="button button-user-search is-link">найти</button>
			</div>

			</form>
		</div>
		<br>

		<?php if ($userRequest === true && empty($userList)): ?>
			<br>
			<div class="field is-flex search-users-find-label"><h2>Пользователи не найдены</h2></div>

		<?php else: ?>
		<?php foreach ($userList as $user): ?>
		<div id="box-user-search-list" class="box box-user-search">
		<article class="media">
			<div class="media-left">
				<a href="/users/<?= (int)$user['ID'] ?>/">

					<?php if ((int)$user['PERSONAL_PHOTO'] === 0): ?>
						<?php if ( $user['PERSONAL_GENDER'] === 'M'): ?>
						<figure class="image is-96x96">
							<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" alt="/">
						</figure>
						<?php elseif ($user['PERSONAL_GENDER'] === 'F'): ?>
						<figure class="image is-96x96">
							<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png" alt="/">
						</figure>
						<?php endif; ?>
					<?php else: ?>
					<figure class="image is-96x96">
						<?= CFile::ShowImage((int)$user['PERSONAL_PHOTO'], 96, 96, "border=1", ""); ?>
					</figure>
					<?php endif; ?>

				</a>
			</div>
			<div class="media-content">
				<div class="content">
					<p>
						<div class="search-users-info-block">
							<a href="/users/<?= (int)$user['ID'] ?>/">
								<strong><?= htmlspecialcharsbx($user['NAME']) ?> <?= htmlspecialcharsbx($user['LAST_NAME']) ?> (<?= htmlspecialcharsbx($user['LOGIN']) ?>)</strong>
							</a>
						<?php if ((int)$user['CHECK_SUBS'] === 1): ?>
							<div class="search-users-info-block-subs"><img src="/local/modules/up.cake/install/templates/cake/images/subscribeSuccess.png" height="25" width="25" alt="/">
								<p>Вы подписаны</p>
							</div>
						<?php endif; ?>
						</div>
						<div>
							<?= htmlspecialcharsbx($user['PERSONAL_NOTES']) ?>
						</div>
					</p>
				</div>
			</div>
		</article>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>

	</div>
</div>

<script>
	document.forms.form_user_search.onsubmit = function() {
		let searchInput = this.search.value.trim();
		let error = false;
		searchInput = searchInput.replaceAll(' ', '');

		if (searchInput.length  < 3)
		{
			let searchInputClass = document.querySelector('#search-input');
			searchInputClass.classList.add('is-danger', 'is-focused');
			error = true;
				alert('Укажите более точную информацию о пользователе!')
				return false;
		}

		if (searchInput.length  > 50)
		{
			let searchInputClass = document.querySelector('#search-input');
			searchInputClass.classList.add('is-danger', 'is-focused');
			error = true;
			alert('Слишком много символов в поиске!')
			return false;
		}

		return true;
	};
</script>