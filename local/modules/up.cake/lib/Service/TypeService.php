<?php

namespace Up\Cake\Service;

use UP\Cake\Model\TypeTable;

class TypeService
{
	public static function get()
	{
		return \UP\Cake\Model\TypeTable::query()->setSelect(['ID'])->fetchCollection();
	}
}