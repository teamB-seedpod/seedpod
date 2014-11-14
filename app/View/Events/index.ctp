<h2>Event list</h2>

<!--  Create Eventに飛ばすためのリンク -->
<?php
	echo $this->Html->link('Create Event', array('controller' => 'events', 'action' => 'create'));
?>
<br /><br />

<?php
$nowtime = date("Y-m-d H:i:s");
?>

<h3>Future Events</h3>

<table>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
		<th>Participants</th>
	</tr>
	<?php foreach($events as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] > $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?>〜<?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
		<td><?php echo $event['User']['name']; ?></td>
		<td><?php
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
			echo "   (".$count.")";
			?>
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>

<h3>Past Events</h3>
<table>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
		<th>Participants</th>
	</tr>

<?php $number=0; //Pastイベントカウント用の変数。Nコだけ表示するようにする ?>

	<?php foreach($events as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] < $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?>〜<?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
		<td><?php echo $event['User']['name']; ?></td>
		<td><?php
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
			echo "   (".$count.")";
			$number++;
			?>
		</td>
			<?php
				// カウントがNコ以上になったら、showmoreとして示す
					if($number == 3){
						echo '</tr></table>';
						echo $this->Html->link('▶︎Look at all events', array('controller' => 'events', 'action' => 'lists'));
						break;
					}
			?>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>