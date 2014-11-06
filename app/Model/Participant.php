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

}