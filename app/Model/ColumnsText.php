<?php
App::uses('AppModel', 'Model');
/**
 * ColumnsText Model
 *
 */
class ColumnsText extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'columns_text';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'date';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'message' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'column_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
