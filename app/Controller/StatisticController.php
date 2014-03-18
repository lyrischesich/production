<?php
class StatisticController extends AppController {
	public $uses = array('User', 'ColumnsUser');
	public $helpers = array('Form');

	public function index($year=-1, $month=-1) {
		if (!is_numeric($month) || !is_numeric($year) || strlen($month) != 2 || strlen($year) != 4) {
			//Falsches Format => wie keine Daten
			$month = -1;
			$year = -1;
		}
		
		if (($month != -1 && $month < 1) || $month > 12 || $year < 2000) {
			//Sachlich falsche Daten => wie keine Daten
			$month = -1;
			$year = -1;
		}
		
		if ($month == -1 && $year == -1) {
			//Kein Datum vorgegeben -> aktueller Monat, da dieser bereits abgeschlossen ist
			$tmpDatetime = new DateTime('now');
			$tmpDatetime->modify("-1 month");
			$month = $tmpDatetime->format('m');
			$year = $tmpDatetime->format('Y');
		}

		if ($year != -1 && $month == -1) {
			//Jahresstatistik
			//(Zur Zeit noch nicht verwendet)
			$month = '__';
			$this->set('pageTitle', "Statistik für ".$year);
			$this->set('nextYear', $year);
			$this->set('nextMonth', "01");
			$this->set('previousYear', $year-1);
			$this->set('previousMonth', "12");
		} else 	if ($year != -1 && $month != -1) {
			$this->set('pageTitle', "Statistik für ".$month."/".$year);
			
			$datetime = new DateTime($year."-".$month."-15");
			$datetime->modify("+1 month");
			$this->set('nextYear', $datetime->format('Y'));
			$this->set('nextMonth', $datetime->format('m'));
			$datetime->modify("-2 months");
			$this->set('previousYear', $datetime->format('Y'));
			$this->set('previousMonth', $datetime->format('m'));
		}

		$date = $year."-".$month."-__";
		
		$data = $this->ColumnsUser->find("all", array('recursive' => -1, 'conditions' => array('ColumnsUser.date LIKE ' => $date)));
		
		$this->analyseAndSetData($data);
		$this->set('param1', $year);
		$this->set('param2', $month);
	}

	public function interval($from=-1, $to=-1) {
		//Direkt übergebene Werte haben Vorrang vor POST-Parametern
		if ($from != -1) $this->request->data['Date']['dateFrom'] = $from;
		if ($to != -1) $this->request->data['Date']['dateTo'] = $to;
		
		//Inputvalidierung
		if (!isset($this->request->data['Date']['dateFrom']) || !isset($this->request->data['Date']['dateTo'])) {
			return $this->redirect(array('controller' => 'statistic', 'action' => 'index'));
		}
			
		$this->request->data['Date']['dateFrom'] = str_replace(" ", "", $this->request->data['Date']['dateFrom']);
		$this->request->data['Date']['dateTo'] = str_replace(" ", "", $this->request->data['Date']['dateTo']);
		
		$token = explode(".", $this->request->data['Date']['dateFrom']);
		if (count($token) != 3 || !checkdate($token[1], $token[0], $token[2])) {
			//Ungültiges Datum
			//-> nur aktuellen Monat anzeigen
			return $this->redirect(array('action' => 'index'));
		} else {
			$dateBegin = $token[2]."-".$token[1]."-".$token[0];
		}

		$token = explode(".", $this->request->data['Date']['dateTo']);
		if (count($token) != 3 || !checkdate($token[1], $token[0], $token[2])) {
			//Ungültiges Datum
			//-> nur aktuellen Monat anzeigen
			return $this->redirect(array('action' => 'index'));
		} else {
			$dateEnd = $token[2]."-".$token[1]."-".$token[0];
		}
		
		
		if (strtotime($dateBegin) > strtotime($dateEnd)) {
			//Variablen tauschen
			$tmp = $dateBegin;
			$dateBegin = $dateEnd;
			$dateEnd = $tmp;
		}
		
		$datetime = new DateTime(date('Y-m-d'));
		$datetime->modify("+1 month");
		$this->set('nextYear', $datetime->format('Y'));
		$this->set('nextMonth', $datetime->format('m'));
		$datetime->modify("-2 months");
		$this->set('previousYear', $datetime->format('Y'));
		$this->set('previousMonth', $datetime->format('m'));

		$data = $this->ColumnsUser->find('all', array('recursive' => -1, 'conditions' => array('ColumnsUser.date <= ' => $dateEnd, 'ColumnsUser.date >=' => $dateBegin)));

		$this->set('pageTitle', "Statistik für den Zeitraum vom ".date('d. m. Y', strtotime($dateBegin))." bis zum ".date('d. m. Y', strtotime($dateEnd)));
		$this->analyseAndSetData($data);
		
		$this->set('param1', date('d.m.Y', strtotime($dateBegin)));
		$this->set('param2', date('d.m.Y', strtotime($dateEnd)));
	}

	private function analyseAndSetData($dataArray) {

		$userList = array();
		$users = $this->User->find('all', array('recursive' => -1, 'conditions' => array('User.leave_date' => null)));
		//Alle aktiven Benutzer müssen in der Statistik drinstehen
		foreach ($users as $user) {
			$userList[$user['User']['id']] = array('username' => $user['User']['username']);
			$userList[$user['User']['id']]['H']  = 0;
			$userList[$user['User']['id']]['G']  = 0;
			$userList[$user['User']['id']]['ges']  = 0;
			$userList[$user['User']['id']]['active'] = true;
		}

		foreach ($dataArray as $data) {
			if (!array_key_exists($data['ColumnsUser']['user_id'], $userList)) {
				$userdata = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $data['ColumnsUser']['user_id'])));
				$userList[$data['ColumnsUser']['user_id']] = array('username' => $userdata['User']['username']);
				$userList[$data['ColumnsUser']['user_id']]['H']  = 0;
				$userList[$data['ColumnsUser']['user_id']]['G']  = 0;
				$userList[$data['ColumnsUser']['user_id']]['ges']  = 0;
				$userList[$data['ColumnsUser']['user_id']]['active']  = $userdata['User']['leave_date'] == null;
			}

			$halfshift = $data['ColumnsUser']['half_shift'];
			if ($halfshift <= 2)
				$halfshift = 'H';
			else
				$halfshift = 'G';

			$userList[$data['ColumnsUser']['user_id']][$halfshift]++;
			$userList[$data['ColumnsUser']['user_id']]['ges'] +=  ($halfshift == 'G') ? 1 : 0.5;
		}

		$this->set('data', $userList);
	}
	
	public function printversion($action=-1, $param1=-1, $param2=-1) {
		$this->layout = "print";
		
		if ($action == "index") {
			$this->index($param1, $param2);
		} else if ($action == "interval") {
			$this->interval(date('d.m.Y', strtotime($param1)), $param2);
		} else {
			return $this->redirect(array('controller' => 'statistic', 'action' => 'index'));
		}
	}
}
