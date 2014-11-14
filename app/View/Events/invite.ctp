<?php
debug($users);
//ユーザーのリストを出す(最終的には削除する)
	$user_num = count($users);
	echo 'ユーザーは現在全部で'.$user_num.'人です！<br />';

	echo '<table>';
		echo '<tr><td>'.'ID'.'</td><td>'.'名前'.'</td><td>'.'block'.'</td><td>'.'del'.'</td><td>'.'byebye'.'</td><td>'.'event_id'.'</td><td>'.'status'.'</td><td>'.'del(Participant)'.'</td><td>'.'</td></tr>';

		foreach($users as $user){
			$event_num = count($user['Participant']);

			for($j=0;$j<$event_num;$j++){
				echo '<tr>';
				echo '<td>'.$user['User']['id'].'</td>';
				echo '<td>'.$user['User']['name'].'</td>';
				echo '<td>'.$user['User']['block_flg'].'</td>';
				echo '<td>'.$user['User']['del_flg'].'</td>';
				echo '<td>'.$user['User']['byebye_flg'].'</td>';
				echo '<td>'.$user['Participant'][$j]['event_id'].'</td>';
				echo '<td>'.$user['Participant'][$j]['status'].'</td>';
				echo '<td>'.$user['Participant'][$j]['del_flg'].'</td>';
				echo '</tr>';
			}
		}
	echo '</table>';

//ここからプログラミング！
foreach($users as $user){
	echo $user['User']['name'];
}
echo '<br/>';


//ここから！


foreach($users as $user){
	$event_num = count($user['Participant']);

//招待リストに入ってはいけない人を抽出する
	for($j=0;$j<$event_num;$j++){
		if((isset($user['Participant'][$j]['event_id'])) && ($user['Participant'][$j]['event_id'] == 20)  //event_idは動的に変化させる
				&& (isset($user['User']['block_flg'])) && ($user['User']['block_flg'] == 0)
				&& (isset($user['User']['del_flg'])) && ($user['User']['del_flg'] == 0)
				&& (isset($user['User']['byebye_flg'])) && ($user['User']['byebye_flg'] == 0)
				&& (isset($user['Participant'][$j]['del_flg'])) && ($user['Participant'][$j]['del_flg'] == 0)
		){
			echo $user['User']['id'];
			echo $user['User']['name'];
		}
	}
}



echo '<form method="post" action="">';
echo '<input type="checkbox" name="q1" value=1> その1<br/>';
echo '<input type="checkbox" name="q2" value=2> その2<br/>';
echo '<input type="checkbox" name="q3" value=3> その3<br/>';
echo '<input type="checkbox" name="q4" value=4> その4<br/>';
echo '<input type="checkbox" name="q5" value=5> その5<br/>';
echo '<input type="submit" value="更新">';

// <!-- qiとvalueの1のところにuser_idを返す -->



	if($this->request->is('post')){
		$invite_list = $this->request->data;
		echo debug($invite_list);}

if(isset($invite_list)){
	foreach($invite_list as $invite){
		echo $invite;
		echo '<br/>';
	}
}

?>
