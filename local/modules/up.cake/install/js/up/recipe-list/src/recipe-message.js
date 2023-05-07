import { Tag } from 'main.core';

export class RecipeMessage
{
	messageNode;
	constructor(type)
	{
		if (type === 'profile')
		{
			this.messageNode = this.profileMessage();
		}
		else
		{
			this.messageNode = this.simpleMessage();
		}
	}

	simpleMessage()
	{
		return Tag.render`<div class="not-found-block">
<figure class="image not-found">
<img src="/local/modules/up.cake/install/templates/cake/images/NotFound.png">
<figcaption>Ничего не найдено</figcaption>
</div>

</figure>`;
	}

	profileMessage()
	{
		document.getElementsByClassName('your-recipe').item(0).innerHTML =`<p>У вас пока нет рецептов</p>`;
		return Tag.render``;
	}
}