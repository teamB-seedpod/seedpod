<?php
class Comment extends AppModel{
	
	public $belongsTo = array(
	    	'User' => array(	//このUserは配列の引数になる
	    	'className'  => 'User',
	    	'foreignKey' => 'user_id',
	    	)
	    );

	public function getComments($event_id){
	 		$conditions = array(
	 			'Comment.event_id' => $event_id
	 		);

	        $data = $this->find('all', array('conditions' => $conditions));
	// debug($data);
	        return $data;
	 }


}