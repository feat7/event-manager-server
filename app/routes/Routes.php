<?php

namespace app\routes;


class Routes
{
	public function setRoutes()
	{
		$this->routes = [
			'/' => ['uses' => 'Welcome@welcomeToSurface'],
			'test' => ['uses' => 'Welcome@testDatabase'],
			'api-register' => ['uses' => 'AuthController@register'],
			'api-login' => ['uses' => 'AuthController@login'],
			'api-create-event' => ['uses' => 'EventController@create'],
			'api-all-events' => ['uses' => 'EventController@all'],
			'api-register-for-event' => ['uses' => 'EventController@registerForEvent'],
		];

		return $this->routes;
	}

	public function getUriSegment($int=0)
	{
		if(isset(explode('/', trim($_SERVER['REQUEST_URI'], '/'))[$int]))
		{
			return explode('/', trim($_SERVER['REQUEST_URI'], '/'))[$int];
		}
		else return null;
	}


}