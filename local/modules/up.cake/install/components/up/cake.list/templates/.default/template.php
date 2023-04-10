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
?>

</div>


<?php
$i = 0;
foreach ($arResult['RECIPES'] as $recipe): ?>
	<?php
	echo ($i % $arParams['COUNT_ELEMENTS'] === 0) ? '<div class="columns">' : '';
	$i++; ?>
	<div class="column">
		<div class="card">
			<div class="card-image">
				<figure class="image is-4by3">
					<img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
				</figure>
			</div>
			<div class="card-content">
				<div class="content">
					<a class="title mb-2" href="#"><?=$recipe['NAME']?> </a>
					<hr>
					<p><?=mb_strcut($recipe['DESCRIPTION'],0,$arParams['LENGTH_DESCRIPTION'],$arParams['ENCODING'])?></p>
				</div>
			</div>
			<footer class="card-footer">
				<div class="card-footer-item">🕔 90 min</div>
				<div class="card-footer-item">🔥 135 calories</div>
				<div class="card-footer-item "><a href="#">👨‍🍳 Nikita Pavlodarov</a></div>
			</footer>
		</div>
	</div>
	<?= ($i % 3 === 0) ? '</div>' : ''; ?>
<?php
endforeach; ?>
</div>
