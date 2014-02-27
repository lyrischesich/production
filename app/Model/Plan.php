<?php

App::uses('AppModel', 'Model');
App::uses('Specialdate', 'Model');
App::uses('ColumnsUser', 'Model');
// App::uses('Comment', 'Model');

class Plan extends AppModel {
	
	public $useTable = false; 
	
	public function getPlanData($month=-1, $year=-1) {		
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
		
		$conditionArray = array('date LIKE ' => $year.'-'.$month.'-%');	
		
		$specialdates = new Specialdate();
		$specialdates = $specialdates->find('all', array('recursive'=>-1, 'conditions' => $conditionArray));
		 		
		
// 		$comments = new Comment();
// 		$comments = $comments->find('all', array('recursive'=>-1, 'conditions' => $conditionString));
		
		$plan = array();
		$daysInMonth = date('t', strtotime($year.'-'.$month.'-01'));
		$datetime = new DateTime($year.'-'.$month.'-01');
		
		for ($i = 1;$i <= $daysInMonth;$i++) {
			$currentDate = $datetime->format('Y-m-d');
			$data = array();
			
			$columnsUsers = new ColumnsUser();
			$columnsUsers = $columnsUsers->find('all', array('recursive'=>-1, 'conditions' => array('date' => $currentDate)));
			
			foreach ($columnsUsers as $columnUser) {
				//Bug/Formatfehler: Bei zweigeteilten Diensten wird der zweite überschrieben
				$data[$columnUser['ColumnsUser']['column_id']] = $columnUser;
			}
			
			
			$plan[$currentDate] = $data;
			$datetime->modify('+1 day');
		}
		
		return $plan;
	}
}
?>