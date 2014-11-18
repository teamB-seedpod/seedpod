<?php echo $this->Html->css('event'); ?>

<?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?>
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
	echo '<br /><br />';

	//当該イベントへの当該ユーザーのstatusを反映させる
	if(isset($participants[0]['Participant']['status'])){
		$participant_status = $participants[0]['Participant']['status'];

		if($participant_status == 1){
			echo '<h3>'.'　　▶︎You\'re invited this event!'.'</h3>';
		}else if($participant_status == 2){
			echo '<h3>'.'　　▶︎Your status is "Join"'.'</h3>';
		}else if($participant_status == 3){
			echo '<h3>'.'　　▶︎Your status is "Maybe"'.'</h3>';
		}else if($participant_status == 4){
			echo '<h3>'.'　　▶︎Your status is "Decline"'.'</h3>';
		}else{
			echo '<h3>'.'　　Something is wrong'.'</h3>';	//これはべつになくてもいいかも
		}
	}else{
		echo '<h3>'.'　　★Please express your will★'.'</h3>';
	}
?>

<hr><br />
<dt>Date：</dt>
	<dd><?php echo h(substr($event['Event']['open_datetime'],0,16)); ?>〜<?php echo h(substr($event['Event']['close_datetime'],0,16)); ?></dd>
<dt>Hosting：</dt>
<dd><?php echo h($hosting['User']['name']); ?></dd>
<dt>Place：</dt>
	<dd><?php echo h($event['Event']['place']); ?></dd>
<dt>Detail：</dt>
	<dd><?php echo h($event['Event']['detail']); ?></dd>
<hr><br />
<dt>Join(<?php echo count($join_info); ?>):</dt>
	<dd>
		<?php 
			foreach($join_info as $join){
				echo h($join['User']['name']).'　';
			}
		?>
	</dd>
<dt>Maybe(<?php echo count($maybe_info); ?>):</dt>
	<dd>
		<?php 
			foreach($maybe_info as $maybe){
				echo h($maybe['User']['name']).'　';
			}
		?>
	</dd>
<dt>Invited(<?php echo count($invited_info); ?>):</dt>
	<dd>
		<?php 
			foreach($invited_info as $invited){
				echo h($invited['User']['name']).'　';
			}
		?>
	</dd>
<?php echo $this->Html->link('Send invitation!', array('action' => 'invite', $event['Event']['id'])); ?>
<br /><br /><hr>

<!-- コメント機能の実装 -->
<br /><dt>Comments：</dt><br />
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
	echo "<br />";
}
?>

<?php
	$nowtime = date("Y-m-d H:i:s");
	$event_id = $event['Event']['id'];
	echo $this->Form->create('Comment');
	echo $this->Form->input('comment', array('type' => 'detail', 'placeholder' => 'Please comment'));
	echo $this->Form->input('event_id', array('type' => 'hidden', 'value' => $event_id));
	echo $this->Form->input('created', array('type' => 'hidden', 'value' => $nowtime));
	echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $loginUser['id']));  //最終的にはhiddenにして、値を$userにする(Authの機能)
	echo $this->Form->end('Add');
?>

<hr><br />
<p><?php echo $this->Html->link('Edit this event', array('action' => 'edit', $event['Event']['id'])); ?></p>
<p><?php echo $this->Form->postLink('Delete this event', array('action' => 'delete', $event['Event']['id']), array('confirm' => 'Are you sure?')); ?></p>