<h2><?php echo h($event['Event']['title']); ?></h2>
<?php
	echo $this->Form->postLink(
		        'Join',
	            array('action' => 'join', $event['Event']['id'])
	            );
	echo '　　';
	echo $this->Form->postLink(
		        'Maybe',
	            array('action' => 'maybe', $event['Event']['id'])
	            );
	echo '　　';
	echo $this->Form->postLink(
		        'Decline',
	            array('action' => 'decline', $event['Event']['id'])
	            );
	echo '</br></br>';

	//当該イベントへの当該ユーザーのstatusを反映させる
	$participant_status = $participant_id[0]['Participant']['status'];
	if($participant_status == 1){
		echo '<h3>'.'　　★You\'re invited this Event!★'.'</h3>';
	}else if($participant_status == 2){
		echo '<h3>'.'　　★You\'re going to "join" this Event★'.'</h3>';
	}else if($participant_status == 3){
		echo '<h3>'.'　　★Your status is "Maybe"★'.'</h3>';
	}else if($participant_status == 4){
		echo '<h3>'.'　　★You\'re going to "decline" this Event★'.'</h3>';
	}else{
		echo '<h3>'.'　　★Please express your will★'.'</h3>';
	}
?>

<HR></br>
<dt>Date：</dt>
	<dd><?php echo h($event['Event']['open_datetime']); ?></dd>
<dt>Hosting：</dt>
<dd><?php echo h($hosting['User']['name']); ?></dd>
<dt>Place：</dt>
	<dd><?php echo h($event['Event']['place']); ?></dd>
<dt>Detail：</dt>
	<dd><?php echo h($event['Event']['detail']); ?></dd>
<HR></br>
<dt>Join List：</dt>
	<dd>
		<?php 
			$count=0;
			for($i=0; $i<count($event['Participant']); $i++){
				if($event['Participant'][$i]['status'] == 2){
					//イベント参加予定のuser_idを出す
					$id = h($event['Participant'][$i]['user_id']);
														
					//userDBを吐き出して上記のuser_idと一致したら名前を返す。めちゃくちゃ効率悪い。。。→findByでやる！
					foreach($users as $user){
						$user_id = h($user['User']['id']);
						if($user_id == $id){
							echo h($user['User']['name'])."　";
						}
					}
					$count++;
				}
			}
			echo "   (".$count."people)";			
		?>
	</dd>
<dt>Maybe List：</dt>
	<dd>
		<?php 
			$count=0;
			for($i=0; $i<count($event['Participant']); $i++){
				if($event['Participant'][$i]['status'] == 3){
					//イベント参加予定のuser_idを出す
					// / echo h($event['Participant'][$i]['user_id'])."】";
					$id = h($event['Participant'][$i]['user_id']);
													
					//userDBを吐き出して上記のuser_idと一致したら名前を返す。めちゃくちゃ効率悪い。。。
					foreach($users as $user){
						$user_id = h($user['User']['id']);
						if($user_id == $id){
							echo h($user['User']['name'])."　";
						}
					}
					$count++;
				}
			}
			echo "   (".$count."people)";
		?>
	</dd>
<dt>Invited List：</dt>
	<dd>
		<?php 
			$count=0;
			for($i=0; $i<count($event['Participant']); $i++){
				if($event['Participant'][$i]['status'] == 1){
					//イベント参加予定のuser_idを出す
					// / echo h($event['Participant'][$i]['user_id'])."】";
					$id = h($event['Participant'][$i]['user_id']);
						
					//userDBを吐き出して上記のuser_idと一致したら名前を返す。めちゃくちゃ効率悪い。。。
					foreach($users as $user){
						$user_id = h($user['User']['id']);
						if($user_id == $id){
							echo h($user['User']['name'])."　";
						}
					}
					$count++;
				}
			}
			echo "   (".$count."people)";
		?>
	</dd>
<HR>

<!-- コメント機能の実装 -->
</br><dt>Comments：</dt></br>
<?php
sort($comments);
foreach($comments as $comment){
	echo "　　■".h($comment['Comment']['comment']).'---';
	echo h($comment['Comment']['created']);
	echo "(".h($comment['User']['name']).")　　";
	echo $this->Form->postLink(
	        'Delete',
            array('action' => 'delete_comment', $comment['Comment']['id']),
            array('confirm' => 'Are you sure?')
            );
	echo "</br>";
}
?>

<?php
	$nowtime = date("Y-m-d H:i:s");
	$event_id = $event['Event']['id'];
	echo $this->Form->create('Comment');
	echo $this->Form->input('comment',array('type' => 'detail','placeholder' => 'Please comment'));
	echo $this->Form->input('event_id',array('type' => 'hidden','value' => $event_id));
	echo $this->Form->input('created', array('type' => 'hidden','value' => $nowtime));
	echo $this->Form->input('user_id', array('type' => 'id','value' => '1'));  //最終的にはhiddenにして、値を$userにする(Authの機能)
	echo $this->Form->end('Add');
?>

<HR></br>
<p><?php echo $this->Html->link('Edit this event',array('action' => 'edit', $event['Event']['id'])); ?></p>
<p><?php echo $this->Form->postLink('Delete this event',array('action' => 'delete', $event['Event']['id']),array('confirm' => 'Are you sure?')); ?></p>


<!--          CSSで体裁を整える        -->
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
</head>

<style>
dt{
  font-size : 20px;
  font-weight : bold;

  margin-bottom : 0px;

  border-left-width : 7px;
  border-left-style : solid;
  border-left-color : #666666;

  padding-top : 2px;
  padding-left : 8px;
  padding-bottom : 2px;
}

dd{  
  font-size : 100%;
  line-height : 1.8;    
  margin-bottom : 45px;    
  
  /*padding-left : 30px;*/
  /*padding-right : 15px;*/
}
</style>