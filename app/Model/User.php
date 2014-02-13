<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Column $Column
 */
class User extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(//*
		'username' => array( //---------------------ab hier einfügt
				'notEmpty' => array(
						'rule' => array('notEmpty'),
						//'message' => 'Your custom message here',
						//'allowEmpty' => false,
						//'required' => false,
						//'last' => false, // Stop validation after this rule
						//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
		),//-----------------------------------Ende eingefügt*/
		'fname' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lname' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tel1' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tel2' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mail' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Bitte geben sie eine gültige E-Mailadresse an.'
			)
		),
		'mo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'di' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mi' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'do' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fr' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'admin' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password2' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'equalToField' => array(
				'rule' => array('equalToField', 'password'),
				'message' => 'Die Passw&ouml;rter stimmen nicht &uuml;berein.'
			)
		),
	);
	
	function equalToField($array, $field) { 
		return strcmp($this->data[$this->alias][key($array)], 
					$this->data[$this->alias][$field]) == 0; 
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Column' => array(
			'className' => 'Column',
			'joinTable' => 'columns_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'column_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	
	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}
	
	/**
	 * Die E-Mail Funktion der Telefonliste soll mehre Empfänger entgegennehmen können. Diese werden entweder mit 
	 * ihrem Benuternamen, oder ihrer E-Mail Adresse angegeben. Diese Funktionen zerlegt den ankommenden String
	 * in die einzelnen Empfänger uind validiert die E-Mail-Adressen. Zurückgegeben wird ein Array, welches zu jedem Empfänger
	 * jeweils den eingegeben String, die E-Mail-Adresse aus der Datenbank und ein Feld mit dem Namen valid, welches angibt, ob
	 * der Empfänger auch das tatsächlich in der Datenbank vorhanden ist, enthält.
	 *
	 * @param Array $receivers Erwartet ein Array von E-Mail Adressen oder Vor- und Nachnamenkombinationen
	 * @return Ein Array mit ausschließlich gültigen E-Mail Adressen von Mitarbeitern der Cafeteria
	 */
	public function validateReceivers($receivers = null) {
		$receivers = explode(";",$receivers['Mail']['mailTo']);
		$returnResult = array();		
		foreach($receivers as $receiver) {
			$result = $this->findByMailOrUsername($receiver,$receiver);
			if ($result == array()) {
				array_push($returnResult,array('valid' => false,'input' => $receiver));
			} else {
				array_push($returnResult, array('valid' => true,'input' => $receiver, 'mail' => $result['User']['mail']));
			}
		}
		return $returnResult;
	}
}
