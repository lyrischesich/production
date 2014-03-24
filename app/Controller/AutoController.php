<?php
App::uses('AppController', 'Controller');
class AutoController extends AppController {
	
	public function index($controller=-1, $action=-1, $description=-1) {
		if ($controller != -1 && $action != -1 && $description != -1) {
			$this->doTask($controller, $action, $description);			
			//return $this->redirect(array('controller' => 'auto', 'action' => 'index'));
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
			$tmpArray['success'] = str_replace("\n", "", str_replace("\r\n", "", $contents[0]));
			$tmpArray['controller'] = str_replace("\n", "", str_replace("\r\n", "", $contents[1]));
			$tmpArray['action'] = str_replace("\n", "", str_replace("\r\n", "", $contents[2]));
			$tmpArray['lastExecution'] = filemtime($path);

			array_push($viewData, $tmpArray);
		}

		$this->set('performedActions', $viewData);
	}
	
	private function doTask($controllerName, $actionName, $description) {
		$cfgDebug = Configure::read('debug');
		if (App::import('Controller', str_replace('Controller', '', $controllerName))) {
			$controller = new $controllerName();
			if (method_exists($controller, $actionName)) {
				define('ROOT_PERMISSION', true);
				Configure::write('debug', 0);
				if (call_user_func(array($controller, $actionName))) {
					//alles hat funktioniert
					//muss von der aufgerufenen Methode selbst geloggt werden
				} else {
					//ein programminterner Fehler ist aufgetreten
					//muss von der aufgerufenen Methode selbst geloggt werden
				}
			} else {
				//der angegebene Controller besitzt die angegebene Methode nicht
				AutoController::saveLog($description, 2, $controllerName, $actionName);
			}
		} else {
			//der angegebene Controller wurde nicht gefunden
			AutoController::saveLog($description, 1, $controllerName, $actionName);
		}
		
		Configure::write('debug', $cfgDebug);
	}
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public static function saveLog($actionname, $errorcode, $controller, $action) {
		
		$file = fopen(APP."lastruns".DS.$actionname, "w");
		
		fwrite($file, $errorcode."\r\n");
		fwrite($file, $controller."\r\n");
		fwrite($file, $action."\r\n");
		
		fclose($file);
	}
}
?>
