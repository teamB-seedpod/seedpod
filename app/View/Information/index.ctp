<h2>Nexseed Billboard </h2>
<?php echo $this->Html->link('Create', array('controller'=>'Information','action'=>'add')) ?>
</br>
<ul>
	<?php foreach ($Information as $Info) : ?>
		<li>
			<?php
//debug($Info);
//echo h($Info['Information']['title']);
//echo date("Y-m-d", strtotime("last Sunday"));
			echo $Info['Information']['created'];
			echo $this->Html->link($Info['Information']['title'],'/Information/view/'.$Info['Information']['id']);
//debug($UserInfo);
			?>
		</li>
	<?php endforeach; ?>

	<?php foreach ($UsersInformation as $UserInfo) :?>
		<li>
	<?php
		//$Birthday = $UserInfo['User']['birthday'];
		//$Username = $UserInfo['User']['name'];
		echo $UserInfo['User']['name'].' has birthday on '.$UserInfo['User']['birthday'];

		//list($year, $mon, $day) = explode("-", $Birthday);
//echo $mon . "月" . $day . "日";
	?>
		</li>
	<?php endforeach; ?>

	<?php foreach ($UsersInformation as $UserInfo) :?>
		<li>


		<?php echo $UserInfo['User']['name'].' will graduate on '.$UserInfo['User']['graduating_date']; ?>

		</li>
	<?php endforeach; ?>

</ul>

