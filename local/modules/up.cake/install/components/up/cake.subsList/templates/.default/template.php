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

Loc::loadMessages(__FILE__);
?>

<style> .tags {display: none;}</style>

<div class="content">


	<div class="box box-search-user">
		<h1>Ваши подписки:</h1>
		<hr>
		<br>

		<?php if (empty($userList)): ?>
		<div class="field is-flex search-users-find-label">Вы не подписаны на других пользователей!</div>

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