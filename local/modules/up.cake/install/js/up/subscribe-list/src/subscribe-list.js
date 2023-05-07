import {Type} from 'main.core';

export class SubscribeList
{
	constructor(options = {name: 'SubscribeList'})
	{
		this.name = options.name;
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}
}