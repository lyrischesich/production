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
			$receivers = $this->User->validateReceivers($this->request->data);
		}

	}

}
?>