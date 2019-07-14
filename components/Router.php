<?php

class Router
{

	private $routes;

	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run()
	{
		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {

			if(preg_match("~$uriPattern~", $uri)) {

				// Получаем внутренний путь из внешнего согласно правилу.

				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				$segments = explode('/', $internalRoute);

				// имя контроллера обрабатывающего запрос
				$controllerName = array_shift($segments).'Controller'; 
				$controllerName = ucfirst($controllerName);
				
				// имя метода
				$actionName = 'action'.ucfirst(array_shift($segments));

				// список параметров
				$parameters = $segments;

				// подключение нужного класса 
				$controllerFile = ROOT . '/controllers/' .$controllerName. '.php';
				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}

				$controllerObject = new $controllerName;
				
				// Вызов метода $actionName в классе $controllerObject с параметрами $parameters
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				
				
				if ($result != null) {
					break;
				}
			}

		}
	}
}