<?php

class PlanController extends AppController {
	
 	public $uses = array('Specialdate','User', 'Column', 'Plan');
	public $helpers = array('Js','Time');
	public $components = array('Paginator','Session');

	public function index($month=-1, $year=-1) {
		if (!is_numeric($month) || !is_numeric($year) || strlen($month) != 2 || strlen($year) != 4) {
			//Falsches Format => wie keine Daten
			$month = -1;
			$year = -1;
		}
		
		if ($month < 1 || $month > 12 || $year < 2000) {
			//Sachlich falsche Daten => wie keine Daten
			$month = -1;
			$year = -1;
		}
		
		if ($month == -1 || $year == -1) {
			//Kein Datum vorgegeben -> aktueller Monat
			$month = date('m', time());
			$year = date('Y', time());
		}

		//Spalten übergeben
		$columns = $this->Column->find('all', array('recursive' => -1, 'order' => array('Column.order' => 'ASC')));
		$this->set('columns', $columns);
		
		$results = $this->Plan->getPlanData($month, $year);

		$specialdates = $this->Specialdate->find('all', array('recursive' => -1, 'conditions' => array('Specialdate.date LIKE ' => $year.'-'.$month.'-__')));


		foreach ($specialdates as $specialdate) {
			$results[$specialdate['Specialdate']['date']]['specialdate'] = null;
		}

		//auf Deutsch umstellen		
		setlocale (LC_TIME, 'de_DE@euro', 'de_DE', 'de', 'ge', 'de_DE.utf8');
		
		$users = $this->User->find('all', array('recursive' => -1));
		$userslist = array();
		foreach ($users as $user) {
			$userslist[$user['User']['id']] = $user['User']['username'];
		}
		
		//Benutzerspalten ermitteln
		$userColumns = array();
		foreach ($columns as $column) {
			if ($column['Column']['type'] == 2)
				array_push($userColumns, $column['Column']['id']);
		}
		
		//Wochentag(dow=DayOfWeek) und Wochenende angeben
		foreach (array_keys($results) as $date) {
			$results[$date]['dow'] = strftime('%a', strtotime($date));
			$results[$date]['weekend'] = date('N', strtotime($date)) >= 6;
			
			foreach ($userColumns as $userColumn) {
				if (isset($results[$date][$userColumn][1]['userid']))
					$results[$date][$userColumn][1]['username'] = $userslist[$results[$date][$userColumn][1]['userid']];
				
				if (isset($results[$date][$userColumn][2]['userid']))
					$results[$date][$userColumn][2]['username'] = $userslist[$results[$date][$userColumn][2]['userid']];
			}
		}

		$this->set('results', $results);
		
	}
	


	public function isAuthorized($user) {
		//Alle angemeldeten Benutzer dürfen den Plan einsehen
		return true;
	}
}
?>
