<?php

namespace Up\Cake\Service;

use Bitrix\Main\Type\Date;
use UP\Cake\Model\CommentTable;
use UP\Cake\Model\ReactionTable;
use UP\Cake\Model\UserSubsTable;

class NotificationService
{
	private static function getRecipeName($recipeId,$userRecipes):string
	{
		foreach ($userRecipes as $recipe)
		{
			if((int)$recipe['ID'] === (int)$recipeId)
				return $recipe['NAME'];
		}
		return '';
	}

	static function get(string $userLogin = ''): array
	{
		$user = \CUser::GetByLogin($userLogin)->Fetch();
		$userId = (int)$user['ID'];
		$dateLogin = new Date( $user['LAST_LOGIN']);
		$userRecipes = RecipeService::getRecipeByUserId($userId);
		$userRecipesIds = array_map(fn($recipe)=>$recipe['ID'],$userRecipes);
		$userRecipesIds = (!empty($userRecipesIds))?$userRecipesIds:[0];

		$likes = array_map(fn($item)=>['like',$item['USER_ID'],$item['RECIPE_ID'],self::getRecipeName($item['RECIPE_ID'],$userRecipes),$item['DATE_ADDED']],ReactionTable::query()->setSelect(['RECIPE_ID','USER_ID','DATE_ADDED'])->whereIn('RECIPE_ID',$userRecipesIds)->where('USER_ID','!=',$userId)->where('DATE_ADDED','>=',$dateLogin)->setOrder(['DATE_ADDED'=>'DESC'])->fetchAll());
		$comments = array_map(fn($item)=>['comment',$item['USER_ID'],$item['RECIPE_ID'],self::getRecipeName($item['RECIPE_ID'],$userRecipes),$item['DATE_ADDED']],CommentTable::query()->setSelect(['RECIPE_ID','USER_ID','DATE_ADDED'])->whereIn('RECIPE_ID',$userRecipesIds)->where('USER_ID','!=',$userId)->where('DATE_ADDED','>=',$dateLogin)->setOrder(['DATE_ADDED'=>'DESC'])->fetchAll());
		$subs = array_map(fn($item)=>['subs',$item['USER_ID'],$item['DATE_ADDED']],UserSubsTable::query()->setSelect(['USER_ID','DATE_ADDED'])->where('SUB_ID',$userId)->where('DATE_ADDED','>=',$dateLogin)->setOrder(['DATE_ADDED'=>'DESC'])->fetchAll());

		$result = array_merge($likes,$comments,$subs);
		$resLen = count($result);
		for( $i=0; $i<$resLen-1;$i++)
		{
			for( $j=$i+1; $j<$resLen;$j++)
			{
				if(strtotime($result[$i][count($result[$i])-1])<strtotime($result[$j][count($result[$j])-1]))
				{
					$tmp = $result[$i];
					$result[$i] = $result[$j];
					$result[$j] = $tmp;
				}
			}
		}
		return $result;
	}

	function render(array $notification):string
	{
		if(empty($notification))
		{
			return '';
		}
		$className = 'notification-data';
		$type = $notification[0];
		$userSub = \CUser::GetByID((int)$notification[1])->Fetch();
		$userId = (int)$userSub['ID'];
		$userName = htmlspecialcharsbx($userSub['NAME'] . ' ' . $userSub['LAST_NAME']);
		if ($type === 'like' || $type === 'comment')
		{
			$recipeId = (int)$notification[2];
			$recipeName = htmlspecialcharsbx($notification[3]);
			$action = ($type === 'like')? 'оценил ваш рецепт': 'оставил комментарий насчёт вашего рецепта';
			$className .= ($notification[5])?'-active':'';
			return "<div class={$className}>Пользователь <a href='/users/{$userId}/'>{$userName}</a> {$action} \"<a href='/detail/{$recipeId}/'>{$recipeName}</a>\"</div>";
		}
		elseif ($type === 'subs')
		{
			$userName = htmlspecialcharsbx($userSub['NAME'] . ' ' . $userSub['LAST_NAME']);
			$className .= ($notification[3])?'-active':'';
			return "<div class={$className}>Пользователь <a href='/users/{$userId}/'>{$userName}</a> подписался на вас.</div>";
		}
		return "";
	}
}