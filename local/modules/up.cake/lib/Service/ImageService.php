<?php

namespace Up\Cake\Service;

use Bitrix\Main\FileTable;

class ImageService
{
	public static function get(): array
	{
		$images = [];
		foreach (FileTable::query()->setSelect(['*'])->whereLike('MODULE_ID',"up.cake_%_1")->fetchCollection() as $img)
		{
			$images[$img->getModuleId()] = "/upload/{$img->getSubdir()}/{$img->getFileName()}";
		}
		return $images;
	}

	public static function getById($id): array
	{
		$images = [];
		foreach (FileTable::query()->setSelect(['*'])->whereLike('MODULE_ID',"up.cake_{$id}_%")->fetchCollection() as $img)
		{
			$images[] = "/upload/{$img->getSubdir()}/{$img->getFileName()}";
		}
		return $images;
	}
}