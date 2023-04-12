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
// var_dump($recipe);
?>


	<div class="column">
		<div class="card detail-card">
			<div class="card-image">
				<figure class="image is-4by3">
					<img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">

				</figure>

			</div>
			<div class="card-content">
				<div class="content is-size-6">
					<div class="title mb-2"><?=$recipe['name']?> </div>
					<hr>
					<p ><?=$recipe['description']?></p>
				</div>
			</div>

			<div class="card-content">
				<div class="media">
					<div class="media-left">
						<figure class="image is-48x48">
							<img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
						</figure>
					</div>
					<div class="media-content">
						<p class="title is-4"><a href="#"> <?=$recipe['user']?> </a></p>
					</div>
				</div>
			</div>

			<footer class="card-footer">
				<div class="card-footer-item is-size-6">Время приготовления: <?=$recipe['time']?> минут</div>
				<div class="card-footer-item is-size-6">Калории: 135 calories</div>
			</footer>
			<hr>
			<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
				<thead>
				<tr>
					<th></th>
					<th>Название</th>
					<th>Количество</th>
				</tr>
				</thead>
				<tbody>
				<?php $countIngredient = 0;
				foreach ($recipe['ingredient'] as $ingredient): ?>
				<tr>
					<th><?= $countIngredient + 1  ?></th>
					<td><?= $ingredient[0] ?></td>
					<td><?= $ingredient[1] ?> <?= $ingredient[2] ?></td>
				</tr>
				<?php $countIngredient++; endforeach; ?>
				</tbody>
			</table>

			<?php $stepInstructions = 1;
			foreach ($recipe['instructions'] as $instructions):?>
				<div class="box is-size-6">
					<div class="content ml-2">
						<h2>Шаг <?php echo $stepInstructions; $stepInstructions++; ?> </h2>
					</div>
				<?= $instructions ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>
