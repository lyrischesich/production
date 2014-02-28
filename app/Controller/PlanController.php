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

		$results = $this->Plan->getPlanData($month, $year);

		$specialdates = $this->Specialdate->find('all', array('recursive' => -1, 'conditions' => array('Specialdate.date LIKE ' => $year.'-'.$month.'-__')));


		foreach ($specialdates as $specialdate) {
			$results[$specialdate['Specialdate']['date']]['specialdate'] = null;
		}

		//TODO verallgemeinern
		setlocale (LC_TIME, 'de_DE');
		foreach (array_keys($results) as $dates) {
			$datetime = new Datetime($dates);
			$results[$dates]['dow'] = $datetime->format('D');
		}

		$this->set('results', $results);
		//Spalten übergeben
		$columns = $this->Column->find('all', array('recursive' => -1, 'order' => array('Column.order' => 'ASC')));
		$this->set('columns', $columns);
	}
	


	public function isAuthorized($user) {
		//Alle angemeldeten Benutzer dürfen den Plan einsehen
		return true;
	}
}
?>
