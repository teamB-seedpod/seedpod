<h2>Event list</h2>

<!--  Create Eventに飛ばすためのリンク -->
<?php
	echo $this->Html->link('Create Event', array('controller' => 'events', 'action' => 'create'));
?>
</br>
</br>


<?php
$nowtime = date("Y-m-d H:i:s");
?>

<h3>Future Event</h3>

<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
	</tr>

	<?php foreach($events as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] > $nowtime): ?>
		<td><?php echo $this->Html->link($event['Event']['title'],array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo $event['Event']['open_datetime']; ?></td>
		<td><?php echo $event['User']['name']; ?></td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>

<h3>Past Event</h3>
<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
	</tr>

	<?php foreach($events as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] < $nowtime): ?>
		<td><?php echo $this->Html->link($event['Event']['title'],array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo $event['Event']['open_datetime']; ?></td>
		<td><?php echo $event['User']['name']; ?></td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
	<?php unset($event); ?>
</table>