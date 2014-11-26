<?php
class Participant extends AppModel{
	public $name = 'Participant';		//エイリアス的なもの

	//participants(多数)にusers(1つ)をbelongstoでアソシエーションする
	public $belongsTo = array(
    	'User' => array(	//このUserは配列の引数になる
    		'className'  => 'User',
    		'foreignKey' => 'user_id',
        )
    );

	//evet_idとuser_idの2つをAND条件にしてParticipantsテーブル内のデータを検索するためのメソッド
	public function getParticipantInfo($event_id){
			$loginUser = $_SESSION['Auth']['User']['id'];  //Authコンポーネントはモデル内で使えないのでこのように取得
	 		$conditions = array(
	 			'Participant.event_id' => $event_id,
	 			'Participant.user_id' => $loginUser
	 		);

	        $data = $this->find('all', array('conditions' => $conditions));
	        return $data;
	 }

	//Event参加者の配列を返す
	 public function getJoin($event_id){
	 		$conditions = array(
	 			'event_id' => $event_id,
	 			'Participant.status' => 2
	 		);

	        $join_info = $this->find('all', array('conditions' => $conditions));
	        return $join_info;
	 }

	 //Event保留者の配列を返す
	 public function getMaybe($event_id){
	 		$conditions = array(
	 			'event_id' => $event_id,
	 			'Participant.status' => 3
	 		);

	        $maybe_info = $this->find('all', array('conditions' => $conditions));
	        return $maybe_info;
	 }

	 //Event招待者の配列を返す
	 public function getInvited($event_id){
	 		$conditions = array(
	 			'event_id' => $event_id,
	 			'Participant.status' => 1
	 		);

	        $invited_info = $this->find('all', array('conditions' => $conditions));
	        return $invited_info;
     }

}
