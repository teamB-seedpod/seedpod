<?php
class Event extends AppModel{
	public $validate = array(
		'title' => array('rule' => 'notEmpty'),
		'open_datetime' => array('rule' => 'notEmpty'),
		'place' => array('rule' => 'notEmpty'),
		'detail' => array('rule' => 'notEmpty')
	);
}