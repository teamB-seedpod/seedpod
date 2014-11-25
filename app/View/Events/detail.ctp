<?php echo $this->Html->css('event'); ?>

<?php if($event['Event']['del_flg'] == 1){ throw new NotFoundException(__('Not allowed to access')); } ?>

<?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?>
<h2><?php echo h($event['Event']['title']); ?></h2>
<?php
	if(strtotime($event['Event']['open_datetime']) > strtotime(date("Y-m-d H:i:s"))){
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
		echo '<br /><br />';

		//当該イベントへの当該ユーザーのstatusを反映させる
		if(isset($participants[0]['Participant']['status'])){
			$participant_status = $participants[0]['Participant']['status'];

			if($participant_status == 1){
				echo '<h3>'.'　　▶︎ You\'re invited this event!'.'</h3>';
			}else if($participant_status == 2){
				echo '<h3>'.'　　▶︎ Your status is "Join"'.'</h3>';
			}else if($participant_status == 3){
				echo '<h3>'.'　　▶ ︎Your status is "Maybe"'.'</h3>';
			}else if($participant_status == 4){
				echo '<h3>'.'　　▶︎ Your status is "Decline"'.'</h3>';
			}else{
				echo '<h3>'.'　　Something is wrong'.'</h3>';	//これはべつになくてもいいかも
			}
		}else{
			echo '<h3>'.'　　▶︎ Please express your will'.'</h3>';
		}
	}else{
		echo '<h3>'.'　　This event has been already finished'.'</h3>';
	}
?>

<hr><br />
<dt>Date：</dt>
	<dd><?php echo date('M.d.Y  H:m', strtotime($event['Event']['open_datetime'])).'  〜  '.date('M.d.Y  H:m', strtotime($event['Event']['close_datetime'])); ?></dd>
<dt>Hosting：</dt>
<dd><?php echo $this->Html->link(h($hosting['User']['name']), array('controller' => 'users', 'action' => 'view', $hosting['User']['id'])); ?></dd>
<dt>Place：</dt>
	<dd><?php echo h($event['Event']['place']); ?></dd>
<dt>Detail：</dt>
	<dd><?php echo h($event['Event']['detail']); ?></dd>
<hr><br />
<dt>Join(<?php echo count($join_info); ?>):</dt>
	<dd>
		<?php
			foreach($join_info as $join){
				echo $this->Html->link(h($join['User']['name']), array('controller' => 'users', 'action' => 'view', $join['User']['id']));
				echo '　';
			}
		?>
	</dd>
<dt>Maybe(<?php echo count($maybe_info); ?>):</dt>
	<dd>
		<?php
			foreach($maybe_info as $maybe){
				echo $this->Html->link(h($maybe['User']['name']), array('controller' => 'users', 'action' => 'view', $maybe['User']['id']));
				echo '　';
			}
		?>
	</dd>
<dt>Invited(<?php echo count($invited_info); ?>):</dt>
	<dd>
		<?php
			foreach($invited_info as $invited){
				echo $this->Html->link(h($invited['User']['name']), array('controller' => 'users', 'action' => 'view', $invited['User']['id']));
				echo '　';
			}
		?>
	</dd>
<?php 
	if(strtotime($event['Event']['open_datetime']) > strtotime(date("Y-m-d H:i:s"))){
		 if(isset($loginUser)){
		 	if($event['Event']['user_id'] == $loginUser['id']){
		 		echo $this->Html->link('Send invitation!', array('action' => 'invite', $event['Event']['id']));
		 		echo '<br /><br />';
		 	}
		 }
	}
 ?>
<hr>

<!-- コメント機能の実装 -->
<br /><dt>Comments：</dt><br />
<?php
	sort($comments);
	foreach($comments as $comment){
		if($comment['Comment']['del_flg'] != 1){
			echo "　　■".h($comment['Comment']['comment']).'---';
			echo h($comment['Comment']['created']);
			echo "(".h($comment['User']['name']).")　　";
			if(isset($loginUser)){
				if($comment['Comment']['user_id'] == $loginUser['id']){
					echo $this->Form->postLink(
					        'Delete',
				            array('action' => 'delete_comment', $comment['Comment']['id']),
				            array('confirm' => 'Are you sure?')
				            );
				}
			}
			echo "<br />";
		}
	}
?>

<?php
	$nowtime = date("Y-m-d H:i:s");
	$event_id = $event['Event']['id'];
	echo $this->Form->create('Comment');
	echo $this->Form->input('comment', array('type' => 'detail', 'placeholder' => 'Please comment'));
	echo $this->Form->input('event_id', array('type' => 'hidden', 'value' => $event_id));
	echo $this->Form->input('created', array('type' => 'hidden', 'value' => $nowtime));
	echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $loginUser['id']));
	echo $this->Form->end('Add');
?>

<hr><br />

<?php
	if(isset($loginUser)){
		if($event['Event']['user_id'] == $loginUser['id']){
			echo '<p>'.$this->Html->link('Edit this event', array('action' => 'edit', $event['Event']['id'])).'</p>';
			echo '<p>'.$this->Form->postLink('Delete this event', array('action' => 'delete', $event['Event']['id']), array('confirm' => 'Are you sure?')).'</p>';
		}
	}
?>