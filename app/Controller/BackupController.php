<?php
App::uses('DatabaseManager', 'Model');

class BackupController extends AppController {
	
	public $uses = false;
	public $components = array('Session');
	
	public function index() {
		$maxUploadSize = ini_get('upload_max_filesize');
		$maxUploadSizeString = $this->getMaxUploadSizeDisplayFormat($maxUploadSize);
		$this->set('maxUploadSizeString', $maxUploadSizeString);
		$maxUploadSizeBytes = $this->return_bytes($maxUploadSize);
		$this->set('maxUploadSizeBytes', $maxUploadSizeBytes);
		
		if ($this->request->is('post')) {
			//Wurde wirklich eine Datei hochgeladen?
			if (!isset($this->request->data['User']['File']['tmp_name']) || !is_uploaded_file($this->request->data['User']['File']['tmp_name'])) {
				$this->Session->setFlash('Fehler beim Hochladen der Datei.<br/>Möglicherweise wurde die maximal erlaubte Dateigröße von '.$maxUploadSizeString.' überschritten.', 'alert-box', array('class' => 'alert-error'));
				return $this->redirect(array('action' => 'index'));
			}
				
			//Ist die hochgeladene Datei zu groß?
			if ($this->request->data['User']['File']['size'] > $maxUploadSizeBytes) {
				$this->Session->setFlash('Die Datei ist zu groß.', 'alert-box', array('class' => 'alert-error'));
				return $this->redirect(array('action' => 'index'));
			}
				
			$result = DatabaseManager::import($this->request->data['User']['File']['tmp_name']);
			if ($result === true) {
				//Import erfolgreich
				$this->Session->setFlash('Wiederherstellung erfolgreich abgeschlossen.', 'alert-box', array('class' => 'alert-success'));
				return $this->redirect($this->Auth->logout());
			} else {
				$this->Session->setFlash($result, 'alert-box', array('class' => 'alert-error'));
			}
		}
	}
	
	public function export() {
		//Das ganze "Drumherum" abschalten, damit nur der SQL-Dump in die Datei geschrieben wird
		$this->layout = null;
		$dump = DatabaseManager::export();
		$this->set('dump', $dump);
	}
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
	
	//Folgender Code stammt direkt von http://www.php.net/manual/en/function.ini-get.php
	//und kann hier exakt so verwendet werden
	private function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
	
		return $val;
	}
	
	
	private function getMaxUploadSizeDisplayFormat($origValue) {
		$val = trim($origValue);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			case 'g':
			case 'm':
			case 'k':
				$val .= "iB";
		}
		return $val;
	}
}

?>