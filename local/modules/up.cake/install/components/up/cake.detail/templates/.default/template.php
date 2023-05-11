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
<style> .search-container,.filter {display: none;}</style>

<?php if ($arResult["CREATE_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Рецепт создан!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["UPDATE_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Рецепт обновлен!</p>
	</div>
<?php endif; ?>

<div class="column">
	<div class="card detail-card">
		<div class="card-content">
			<div class="content is-size-6">
				<div class="content-header">
					<div class="field is-flex detail-main-name-block">
						<div class="title mb-2"><?= htmlspecialcharsbx($recipe->getName()) ?> </div>
						<?php if ($isAuthor): ?>
							<a href="/recipe/edit/<?= (int)$recipe->getId() ?>/" class="button is-info detail-edit-href">Редактировать</a>
						<?php endif; ?>
					</div>
					<?php if($arResult['IS_AUTH']):?>
						<button class="like <?= ($arResult['USER_REACTION'])?'like-active': ''?>" id="like-btn" value="<?=(int)$recipe->getId();?>" onclick="changeLike(this.value)"></button>
					<?php endif;?>
				</div>

				<hr>
				<div class="tags are-large">
					<?php
					foreach ($recipe->getTags() as $tag): ?>
						<span class="tag is-danger is-light"><?= htmlspecialcharsbx($tag->getName()) ?></span>
					<?php
					endforeach; ?>
				</div>
				<p><?= str_replace(['\r\n', '\&quot;', '\\\''],['<br>', '"', '\''],htmlspecialcharsbx($recipe->getDescription())) ?></p>
				<div class="media">
					<div class="media-left">
						<a href="/users/<?= (int)$recipe->getUser()->getId() ?>/">

							<?php if ($UserGender === 'M'): ?>
								<figure class="image is-48x48">
									<img src="/local/modules/up.cake/install/templates/cake/images/profileMale.png" alt="/" class="'is-rounded">
								</figure>
							<?php elseif ($UserGender === 'F'): ?>
								<figure class="image is-48x48">
									<img src="/local/modules/up.cake/install/templates/cake/images/profileFemale.png " alt="/" class="'is-rounded">
								</figure>
							<?php else: ?>
								<?= CFile::ShowImage($UserImage, 48, 48,"border-radius=10px", "", false); ?>
							<?php endif; ?>
					</div>
					</a>
					<div class="media-content media-content-detail-page">
						<p class="title is-5"><a href="/users/<?= (int)$recipe->getUser()->getId() ?>/"> <?= htmlspecialcharsbx(
									$recipe->getUser()->getName() . ' ' . $recipe->getUser()->getLastName()
								) ?> (<?= htmlspecialcharsbx($recipe->getUser()->getLogin()) ?>)</a></p>
					</div>
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
		</div>

		<footer class="card-footer">
			<div class="card-footer-item is-size-6">🕔 Время приготовления: <?= (int)$recipe->getTime()?> минут
			</div>
			<div class="card-footer-item is-size-6">🔥 Калории:<?php if ((int)$recipe->getCalories() !== 0):
				echo (int)$recipe->getCalories(); else: echo ' не указаны'; endif; ?></div>
			<div class="card-footer-item is-size-6">🍽️ Количество порций: <?= (int)$recipe->getPortionCount() ?></div>
		</footer>
		<p class="title is-4 detail-ingredient" style="margin:0">Ингредиенты:</p>
			<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth" style="margin:0">
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
						<td><?= (float)$ingredient->getCount() ?> <?= htmlspecialcharsbx(
								$ingredient->getTypeId()
							) ?></td>
					</tr>
					<?php
					$countIngredient++; endforeach; ?>
				</tbody>
			</table>
		<div class="instructions">
			<?php
			$instructionCount = 0;
			foreach ($recipe->getInstructions() as $instruction): ?>
				<div class="field is-flex is-detail-instruction-block">
					<div class="detail-instruction-image">
						<?php if ((int)$instructionImages[$instructionCount]['IMAGE_ID'] !== 0): ?>
						<?= CFile::ShowImage(
							(int)$instructionImages[$instructionCount]['IMAGE_ID'],
							200,
							200,
							"border=0",
							"",
							true
						); ?>
						<?php else: ?>
							<img src="/local/modules/up.cake/install/templates/cake/images/emptyImage3.png" height="150" width="200" alt="/" class="'is-rounded">
						<?php endif; ?>
					</div>
					<div id="detail-instruction-box" class="box detail-instruction-box">
						<div class="content ml-2">
							<h2>Шаг <?= (int)$instruction->getStep() ?> </h2>
						</div>
						<div class="content ml-2">
							<?= str_replace(['\r\n', '\&quot;', '\\\''],['<br>', '"', '\''], htmlspecialcharsbx($instruction->getDescription())) ?>
						</div>

					</div>
				</div>
				<?php
				$instructionCount++;
			endforeach; ?>
		</div>
		</div>

		<div class="container comment-section">
			<h2>Комментарии:</h2>
			<hr>
			<div id="comment-list" class="comments">Будьте первым!</div>
			<?php if($arResult['IS_AUTH']):?>
				<div class="add-comment">
					<form id = "comment-form" action="" class="comment-form">
						<textarea id = "comment-textarea" class="textarea" placeholder="Добавить комментарий"></textarea>
						<input type="image" class="comment-form-image"  src="/local/modules/up.cake/install/templates/cake/images/comment.png" alt="Submit Form" />
					</form>
				</div>
			<?php endif;?>
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
			recipeId: <?= (int)$recipe->getId() ?>,
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
		}
	}

	comments.addEventListener('scroll', throttle(checkPosition,2000))

	let userReaction = <?= ($arResult['USER_REACTION'])?1:0?>

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

	async function changeLike(recipeId)
	{
		recipeId = Number(recipeId);

		(!userReaction) ? await addLike(recipeId) : await removeLike(recipeId);
	}

	async function addLike(recipeId)
	{
		BX.ajax.runAction('up:cake.reaction.addLikeThisUser', {
				data: {
					recipeId: recipeId,
				},
			})
			.then(() => {
				userReaction = true;
				document.getElementById(`like-btn`).classList.add('like-active');
			})
			.catch((error) => {
				console.log(error);
			});
	}

	async function removeLike(recipeId)
	{
		BX.ajax.runAction('up:cake.reaction.removeLikeThisUser', {
				data: {
					recipeId: recipeId,
				},
			})
			.then(() => {
				userReaction = false;
				document.getElementById(`like-btn`).classList.remove('like-active');
			})
			.catch((error) => {
				console.log(error);
			});
	}

</script>
