<?php
$nowtime = date("Y-m-d H:i:s");
?>

<div class="users view">
<h2><?php echo h($user['User']['nickname']); ?></h2>

<p>
<?php
    if(isset($loginUser)) {
        if($user['User']['id'] == $loginUser['id']) {        
            echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id']));
        }
    }
?>
</p>

<p class="pic" style="float:left;width:30%;"><?php echo $this->Upload->uploadImage($user, 'User.img'); ?></p>

	<dl style="float:right;width:70%;">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Id'); ?></dt>
		<dd>
        <?php
            if ($user['User']['group_id'] == '1') { 
                echo '<font color="blue">STUDENT</font>';
            } else if ($user['User']['group_id'] == '2'){
                echo '<font color="red">TEACHER</font>';
            } else if ($user['User']['group_id'] == '3'){
                echo '<font color="green">STAFF</font>';
        }?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birthday'); ?></dt>
		<dd>
			<?php echo date('M.d', strtotime($user['User']['birthday'])) ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coming Date'); ?></dt>
		<dd>
			<?php echo date('M.d.Y', strtotime($user['User']['coming_date'])) ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Graduating Date'); ?></dt>
		<dd>
			<?php echo date('M.d.Y', strtotime($user['User']['graduating_date'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hobby'); ?></dt>
		<dd>
			<?php echo h($user['User']['hobby']); ?>
			&nbsp;
		</dd>
		<dt style=""><?php echo __('Introduce'); ?></dt>
		<dd style="">
			<?php echo h($user['User']['introduce']); ?>
			&nbsp;
		</dd>
    </dl>
    <div style="clear:both; padding-top:30px;"></div>

<?php
/**
 * My Event List : OWNER
 */
?>

<h2><?php echo 'OWNER EVENT'; ?></h2>

<h3>Future Events</h3>
<table>
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Date</th>
        <th>Hosting</th>
        <th>Participants</th>
    </tr>
    <?php foreach((array)$myOwnerEvents as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] > $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?> ~ <?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
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
	<?php foreach((array)$myOwnerEvents as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] < $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?> ~ <?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
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
/**
 * My Event List : PARTICIPANT
 */
?>

<h2><?php echo 'PARTICIPANT EVENT'; ?></h2>

<h3>Future Events</h3>
<table>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Date</th>
		<th>Hosting</th>
		<th>Participants</th>
    </tr>
    <?php foreach((array)$myParticipantEvents as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] > $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?> ~ <?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
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
								echo h($user['User']['nickname']);
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
	<?php foreach((array)$myParticipantEvents as $event): ?>
	<tr>
		<?php if($event['Event']['open_datetime'] < $nowtime): ?>
		<td><?php echo $this->Upload->uploadImage($event, 'Event.img', array('style' => 'thumb')) ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'detail', $event['Event']['id'])); ?></td>
		<td><?php echo h(substr($event['Event']['open_datetime'], 0, 16)); ?> ~ <?php echo h(substr($event['Event']['close_datetime'], 0, 16)); ?></td>
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
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
	</ul>
</div>
