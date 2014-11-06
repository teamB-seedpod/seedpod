<h2>Nexseed Billboard </h2>

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
	
		<?php echo $UserInfo['User']['name'].' has birthday on '.$UserInfo['User']['birthday']; ?>

		</li>
	<?php endforeach; ?>
</ul>