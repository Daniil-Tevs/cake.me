<?php

namespace Up\Cake\Service;

use Bitrix\Main\FileTable;
use UP\Cake\Model\RecipeImageTable;

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

	public static function getById(int $id): array
	{
		$images = [];
		foreach (FileTable::query()->setSelect(['*'])->whereLike('MODULE_ID',"up.cake_{$id}_%")->fetchCollection() as $img)
		{
			$images[] = "/upload/{$img->getSubdir()}/{$img->getFileName()}";
		}
		return $images;
	}

	public static function getByIdIn(array $ids): array
	{
		$images = [];
		$ids = array_map(function($id){
			$id = (int)$id;
			return "up.cake_{$id}_1";
		},$ids);
		foreach (FileTable::query()->setSelect(['*'])->whereIN('MODULE_ID',$ids)->fetchCollection() as $img)
		{
			$images[$img->getModuleId()] = "/upload/{$img->getSubdir()}/{$img->getFileName()}";
		}
		return $images;
	}

	public static function getImageDetail(int $recipeId): array
	{
		$mainImages = RecipeImageTable::query()->setSelect(['IMAGE_ID', 'NUMBER'])->where('RECIPE_ID', $recipeId)
			->where('IS_MAIN', 1)->fetchAll();

		$instructionImages = RecipeImageTable::query()->setSelect(['IMAGE_ID', 'NUMBER'])->where('RECIPE_ID', $recipeId)
			->where('IS_MAIN', 0)->fetchAll();

		// echo '<pre>';
		// print_r($mainImages);
		// print_r($instructionImages); die;
		return ['RECIPE_MAIN_IMAGES' => $mainImages, 'RECIPE_INSTRUCTIONS_IMAGES' => $instructionImages];
	}

}