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

<div class="columns mb-6">
	<div class="column">
		<div class="field">
			<div class="control">
				<form id="search" action="/" method="get">
					<input class="input" name="title" type="text" placeholder="<?= Loc::getMessage("UP_TASKS_SEARCH");?>">
				</form>
			</div>
		</div>
	</div>
	<div class="column">
		<a class="button is-success is-pulled-right" href="/tasks/create/"><?= Loc::getMessage("UP_TASKS_CREATE_TASK");?></a>
	</div>
</div>


<?php $i = 0; foreach ($arResult['TASKS'] as $task): ?>
	<?php echo ($i % 3 === 0) ? '<div class="columns">' : ''; $i++; ?>
	<div class="column">
		<div class="card project-card">
			<header class="card-header is-<?=htmlspecialcharsbx(strtolower($task->getPriority()->getName()));?>">
				<a class="card-header-title" href="/tasks/edit/<?= htmlspecialcharsbx($task->getId())?>/">
					<?= htmlspecialcharsbx($task->getName()) ?>
				</a>
				<button class="card-header-icon" aria-label="more options">
					<a href="/tasks/delete/?task=<?= htmlspecialcharsbx($task->getId()) ?>"><span class="tag is-delete"></span></a>
				</button>
			</header>
			<div class="card-content">
				<div class="content">
					<?= htmlspecialcharsbx($task->getDescription()) ?>
				</div>
			</div>
			<footer class="card-footer">
				<span class="card-footer-item is-size-7"><strong><?= Loc::getMessage("UP_TASKS_DATE_CREATED");?></strong>: <?= htmlspecialcharsbx($task->getDateCreation()->format($arParams['DATE_FORMAT'])); ?></span>
				<span class="card-footer-item is-size-7"><strong><?= Loc::getMessage("UP_TASKS_PRIORITY");?></strong>: <?= htmlspecialcharsbx($task->getPriority()->getName()); ?></span>
			</footer>
		</div>
	</div>
	<?= ($i % 3 === 0) ? '</div>' : ''; ?>
<?php endforeach; ?>
</div>
