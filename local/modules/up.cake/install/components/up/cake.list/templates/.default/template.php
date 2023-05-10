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

\Bitrix\Main\UI\Extension::load('up.recipe-list');

Loc::loadMessages(__FILE__);
?>

<?php if ($arResult["SUCCESS_AUTH_MESSAGE"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Авторизация успешна!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["CREATE_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Рецепт создан!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["SESSION_ERROR"] === true): ?>
	<div class="notification is-danger is-light error-edit-recipe">
		<p>Что-то пошло не так!</p>
	</div>
<?php endif; ?>

<?php if ($arResult["UPDATE_SUCCESS"] === true): ?>
	<div class="notification is-primary is-light error-edit-recipe">
		<p>Рецепт обновлен!</p>
	</div>
<?php endif; ?>

<div id="recipe-list" class = "card-lists"></div>

<script>
	window.step = 1

	BX.ready(function() {
		window.CakeRecipeList = new BX.Up.Cake.RecipeList({
			rootNodeId: 'recipe-list',
			userId: <?=$arParams['USER']?>,
		});
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

	async  function checkPosition() {
		const height = document.body.offsetHeight
		const screenHeight = window.innerHeight
		const scrolled = window.scrollY

		const threshold = height - screenHeight / 8
		const position = scrolled + screenHeight

		if (position >= threshold && !window.CakeRecipeList.END_PAGE) {
			window.step++;
			await window.CakeRecipeList.reload(window.step);
		}
	}

	window.addEventListener('scroll', throttle(checkPosition,1000))

	document.categoryActive = false;
	async function displayCategory()
	{

		if(!document.categoryActive)
		{
			document.getElementById('category').classList.add('is-active');
			document.categoryActive = true;
		}
		else{
			document.getElementById('category').classList.remove('is-active');
			document.categoryActive = false;
		}
	}
</script>
