<?php

class Information extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			),
		'detail' => array(
			'rule' => 'notEmpty'
			)
	);
}