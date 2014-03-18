<?php
App::uses('AppController', 'Controller');

class AutoController extends AppController {
	
	public function index($controller=-1, $action=-1) {
		if ($controller != -1 && $action != -1) {
			$this->doTask($controller, $action);
			
			return $this->redirect(array('controller' => 'auto', 'action' => 'index'));
		}
		
		$handle = opendir (APP.DS."lastruns");

		$filelist = array();
		while ($file = readdir ($handle)) {
			if ($file != "." && $file != "..")
				$filelist[$file] = APP."lastruns".DS.$file;
		}

		closedir($handle);

		$viewData = array();
		$tmpArray = array();		
		foreach ($filelist as $filename => $path) {
			$contents = file($path);
			$tmpArray['actionname'] = str_replace("_", " ", $filename);
			$tmpArray['success'] = str_replace("\n", "", $contents[0]);
			$tmpArray['controller'] = str_replace("\n", "", $contents[1]);
			$tmpArray['action'] = str_replace("\n", "", $contents[2]);
			$tmpArray['lastExecution'] = filemtime($path);

			array_push($viewData, $tmpArray);
		}

		$this->set('performedActions', $viewData);
	}
	
	private function doTask($controllerName, $actionName) {
		$cfgDebug = Configure::read('debug');
		if (App::import('Controller', str_replace('Controller', '', $controllerName))) {
			$controller = new $controllerName();
			if (method_exists($controller, $actionName)) {
				define('ROOT_PERMISSION', true);
				Configure::write('debug', 0);
				if (call_user_func(array($controller, $actionName))) {
					$errorcode = 0;
				} else {
					//ein programminterner Fehler ist aufgetreten
					$errorcode = 3;
				}
			} else {
				//der angegebene Controller besitzt die angegebene Methode nicht
				$errorcode = 2;
			}
		} else {
			//der angegebene Controller wurde nicht gefunden
			$errorcode = 1;
		}
		
		Configure::write('debug', $cfgDebug);
		return $errorcode;
	}
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}
?>