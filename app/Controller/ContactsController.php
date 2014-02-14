<?php
class ContactsController extends AppController {
	public $uses = array('User');
	public $helpers = array('Js');
	public $components = array('Paginator','Session');

	public $paginate = array(
			'fields' => array('User.lname','User.fname','User.tel1','User.tel2','User.mail','User.mo','User.di','User.mi','User.do','User.fr','User.leave_date'),
			'limit' => 25,
			'order' => array(
					'User.lname' => 'asc'
			),
	);

	public function index() {
		$this->Paginator->settings = $this->paginate;
			
		$results = $this->Paginator->paginate();
		foreach ($results as &$result) {
			//Hier wird die CSS-Klasse f�r die jeweiligen Tage in das Array eingebunden
			$result['User']['mo'] = $this->addStyle($result['User']['mo']);
			$result['User']['di'] = $this->addStyle($result['User']['di']);
			$result['User']['mi'] = $this->addStyle($result['User']['mi']);
			$result['User']['do'] = $this->addStyle($result['User']['do']);
			$result['User']['fr'] = $this->addStyle($result['User']['fr']);
		}
		$this->set('users',$results);
	}

	/**
	 * Die Zellen der Tabelle in den Spalte [mo,di,mi,do,fr] sollen verschiedenfarbig unterlegt sein,
	 * je nachdem wie die betreffende Person am entsprechenden Wochentag Zeit hat. Diese Methode erwartet
	 * ein Ergebnis aus der Datenbank und gibt ein array zur�ck, welches neben dem Ergebnis auch eine CSS-Klasse enth�lt,
	 * die in die View eingebettet werden kann.
	 * @param Ergebnis aus der Datebank, welches einem Wert des enums entspricht $day
	 */
	private function addStyle($dayValue = null) {
		if (strcmp($dayValue,"G") == 0) {
			return array('value' => $dayValue,'class' => 'success');
		} elseif (strcmp($dayValue,"H") == 0 || strcmp($dayValue,"1") == 0 || strcmp($dayValue,"2") == 0) {
			return array('value' => $dayValue,'class' => 'warning');
		} elseif (strcmp($dayValue,"N") ==0) {
			return array('value' => $dayValue,'class' => 'error');
		}
	}
	
	/**
	 * Erwartet ein GET-Parameter und setzt den Wert des Adressfeldes entsprechend, für den eigentlichen
	 * E-Mail Versand ist eine andere Methode zuständig.
	 * @param String $to = Der Empfänger, der im Adressfeld angezeigt werden soll
	 */
	public function mail($data = null) {
		if ($this->request->is('get')) {
			$this->set('receiver',$data);
		}
		if ($this->request->is('post')) {
			$this->set('receiver',$this->request->data['Mail']['mailTo']);
			$receivers = $this->User->validateReceivers($this->request->data);
			
			//Prüfe ob alle E-Mail-Adresse valide sind:
			$invalidData = array();
			$validReceivers = array();
			foreach ($receivers as $receiver) {
				if (!$receiver['valid']) array_push($invalidData, $receiver['input']);
					else array_push($validReceivers, $receiver['mail']);
			}
			
			//Wenn alle EMail-Adressen gültig sind -> Fahre fort
			if ($invalidData == array()) {
				//Alle Empfänger sind gültig. Jetzt wird die E-Mail generiert
				$sender = $this->User->findById($this->Auth->user('id'));
				$senderName = $sender['User']['username'];
				$senderMail = $sender['User']['mail'];
				
				$EMail = new CakeEmail();
				$EMail->from(array($senderMail => 'Humboldt Cafeteria ['.$senderName.']'));
				$EMail->to($validReceivers);
				$EMail->subject($this->request->data['Mail']['subject']);
				$EMail->config('web');
				$EMail->template('default');
				$EMail->emailFormat('html');
				$EMail->viewVars(array(
						'senderName' => $senderName,
						'senderMail' => $senderMail,
						'content' => $this->request->data['Mail']['content'],
						'subject' => $this->request->data['Mail']['subject']
						));
				if ($EMail->send()) {
					$this->Session->setFlash('Die Email wurde erfolgreich abgeschickt','alert-box',array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('Es ist ein Fehler aufgetreten','alert-box',array('class' => 'alert-error'));
				}
				
			} else {
				//Gebe in einer Fehlermeldung aus, welche Adressen/Benutzernamen fehlerhaft sind
				$invalidData = implode(',', $invalidData);
				$string =  "Die Nachricht konnte nicht gesendet werden, da folgende Empfänger keine Mitarbeiter der Cafeteria sind:" . $invalidData;
				$this->Session->setFlash($string, 'alert-box',array('class' => 'alert alert-block alert-error'));
			}
		}

	}

}
?>