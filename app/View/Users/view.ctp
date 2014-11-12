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
