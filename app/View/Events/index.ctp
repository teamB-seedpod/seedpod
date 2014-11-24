<h2>Nexseed Billboard </h2>
<?php
	if(isset($loginUser)){
		if($loginUser['role'] == 1){
			echo $this->Html->link('Create', array('controller' => 'Information', 'action' => 'add')); 
		}
	}
?>
</br>
<ul>
	<?php foreach ($Information as $Info) :?>
		<li>
			<?php
			if(isset($loginUser)){
				if($loginUser['role'] == 1){
					echo $this->Html->link('Edit', array('controller' => 'Information', 'action'=>'edit', $Info['Information']['id']));
					echo '  ';
					echo $this->Form->postLink('Delete', array('controller' => 'Information', 'action'=>'delete', $Info['Information']['id']),
						array('confirm'=>'sure?'));
					echo '  ';
				}
			}
			$createdTime = $Info['Information']['created'];
			$val1 = substr($createdTime,0,10);
			echo $val1;
			echo '  ';
			echo $this->Html->link($Info['Information']['title'],'/Information/view/'.$Info['Information']['id']);
			?>
		</li>
	<?php endforeach; ?>

	<?php foreach ($UsersInformation as $UserInfo) :?>
	<?php
		$Birthday = $UserInfo['User']['birthday'];
		$Username = $UserInfo['User']['name'];

		list($year, $mon, $day) = explode("-", $Birthday); 
		
		$date = new DateTime();

		$currentYear = $date->format('Y');
		$currentMonth = $date->format('m');
		$currentDay = $date->format('d');

		$currenttime = time();

		$SubBirthday = mktime(0, 0, 0, $mon, $day, $currentYear);

		$Birthdays[] = array(
				"Tanjyoubi" => $SubBirthday,
				"namae" => $Username,
		);

	?>

	<?php endforeach; ?>

	<?php

		foreach ($Birthdays as $key => $value) {
			$data[$key] = $value['Tanjyoubi'];
		}

		$hoge = array_multisort($data, SORT_ASC, $Birthdays);
	
		for ($i = 0; $i < count($Birthdays); $i++) {		
			$Birthdate = date("Y-m-d", $Birthdays[$i]['Tanjyoubi']);
			list($year, $mon, $day) = explode("-", $Birthdate); 
		
			$BirthdayPersonName = $Birthdays[$i]['namae'];
			$timeend_birthday = mktime(0, 0, 0, $mon, $day, $currentYear);
			$timestart_birthday = $timeend_birthday -604800;
		
			if($currentMonth == $mon && $currentDay == $day) {
					echo '<li>';
					echo 'Today is '.$BirthdayPersonName.'\'s Birthday';
					echo '</li>';
			};
		
			if($currenttime >= $timestart_birthday && $currenttime <= $timeend_birthday) {
					echo '<li>';
					echo $day.'/'.$mon.' is '.$BirthdayPersonName.'\'s Birthday';
					echo '</li>';
			};
		
		}
	
	?>

	<?php foreach ($UsersInformation as $UserInfo) :?>

	<?php

		$graduationDate = $UserInfo['User']['graduating_date'];
		$graduationPersonName = $UserInfo['User']['name'];

		list($year, $mon, $day) = explode("-", $graduationDate); 
		
		$timeend_graduation = mktime(0, 0, 0, $mon, $day, $year);
		$timestart_graduation = $timeend_graduation -604800;

		if($currentMonth == $mon && $currentDay == $day){
			echo '<li>';
			echo 'Today is '.$graduationPersonName.'\'s graduation!';
			echo '</li>';
		};

		if($currenttime >= $timestart_graduation && $currenttime <= $timeend_graduation){
			echo '<li>';
			echo $day.'/'.$mon.' is '.$graduationPersonName.'\'s graduation date!';
			echo '</li>';
		};

	?>
	
	<?php endforeach; ?>

</ul>

<br /><hr>

<h2>Event List</h2>
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
	<?php if($event['Event']['del_flg'] != 1): ?>
		<tr>
			<?php if($event['Event']['open_datetime'] > $nowtime): ?>
			<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
			<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
			<td><?php echo date('M.d.Y  H:m', strtotime($event['Event']['open_datetime'])).'  〜  '.date('M.d.Y  H:m', strtotime($event['Event']['close_datetime'])); ?></td>
			<td>
				<?php
					echo $this->Html->link(h($event['User']['name']), array('controller' => 'users', 'action' => 'view', $event['User']['id']));
					echo '　';
				?>
			</td>
			<td>
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

<h3>Past Events</h3>
<table>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
		<th>Participants</th>
	</tr>

	<?php $j=0; ?>
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
				<?php $j++; ?>
			<?php endif; ?>
		</tr>
	<?php
		if($j == 3){
			echo '</table>';
			echo $this->Html->link('▶︎Look at all past events', array('action' => 'past'));
			break;
		}
	?>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>