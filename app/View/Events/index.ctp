<h2>Nexseed Billboard </h2>
<?php echo $this->Html->link('Create', array('controller' => 'Information', 'action' => 'add')); ?>
</br>
<ul>
	<?php foreach ($Information as $Info) :?>
		<li>
			<?php
			echo $this->Html->link('Edit', array('controller' => 'Information', 'action'=>'edit', $Info['Information']['id']));
			echo '  ';
			echo $this->Form->postLink('Delete', array('controller' => 'Information', 'action'=>'delete', $Info['Information']['id']),
				array('confirm'=>'sure?'));
			echo '  ';

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
	//Create Eventに飛ばすためのリンク 
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

	<?php foreach($past_events as $event): ?>
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
			?>
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>

<?php
	//ページネーション
    echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
?>

<div class="paging">
<?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
?>
</div>
