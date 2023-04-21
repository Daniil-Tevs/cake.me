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
$images = $arResult['IMAGES'];
?>

<div id="recipe-list"></div>

<script>
	let step = 1

	BX.ready(function() {
		window.CakeRecipeList = new BX.Up.Cake.RecipeList({
			rootNodeId: 'recipe-list',
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

	async  function checkPosition() {
		const height = document.body.offsetHeight
		const screenHeight = window.innerHeight
		const scrolled = window.scrollY

		const threshold = height - screenHeight / 8
		const position = scrolled + screenHeight

		if (position >= threshold && !window.CakeRecipeList.END_PAGE) {
			step++;
			window.scrollBy(0,-100);
			await window.CakeRecipeList.reload(step);
		}
	}

	window.addEventListener('scroll', throttle(checkPosition))

</script>