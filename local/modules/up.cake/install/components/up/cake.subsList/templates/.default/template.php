<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Localization\Loc;

CJSCore::Init(["jquery"]);
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

\Bitrix\Main\UI\Extension::load('up.subscribe-list');

$userList = $arResult['USERS'];

Loc::loadMessages(__FILE__);
?>

<style> .tags {display: none;}</style>
<br>
<br>
<div class="field">
	<a class="button is-link is-light" id="sub1" onclick="buttonSubs1()">Подписки</a>
	<a class="button is-link is-light" id="sub2" onclick="buttonSubs2()">Подписчики</a>
</div>
<br>
<div class="content content-subs-list">

</div>


<script>
	buttonSubs1();

	function buttonSubs1()
	{
		window.stepSubs = 1
		window.CakeSubscribeList = '';
		let field1 = document.querySelector('.field-subs1-list');
		let field2 = document.querySelector('.field-subs2-list');

		if (field2)
		{
			field2.remove();
			let button2 = document.getElementById('sub2');
			if (!button2.classList.contains('is-light'))
			{
				button2.classList.add('is-light');
			}
		}

		let $element = `
				<div class="field field-subs1-list">
					<h2>Ваши подписки:</h2>
					<hr>
					<div id="subs-list"></div>
				</div>
		`;

		if (!field1)
		{
			// let contentField = document.querySelector('.content-subs-list');
			$('.content-subs-list').append($element);
			let button1 = document.getElementById('sub1');
			button1.classList.remove('is-light');

			window.CakeSubscribeList = new BX.Up.Cake.SubscribeList({
				rootNodeId: 'subs-list',
				userId: <?= (int)($USER->GetID()) ?>,
				subs2: 0,
			})
		}

	}

	function buttonSubs2()
	{
		window.stepSubs = 1
		window.CakeSubscribeList = '';
		let field1 = document.querySelector('.field-subs1-list');
		let field2 = document.querySelector('.field-subs2-list');

		if (field1)
		{
			field1.remove();
			let button1 = document.getElementById('sub1');
			if (!button1.classList.contains('is-light'))
			{
				button1.classList.add('is-light');
			}
		}

		let $element = `
				<div class="field field-subs2-list">
					<h2>Ваши подписчики:</h2>
					<hr>
					<div id="subs-list"></div>
				</div>
		`;

		if (!field2)
		{
			let contentField = document.getElementsByClassName('content-subs-list');
			$('.content-subs-list').append($element);
			let button2 = document.getElementById('sub2');
			button2.classList.remove('is-light');

			window.CakeSubscribeList = new BX.Up.Cake.SubscribeList({
				rootNodeId: 'subs-list',
				userId: <?= (int)($USER->GetID()) ?>,
				subs2: 1,
			})
		}

	}


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

		if (position >= threshold && !window.CakeSubscribeList.END_PAGE) {
			// console.log(window.stepSubs);
			window.stepSubs++;
			await window.CakeSubscribeList.reload(window.stepSubs,1000);
		}
	}

	window.addEventListener('scroll', throttle(checkPosition))
</script>