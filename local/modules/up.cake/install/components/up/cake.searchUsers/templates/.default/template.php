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


	<div class="box box-search-user">
		<h1>Поиск пользователей</h1>
		<p>(Введите имя и фамилию пользователя)</p>
		<hr>
		<div class="field">
			<form action="/search/users/" method="get">
			<div class="field has-addons">

				<div class="control">
					<input class="input input-search-user" type="text" name="search_name" placeholder="поиск по имени">
				</div>
				<div class="control">
					<input class="input input-search-user" type="text" name="search_last" placeholder="поиск по фамилии">
				</div>
				<button type="submit" class="button button-user-search is-link">найти</button>
			</div>

			</form>
		</div>
		<br>

		<?php if ($userRequest === true && empty($userList)): ?>
		<div class="field is-flex search-users-find-label">Найденные пользователи:</div>
		<br>

			<div class="field is-flex search-users-find-label"><h2>Пользователи не найдены</h2></div>

		<?php else: ?>
		<?php foreach ($userList as $user): ?>
		<div class="box box-user-search">
		<article class="media">
			<div class="media-left">
				<a href="/users/<?= (int)$user['ID'] ?>/">
				<figure class="image is-64x64">
					<?php if ((int)$user['PERSONAL_PHOTO'] === 0): ?>
						<?php if ($user['PERSONAL_GENDER'] === 'M'): ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" alt="/">
						<?php elseif ($user['PERSONAL_GENDER'] === 'F'): ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png" alt="/">
						<?php endif; ?>
					<?php else: ?>
						<?= CFile::ShowImage($user['PERSONAL_PHOTO'], 400, 400, "border=1", ""); ?>
					<?php endif; ?>
				</figure>
				</a>
			</div>
			<div class="media-content">
				<div class="content">
					<p>
						<a href="/users/<?= (int)$user['ID'] ?>/">
						<strong><?= htmlspecialcharsbx($user['NAME']) ?> <?= htmlspecialcharsbx($user['LAST_NAME']) ?></strong>
						</a>
						<br>
						<?= htmlspecialcharsbx($user['PERSONAL_NOTES']) ?>
					</p>
				</div>
			</div>
		</article>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>

	</div>
</div>