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
[$recipe, $ingredients] = $arResult['RECIPE'];
$images = $arResult['IMAGES'];
$mainImages = $arResult['RECIPE_MAIN_IMAGES'];
$instructionImages = $arResult['RECIPE_INSTRUCTIONS_IMAGES'];
?>

<div class="column">
	<div class="card detail-card">
		<div class="card-content">
			<div class="content is-size-6">
				<div class="title mb-2"><?= htmlspecialcharsbx($recipe->getName()) ?> </div>
				<hr>
				<div class="tags are-large">
					<?php
					foreach ($recipe->getTags() as $tag): ?>
						<span class="tag is-danger is-light"><?= htmlspecialcharsbx($tag->getName()) ?></span>
					<?php
					endforeach; ?>
				</div>
				<p><?= htmlspecialcharsbx($recipe->getDescription()) ?></p>
			</div>
		</div>

		<div class="swiper">
			<div class="swiper-wrapper">
				<?php
				for ($i = 0,$iMax = count($mainImages); $i < $iMax; $i++): ?>
					<div class="swiper-slide">
<!--						<img src="--><?//= $image ?><!--" alt="">-->

						<?= CFile::ShowImage($mainImages[$i]['IMAGE_ID'], 200, 200, "border=0", "", true); ?>
					</div>
				<?php endfor; ?>
				<div class="swiper-pagination"></div>
			</div>

			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>

		<div class="card-content">
			<div class="media">
				<div class="media-left">
					<figure class="image is-48x48">
						<img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
					</figure>
				</div>
				<div class="media-content">
					<p class="title is-4"><a href="#"> <?= htmlspecialcharsbx(
								$recipe->getUser()->getName() . $recipe->getUser()->getLastName()
							) ?> </a></p>
				</div>
			</div>
		</div>

		<footer class="card-footer">
			<div class="card-footer-item is-size-6">Время приготовления: <?= htmlspecialcharsbx(
					$recipe->getTime()
				) ?> минут
			</div>
			<div class="card-footer-item is-size-6">Калории: <?= htmlspecialcharsbx($recipe->getCalories()) ?></div>
			<div class="card-footer-item is-size-6">Количество порций: <?= htmlspecialcharsbx(
					$recipe->getPortionCount()
				) ?></div>
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
			<?php
			$countIngredient = 0;
			foreach ($ingredients as $ingredient): ?>
				<tr>
					<th><?= $countIngredient + 1 ?></th>
					<td><?= htmlspecialcharsbx($ingredient->getIngredient()->getName()) ?></td>
					<td><?= htmlspecialcharsbx($ingredient->getCount()) ?> <?= htmlspecialcharsbx(
							$ingredient->getTypeId()
						) ?></td>
				</tr>
				<?php
				$countIngredient++; endforeach; ?>
			</tbody>
		</table>

		<?php
		$instructionCount = 0;
		foreach ($recipe->getInstructions() as $instruction): ?>
		<div class="field is-flex">
			<div class="detail-instruction-image">
				<?= CFile::ShowImage($instructionImages[$instructionCount]['IMAGE_ID'], 200, 200, "border=0", "", true); ?>
			</div>
			<div class="box is-size-6 detail-instruction-box">
				<div class="content ml-2">
					<h2>Шаг <?= htmlspecialcharsbx($instruction->getStep()) ?> </h2>
				</div>
				<?= htmlspecialcharsbx($instruction->getDescription()) ?>
			</div>
		</div>
		<?php
			$instructionCount++;
		endforeach; ?>
	</div>
</div>

</div>
<script>let swiper = new Swiper('.swiper', {
		spaceBetween: 5,
		loop: true,

		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},

		pagination: {
			el: '.swiper-pagination',
		},

		mousewheel: false,
		keyboard: true,
	});
</script>
