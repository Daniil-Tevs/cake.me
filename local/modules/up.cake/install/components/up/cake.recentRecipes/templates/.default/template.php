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

$recipes = $arResult['RECIPES'];
$images = $arResult['IMAGES'];

Loc::loadMessages(__FILE__);
?>

<div class="content">

	<h3>Вы недавно посещали:</h3>

	<?php if (empty($recipes)): ?>
		<p>Здесь пока пусто</p>
	 <?php else: ?>
	<?php foreach ($recipes as $recipe): ?>
	<div class="box box-user-search">
		<article class="media">
			<div class="media-left">
				<a href="/detail/<?= (int)$recipe['ID'] ?>/">
					<?= CFile::ShowImage((int)$images[$recipe['ID']]['IMAGE_ID'], 100, 150, "border=1", ""); ?>
				</a>
			</div>
			<div class="media-content">
				<div class="content">
					<p>
						<a href="/detail/<?= (int)$recipe['ID'] ?>/">
							<strong><?= $recipe['NAME'] ?></strong>
						</a>
						<br>
						...
					</p>
				</div>
			</div>
		</article>
	</div>
	<?php endforeach; ?>
	<?endif; ?>
</div>