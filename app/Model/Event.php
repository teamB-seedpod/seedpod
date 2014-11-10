<?php
class Event extends AppModel{
	public $name = 'Event';		//エイリアス的なもの

	public $validate = array(
		'title' => array('rule' => 'notEmpty'),
		'open_datetime' => array('rule' => 'notEmpty'),
		'place' => array('rule' => 'notEmpty'),
		'detail' => array('rule' => 'notEmpty'),
		'user_id' => array('rule' => 'notEmpty')		
	);

	//events(多数)にusers(1つ)をbelongstoでアソシエーションする
	public $belongsTo = array(
    	'User' => array(	//このUserは配列の引数になる
    	'className'  => 'User',
    	'foreignKey' => 'user_id',
    	)
    );

	//events(1つ)にparticipants(多数)をhasmanyでアソシエーションする
	public $hasMany = array(
		'Participant' => array(
		'className'  => 'Participant',
		'foreignKey' => 'event_id',
		)
	);
}