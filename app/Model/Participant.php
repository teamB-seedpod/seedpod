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
	public function getParticipantId($event_id){
	 		$conditions = array(
	 			'Participant.event_id' => $event_id,
	 			'Participant.user_id' => 1  //最終的にはauthの機能を利用して修正する
	 		);

	        $data = $this->find('all', array('conditions' => $conditions));
	// debug($data);
	        return $data;
	 }

}