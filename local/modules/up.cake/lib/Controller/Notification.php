<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\NotificationService;

class Notification extends \Bitrix\Main\Engine\Controller
{
	public function getListAction(string $userLogin): void
	{
		$isNew = false;
		$result = NotificationService::get($userLogin);
		$session = \Bitrix\Main\Application::getInstance()->getSession();
		$storedNotification = $session->get('USER_NOTIFICATION')??[];
		$result = array_map(function($notification) use ($storedNotification) {
			$not1 =array_merge($notification,[false]);
			$not2 =array_merge($notification,[true]);
			$notification[] = !((in_array($not1, $storedNotification, false)) || (in_array($not2, $storedNotification, false)));
			return $notification;
			},$result);
		foreach ($result as $notify)
		{
			if ($notify[count($notify)-1])
			{
				$isNew = true;
				break;
			}
		}
		$session->set('USER_NOTIFICATION', $result);
		$session->set('IS_USER_NOTIFICATION', $isNew);
	}

	public function getListAfterAuthAction(): void
	{
		global $USER;
		if($USER->IsAuthorized())
		{
			$this->getListAction($USER->GetLogin());
		}
	}

	public function setUncheckAction(): void
	{
		session()->set('IS_USER_NOTIFICATION',false);
	}

	protected function getDefaultPreFilters()
	{
		return [
			new \Bitrix\Main\Engine\ActionFilter\HttpMethod(
				[
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_GET,
					\Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_POST
				],
			),
			new \Bitrix\Main\Engine\ActionFilter\Csrf(),];
	}
}