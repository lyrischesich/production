<?php
class StatisticController extends AppController {
	public $uses = array('User', 'ColumnsUser');

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
			//Kein Datum vorgegeben -> aktueller Monat
			$month = date('m', time());
			$year = date('Y', time());
			$this->set('pageTitle', "Statistik für den ".$month.". ".$year);
		}

		if ($year != -1 && $month == -1) {
			//Jahresstatistik
			$month = '__';
			$this->set('pageTitle', "Statistik für ".$year);
		}

		$date = $year."-".$month."-__";
		
		$data = $this->ColumnsUser->find("all", array('recursive' => -1, 'conditions' => array('ColumnsUser.date LIKE ' => $date)));
		
		$this->analyseAndSetData($data);
	}

	public function last($month=1) {
		if (!is_numeric($month)) {
			//Falsches Format => wie keine Daten
			$month = 1;
		}

		if ($month < 1) {
			//Sachlich falsche Daten => wie keine Daten
			$month = 1;
		}

		$dateEnd = date('Y-m-d');
		$dateBegin = new DateTime($dateEnd);
		$dateBegin->modify("-".$month." months");
		$dateBegin = $dateBegin->format('Y-m-d');

		$data = $this->ColumnsUser->find('all', array('recursive' => -1, 'conditions' => array('ColumnsUser.date <= ' => $dateEnd, 'ColumnsUser.date >=' => $dateBegin)));

		if ($month == 1)
			$this->set('pageTitle', 'Statistik für den letzten Monat');
		else
			$this->set('pageTitle', 'Statistik für die letzten '.$month.' Monate');

		$this->analyseAndSetData($data);
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
		}

		foreach ($dataArray as $data) {
			if (!array_key_exists($data['ColumnsUser']['user_id'], $userList)) {
				$username = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $data['ColumnsUser']['user_id'])));
				$userList[$data['ColumnsUser']['user_id']] = array('username' => $username['User']['username']);
				$userList[$data['ColumnsUser']['user_id']]['H']  = 0;
				$userList[$data['ColumnsUser']['user_id']]['G']  = 0;
				$userList[$data['ColumnsUser']['user_id']]['ges']  = 0;
			}

			$halfshift = $data['ColumnsUser']['half_shift'];
			if ($halfshift <= 2)
				$halfshift = 'H';
			else
				$halfshift = 'G';

			$userList[$data['ColumnsUser']['user_id']][$halfshift]++;
			//so?
			$userList[$data['ColumnsUser']['user_id']]['ges'] +=  ($halfshift == 'G') ? 1 : 0.5;
		}

		$this->set('data', $userList);
	}
}
