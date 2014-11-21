<?php
class Event extends AppModel{
	public $name = 'Event';		//エイリアス的なもの

	public $validate = array(
		'title' => array('rule' => 'notEmpty'),
		'open_datetime' => array('rule' => 'notEmpty'),
		'close_datetime' => array('rule' => 'notEmpty'),
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

    //FOR myPaarticipantEvent(/users/view)
    public function getMyParticipantEvent($participants) {
        foreach($participants as $participant) {
            $events = $this->find('all', array('conditions' => array('Event.id' => $participant['Participant']['event_id'])));
        }
        return $events;
    }

	public $actsAs = array( //Event Picture Setting
        'UploadPack.Upload' => array(
            'img' => array(
                'quality' => 95,
                'styles' => array(
                    'thumb' => '85x85',
                )
            )
        ),
    );
}
