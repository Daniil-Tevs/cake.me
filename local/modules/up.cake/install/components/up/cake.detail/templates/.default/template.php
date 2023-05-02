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

\Bitrix\Main\UI\Extension::load('up.recipe-comments');

[$recipe, $ingredients] = $arResult['RECIPE'];
$images = $arResult['IMAGES'];
$mainImages = $arResult['RECIPE_MAIN_IMAGES'];
$instructionImages = $arResult['RECIPE_INSTRUCTIONS_IMAGES'];

$UserImage = $arResult['PERSONAL_PHOTO'];
$UserGender = $arResult['GENDER'];
$isAuthor = $arResult['USER_AUTHOR'];
?>

<div class="column">
	<div class="card detail-card">
		<div class="card-content">
			<div class="content is-size-6">
				<div class="field is-flex detail-main-name-block">
					<div class="title mb-2"><?= htmlspecialcharsbx($recipe->getName()) ?> </div>
					<?php if ($isAuthor): ?>
					<a href="/recipe/edit/<?= $recipe->getId() ?>/" class="button is-info detail-edit-href">Редактировать</a>
					<?php endif; ?>
				</div>
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
				for ($i = 0, $iMax = count($mainImages); $i < $iMax; $i++): ?>
					<div class="swiper-slide">
						<?= CFile::ShowImage($mainImages[$i]['IMAGE_ID'], 200, 200, "border=0", "", true); ?>
					</div>
				<?php
				endfor; ?>
				<div class="swiper-pagination"></div>
			</div>

			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>

		<div class="card-content">
			<div class="media">
				<div class="media-left">
					<figure class="image is-48x48">
						<?php if ($UserGender === 'M'): ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" alt="/">
						<?php elseif ($UserGender === 'F'): ?>
						<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png" alt="/">
						<?php else: ?>
						<?= CFile::ShowImage($UserImage, 100, 100, "border=0", "", true); ?>
					<?php endif; ?>
					</figure>
				</div>
				<div class="media-content">
					<p class="title is-4"><a href="#"> <?= htmlspecialcharsbx(
								$recipe->getUser()->getName() . ' ' . $recipe->getUser()->getLastName()
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
					<?= CFile::ShowImage(
						$instructionImages[$instructionCount]['IMAGE_ID'],
						200,
						200,
						"border=0",
						"",
						true
					); ?>
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
		<hr>
	</div>

	<div class="container comment-section">
		<h2>Комментарии:</h2>
		<hr>
		<div id="comment-list" class="comments">Будьте первым!</div>
		<div class="add-comment">
			<form id = "comment-form" action="" class="comment-form">
				<textarea id = "comment-textarea" class="textarea" placeholder="Добавить комментарий"></textarea>
				<input type="image" class="comment-form-image"  src="/local/modules/up.cake/install/templates/cake/images/comment.png" alt="Submit Form" />
			</form>
		</div>
	</div>
</div>

</div>

<script>
	let swiper = new Swiper('.swiper', {
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

	async function displayCategory()
	{
		document.location.href = '/';
	}


	window.stepComment = 1

	BX.ready(function() {
		window.CakeCommentList = new BX.Up.Cake.RecipeComments({
			rootNodeId: 'comment-list',
			recipeId: <?= htmlspecialcharsbx($recipe->getId()) ?>,
		})
	})


	function throttle(callee, timeout) {
		let timer = null

		return function perform(...args) {
			if (timer) return

			timer = setTimeout(() => {
				callee(...args)

				clearTimeout(timer)
				timer = null
			}, timeout)
		}
	}

	const comments = document.getElementById('comment-list');
	async  function checkPosition() {
		const height = comments.offsetHeight;
		const screenHeight = comments.scrollHeight;
		const scrolled = comments.scrollTop;

		const threshold = screenHeight *0.9;
		const position = scrolled + height

		if (position >= threshold && !window.CakeCommentList.END_PAGE) {
			window.stepComment++;
			await window.CakeCommentList.reload(window.stepComment);
			setTimeout(checkPosition,2000);
		}
	}

	comments.addEventListener('scroll', throttle(checkPosition))

	let form = document.getElementById('comment-form');
	form.addEventListener('submit', addComment);

	function addComment(event)
	{
		event.preventDefault();
		let title = document.getElementById('comment-textarea').value;
		document.getElementById('comment-textarea').value = '';
		window.CakeCommentList.addComment(title);
		comments.scrollTop = 0;
	}

</script>
