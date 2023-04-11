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

Loc::loadMessages(__FILE__);
$recipe = $arResult['RECIPE'];
var_dump($recipe);
?>


	<div class="column">
		<div class="card">
			<div class="card-image">
				<figure class="image is-4by3">
					<img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
				</figure>
			</div>
			<div class="card-content">
				<div class="content">
					<a class="title mb-2" href="#"><?=$recipe['name']?> </a>
					<hr>
					<p><?=$recipe['description']?></p>
				</div>
			</div>
			<footer class="card-footer">
				<div class="card-footer-item">🕔 <?=$recipe['time']?></div>
				<div class="card-footer-item">🔥 135 calories</div>
				<div class="card-footer-item "><a href="#">👨‍🍳 <?=$recipe['user']?></a></div>
			</footer>
		</div>
	</div>

</div>
