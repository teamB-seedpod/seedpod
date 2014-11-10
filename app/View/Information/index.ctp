<h2>Nexseed Billboard </h2>
<?php echo $this->Html->link('Create', array('controller' => 'Information', 'action' => 'add')); ?>
</br>
<ul>
	<?php foreach ($Information as $Info) :?>
		<li>
			<?php

			echo $this->Html->link('Edit', array('action'=>'edit', $Info['Information']['id']));
			echo '  ';
			echo $this->Form->postLink('Delete', array('action'=>'delete', $Info['Information']['id']),
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

		$timeend_birthday = mktime(0, 0, 0, $mon, $day, $currentYear);
		$timestart_birthday = $timeend_birthday -604800;

		if($currentMonth == $mon && $currentDay == $day){
			echo '<li>';
			echo 'Today is '.$Username.'\'s Birthday';
			echo '</li>';
		};

		if($currenttime >= $timestart_birthday && $currenttime <= $timeend_birthday){
			echo '<li>';
			echo $day.'/'.$mon.' is '.$Username.'\'s Birthday';
			echo '</li>';
		};

	?>
	
	<?php endforeach; ?>

	<?php foreach ($UsersInformation as $UserInfo) :?>

	<?php

		$graduationDate = $UserInfo['User']['graduating_date'];

		list($year, $mon, $day) = explode("-", $graduationDate); 
		
		$timeend_graduation = mktime(0, 0, 0, $mon, $day, $currentYear);
		$timestart_graduation = $timeend_graduation -604800;

		if($currentMonth == $mon && $currentDay == $day){
			echo '<li>';
			echo 'Today is '.$Username.'\'s graduation!';
			echo '</li>';
		};

		if($currenttime >= $timestart_graduation && $currenttime <= $timeend_graduation){

			echo '<li>';
			echo $day.'/'.$mon.' is '.$Username.'\'s graduation date!';
			echo '</li>';
		};

	?>
	
	<?php endforeach; ?>

</ul>

