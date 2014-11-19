<?php
echo '<h3>Invitation for 『'.$event['Event']['title'].'』</h3>';

echo '<form method="post" action="">';
	foreach($users as $user){
		$event_num = count($user['Participant']);

		//招待リストに入ってはいけない人を抽出する
		for($j=0;$j<$event_num;$j++){
			if((isset($user['Participant'][$j]['event_id'])) && ($user['Participant'][$j]['event_id'] == $event['Event']['id'])
					&& (isset($user['User']['block_flg'])) && ($user['User']['block_flg'] == 0)
					&& (isset($user['User']['del_flg'])) && ($user['User']['del_flg'] == 0)
					&& (isset($user['User']['byebye_flg'])) && ($user['User']['byebye_flg'] == 0)
					&& (isset($user['Participant'][$j]['del_flg'])) && ($user['Participant'][$j]['del_flg'] == 0)
			){
				$inviteNgId = $user['User']['id'];
				$inviteNgName = $user['User']['name'];
			}
		}
		//招待リストに入るべき人を抽出する
		if((isset($inviteNgName)) && ($user['User']['id'] != $inviteNgId)){
			$inviteOkId = $user['User']['id'];
			$inviteOkName = $user['User']['name'];
		}
		if(!isset($inviteNgId)){
			$inviteOkId = $user['User']['id'];
			$inviteOkName = $user['User']['name'];
		}
		if(isset($inviteOkId) && isset($inviteOkName)){
			echo '<input type="checkbox" name="'.$inviteOkId.'" value='.$inviteOkId.'>'.$inviteOkName.'<br/>';
		}
		//招待リストをリセットする
		$inviteOkId = null;
		$inviteOkName = null;
	}
echo '<input type="submit" value="Invite">';


