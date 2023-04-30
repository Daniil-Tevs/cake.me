<?php

namespace Up\Cake\Service;

class TagService
{
	public static function get()
	{
		return \UP\Cake\Model\TagTable::query()->setSelect(['*'])->fetchCollection();
	}

	public static function getWithCategory()
	{
		$result = [];
		foreach (\UP\Cake\Model\CategoryTable::query()->setSelect(['*','TAGS'])->fetchCollection() as $category)
		{
			$result[$category->getName()] = [];
			foreach ($category->getTags() as $tag)
			{
				$result[$category->getName()][] = $tag;
			}
		}
		return $result;
	}
}