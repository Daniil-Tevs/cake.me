<?php

namespace Up\Cake\Service;


use CFile;
use UP\Cake\Model\RecipeImageTable;

class TestImageData
{
	public static function addTestData()
	{
		$dir = 'local/modules/up.cake/images/brauni';
		self::addRecipeImages(7, 1, $dir);

		$dir = 'local/modules/up.cake/images/spagetti';
		self::addRecipeImages(6, 2, $dir);

		$dir = 'local/modules/up.cake/images/sirniky';
		self::addRecipeImages(5, 3, $dir);

		$dir = 'local/modules/up.cake/images/limonad';
		self::addRecipeImages(2, 4, $dir);

		$dir = 'local/modules/up.cake/images/caesar';
		self::addRecipeImages(4, 5, $dir);

		$dir = 'local/modules/up.cake/images/italicSoupe';
		self::addRecipeImages(3, 6, $dir);

		$dir = 'local/modules/up.cake/images/buter';
		self::addRecipeImages(5, 7, $dir);

		$dir = 'local/modules/up.cake/images/pechenVsmetane';
		self::addRecipeImages(3, 8, $dir);

		$dir = 'local/modules/up.cake/images/sous';
		self::addRecipeImages(1, 9, $dir);

		$dir = 'local/modules/up.cake/images/pure';
		self::addRecipeImages(5, 10, $dir);

	}

	protected static function addRecipeImages($mainCount, $recipeId, $dir): void
	{
		$imagesName = scandir($dir);

		array_shift($imagesName);
		array_shift($imagesName);
		foreach ($imagesName as $i => $item)
		{
			$isMain = 0;
			if ($i > $mainCount)
			{
				$isMain = 1;
			}

			$filePath = $_SERVER['DOCUMENT_ROOT']. '/' . $dir . '/' . $item;

			$arFile = CFile::MakeFileArray($filePath);
			$fileId = CFile::SaveFile($arFile, "tmp/recipe-image");

			$imageQuery = \UP\Cake\Model\RecipeImageTable::createObject();
			$imageQuery->setRecipeId($recipeId)->setImageId($fileId)->setIsMain($isMain)->setNumber($i+1)->save();
		}
	}

}