<?php
$nowtime = date("Y-m-d H:i:s");
?>

<h3>Past Events</h3>
<table>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
		<th>Participants</th>
	</tr>

	<?php foreach($events as $event): ?>
	<?php if($event['Event']['del_flg'] != 1): ?>
		<tr>
			<?php if($event['Event']['open_datetime'] < $nowtime): ?>
			<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
			<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
			<td><?php echo date('M.d.Y  H:m', strtotime($event['Event']['open_datetime'])).'  〜  '.date('M.d.Y  H:m', strtotime($event['Event']['close_datetime'])); ?></td>
			<td>
				<?php
					echo $this->Html->link(h($event['User']['name']), array('controller' => 'users', 'action' => 'view', $event['User']['id']));
					echo '　';
				?>
			</td>
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
									echo $this->Html->link(h($user['User']['name']), array('controller' => 'users', 'action' => 'view', $user['User']['id']));
									echo '　';
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
	<?php endif; ?>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>