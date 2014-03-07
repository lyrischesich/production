<?php

class PlanController extends AppController {
	
 	public $uses = array('Specialdate','User', 'Column', 'Plan');
	public $helpers = array('Js','Time');
	public $components = array('Paginator','Session');

	public function index($year=-1, $month=-1) {
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
	
	public function sendMissingShiftMails(){
		$firstDate = new DateTime('now');
		$firstDate = $firstDate->modify("+".(8-date('N', time()))." days");
		$tmpColumns = $this->Column->find('all', array('recursive' => -1));
		$columns = array();
		foreach ($tmpColumns as $tmpColumn) {
			$columns[$tmpColumn['Column']['id']] = $tmpColumn['Column']['req_admin'];
		}
		
		$data = array();
		
		//auf Deutsch umstellen
		setlocale (LC_TIME, 'de_DE@euro', 'de_DE', 'de', 'ge', 'de_DE.utf8');
		for ($i = 0;$i < 7;$i++) {
			$currentDate = $firstDate->format("Y-m-d");
			$missing = $this->Plan->getMissingShifts($currentDate);
	
			$data[$currentDate]["missing"] = ($missing === array()) ? null : $missing;
			$data[$currentDate]["dow"] = strftime('%A', strtotime($currentDate));
			$data[$currentDate]["weekend"] = date('N', strtotime($currentDate)) >= 6;
			$data[$currentDate]["specialdate"] = $this->Specialdate->find("count", array("conditions" => array("Specialdate.date" => $currentDate))) === 1;
			$firstDate->modify("+1 day");
		}
		
		$users = $this->User->find("all", array("recursive" => -1, "conditions" => array("User.mail != " => "", "User.leave_date" => null)));
		
		$workableUsers = array();

		foreach ($data as $date => $info) {
			//Tage, an denen nicht gearbeitet wird, werden ignoriert
			if (($info['weekend'] && !$info['specialdate']) || (!$info['weekend'] && $info['specialdate'])) {
				continue;
			}
			
			//Es handelt sich um ein Datum, an dem gearbeitet wird
			if (!isset($info['missing'])) {
				//Alle Dienste sind bereits belegt -> ignorieren
				continue;
			}
			
			//Es handelt sich um ein Datum, an dem noch Schichten fehlen
			foreach ($info['missing'] as $columnId => $shifts) {
				//Handelt es sich um eine Benutzerspalte/Textspalte?
				if ($shifts != null) {
					$missingShiftNumeric = 0;
					if (array_key_exists(1, $shifts))
						$missingShiftNumeric += 1;
					
					if (array_key_exists(2, $shifts))
						$missingShiftNumeric += 2;
				} else {
					//Textspalte
					$missingShiftNumeric = -1;
				}
							
				foreach ($users as $user) {
					//Falls Adminrechte benötigt werden, muss der Nutzer diese auch besitzen, sonst weiter
					if ($columns[$columnId] == 1 && !$user['User']['admin']) {
						continue;
					}
					
					if ($missingShiftNumeric == -1) {
						$workableUsers[$user['User']['id']][$date][$columnId] = -1;
					} else if ($info['weekend']) {
						//Zu Wochenenden wurden keine Arbeitszeiten gespeichert
						//-> Alle Mitarbeiter werden gewählt
						$workableUsers[$user['User']['id']][$date][$columnId] = $missingShiftNumeric;
					} else if ($missingShiftNumeric == 3) {
						if ($user['User'][substr(strtolower($info['dow']), 0, 2)] != "N") {
							$workableUsers[$user['User']['id']][$date][$columnId] = 3;							
						}
					} else if ($missingShiftNumeric == 2) {
						if (in_array($user['User'][substr(strtolower($info['dow']), 0, 2)], array("2", "H", "G"))) {
							$workableUsers[$user['User']['id']][$date][$columnId] = 2;
						}
					} else if ($missingShiftNumeric == 1) {
						if (in_array($user['User'][substr(strtolower($info['dow']), 0, 2)], array("1", "H", "G"))) {
							$workableUsers[$user['User']['id']][$date][$columnId] = 1;
						}
					}
				}
			}
		}
		
		$usersArray = array();
		foreach ($users as $user) {
			$usersArray[$user['User']['id']] = $user['User'];
		}
		
		$halfshifts = array (
			-1 => '',
			1 => '1. Schicht ',
			2 => '2. Schicht ',
			3 => 'Ganzer Dienst '
		);
		foreach ($tmpColumns as $tmpColumn) {
			$columnsArray[$tmpColumn['Column']['id']] = $tmpColumn['Column']['name'];
		}
		

		$senderMail = 'humboldt-cafeteria@versanet.de';
		$senderName = 'Humboldt Cafeteria';
		
		foreach ($workableUsers as $userid => $dates) {			
			$mailContent = "Hallo ".$usersArray[$userid]['fname']." ".$usersArray[$userid]['lname'].",<br />";
			$mailContent .= "leider sind zur Zeit noch nicht alle Dienste für die nächste Woche in der Humboldt-Cafeteria belegt.<br /><br />Es fehlen:<br />";
			foreach ($dates as $date => $columns) {
				$mailContent .= "<br />";
				$mailContent .= $data[$date]["dow"].", ".date('d. m. Y', strtotime($date));
				$mailContent .= "<ul>";
				foreach ($columns as $columnid => $halfshift) {
					$mailContent .= "<li>";
					$mailContent .= $halfshifts[$halfshift].$columnsArray[$columnid];
					$mailContent .= "</li>";
					
				}
				$mailContent .= "</ul>";
			}
				
			$EMail = new CakeEmail();
			$EMail->from(array($senderMail => $senderName));
			$EMail->to($usersArray[$userid]['mail']);
			$EMail->subject("Humboldt-Cafeteria - nächste Woche unvollständig");
			$EMail->config('web');
			$EMail->template('default');
			$EMail->emailFormat('html');
			$EMail->viewVars(array(
					'senderName' => $senderName,
					'senderMail' => $senderMail,
					'content' => $mailContent,
					'subject' => "Humboldt-Cafeteria - nächste Woche unvollständig"
			));

			$EMail->send();
		}
		
		return $this->redirect(array("controller" => "columns", "action" => "index"));
	}

	public function isAuthorized($user) {
		if ($this->action == "sendMissingShiftMails") {
			//Diese Methode ist zuständig für das Generieren und Versenden der Mails
			//bezüglich fehlender Dienste im Plan und wird zu gegebener Zeit automatisch aufgerufen
			//->Niemand darf diese Funkion über die URL aufrufen
			return true;
		}
		
		//Alle angemeldeten Benutzer dürfen den Plan einsehen
		return true;
	}
}
?>
