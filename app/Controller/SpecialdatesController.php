<?php
App::uses('AppController', 'Controller');
App::uses('AutoController', 'Controller');
App::uses('ICal', 'Model');
/**
 * Specialdates Controller
 *
 * @property Specialdate $Specialdate
 * @property PaginatorComponent $Paginator
 */
class SpecialdatesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Specialdate->recursive = 0;
		$this->set('specialdates', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Specialdate->exists($id)) {
			throw new NotFoundException(__('Invalid specialdate'));
		}
		$options = array('conditions' => array('Specialdate.' . $this->Specialdate->primaryKey => $id));
		$this->set('specialdate', $this->Specialdate->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Specialdate->create();
			if ($this->Specialdate->save($this->request->data)) {
				$this->Session->setFlash(__('The specialdate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialdate could not be saved. Please, try again.'));
			}
		}
	}

	public function importVacations() {
	  try {
		$importyear = date('Y')+1;
		$sourceURL = 'http://www.schulferien.org/iCal/Ferijen/icals/Ferien_Berlin_'.$importyear.'.ics';
		if (!file_get_contents($sourceURL))
			throw new Exception();
			
		$icalreader = new ICal($sourceURL);
			
		
		$events = $icalreader->events();

		$tmpSpecialdates = $this->Specialdate->find('all', array('recursive' => -1, 'conditions' => array('date LIKE ' => $importyear.'-__-__')));
		$specialdates = array();
		foreach ($tmpSpecialdates as $tmpSpecialdate) {
			array_push($specialdates, $tmpSpecialdate['Specialdate']['date']);
		}
		
		foreach ($events as $event) {
			$timeBegin = $this->icalToUnixtime($event['DTSTART']);
			$timeEnd = $this->icalToUnixtime($event['DTEND']);
			
			$datetime = new Datetime(date('Y-m-d', $timeBegin));
			for ($i = $timeBegin;$i <= $timeEnd;$i+=DAY) {
				
				$dateString = $datetime->format('Y-m-d');
				if (!in_array($dateString, $specialdates)) {
					//Datum existiert noch nicht
					if (!($datetime->format('N') >= 6)) {
						//Kein Wochenende -> Specialdate eintragen, um das Datum zu deaktivieren
						$this->Specialdate->create();
						$this->Specialdate->save(array('Specialdate' => array('date' => $dateString)));
					}
				} else {
					//Datum existiert bereits
				}
				
				$datetime->modify("+1 day");
			}
		}
		AutoController::saveLog('Ferienimport', 0, 'SpecialdatesController', 'importVacations');
	  } catch (Exception $e) {
	  	AutoController::saveLog('Ferienimport', 3, 'SpecialdatesController', 'importVacations');
	  }
	}
	
	private function icalToUnixtime($ical) {
		$year = substr($ical, 0, 4);
		$month = substr($ical, 4, 2);
		$day = substr($ical, 6, 2);
		return strtotime($year."-".$month."-".$day);
	}
	
	public function isAuthorized($user) {
		if ($this->action == "importVacations") {
			//Diese Methode ist zuständig für das Beschaffen und einfügen der Ferientermine
			//des nächsten Jahres zuständig
			//->Niemand darf diese Funkion über die URL aufrufen
			//Stattdessen muss ROOT_PERMISSION definiert und true sein
			return defined("ROOT_PERMISSION") && ROOT_PERMISSION === true;
		}
		
		return parent::isAuthorized($user);
	}
}