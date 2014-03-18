<?php
App::uses('AppController', 'Controller');

class AutoController extends AppController {
	
	public function index() {
		$handle = opendir (APP.DS."lastruns");

		$filelist = array();
		while ($file = readdir ($handle)) {
			if ($file != "." && $file != "..")
				$filelist[$file] = APP."lastruns".DS.$file;
		}

		debug($filelist);
		closedir($handle);

		$viewData = array();
		$tmpArray = array();		
		foreach ($filelist as $filename => $path) {
			$contents = file($path);
			$tmpArray['actionname'] = $filename;
			$tmpArray['success'] = $contents[0];
			$tmpArray['controller'] = $contents[1];
			$tmpArray['action'] = $contents[2];
			$tmpArray['lastExecution'] = filemtime($path);

			array_push($viewData, $tmpArray);
		}

		$this->set('performedActions', $viewData);
	}
}
?>
