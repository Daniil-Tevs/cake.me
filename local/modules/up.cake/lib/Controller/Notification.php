<?php

namespace UP\Cake\Controller;

use Up\Cake\Service\NotificationService;

class Notification extends \Bitrix\Main\Engine\Controller
{
	public function getListAction(string $userLogin): void
	{
		$result = NotificationService::get($userLogin);
		$session = \Bitrix\Main\Application::getInstance()->getSession();
		$storedNotification = $session->get('USER_NOTIFICATION')??[];
		$session->set('USER_NOTIFICATION', $result);
		$session->set('IS_USER_NOTIFICATION', !(count($storedNotification) === count($result)));
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