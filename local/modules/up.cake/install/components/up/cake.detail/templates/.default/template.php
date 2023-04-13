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
					<div class="title mb-2"><?=htmlspecialcharsbx($recipe->getName())?> </div>
					<hr>
					<div class="tags are-large">
						<?php foreach ($recipe->getTags() as $tag):?>
						<span class="tag is-danger is-light"><?= htmlspecialcharsbx($tag->getName()) ?></span>
						<?php endforeach; ?>
					</div>
					<p ><?=htmlspecialcharsbx($recipe->getDescription())?></p>
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
						<p class="title is-4"><a href="#"> <?=htmlspecialcharsbx($recipe->getUser()->getName() . $recipe->getUser()->getLastName())?> </a></p>
					</div>
				</div>
			</div>

			<footer class="card-footer">
				<div class="card-footer-item is-size-6">Время приготовления: <?=htmlspecialcharsbx($recipe->getTime())?> минут</div>
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
				foreach ($recipe->getIngredients() as $ingredient): ?>
				<tr>
					<th><?= $countIngredient + 1  ?></th>
					<td><?= htmlspecialcharsbx($ingredient->getName()) ?></td>
					<td>заглушка</td>
				</tr>
				<?php $countIngredient++; endforeach; ?>
				</tbody>
			</table>

			<?php foreach ($recipe->getInstructions() as $instruction):?>
				<div class="box is-size-6">
					<div class="content ml-2">
						<h2>Шаг <?= htmlspecialcharsbx($instruction->getStep())?> </h2>
					</div>
				<?= htmlspecialcharsbx($instruction->getDescription()) ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>
