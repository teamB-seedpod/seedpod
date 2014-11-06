<h2>Event list</h2>

<!--  Create Eventに飛ばすためのリンク -->
<?php
	echo $this->Html->link('Create Event', array('controller' => 'events', 'action' => 'create'));
?>

<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
	</tr>

	<!-- ここから、$list配列をループして、イベントの情報をリストで表示 -->

	<?php var_dump($events) ?>


	<?php foreach($events as $event): ?>
	<tr>
		<td><?php echo $this->Html->link($event['Event']['title'],array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo $event['Event']['open_datetime']; ?></td>
		<td><?php echo $event['User']['name']; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>