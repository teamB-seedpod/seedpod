<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('role');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('name');
		echo $this->Form->input('group_id');
		echo $this->Form->input('birthday');
		echo $this->Form->input('coming_date');
		echo $this->Form->input('graduating_date');
		echo $this->Form->input('hobby');
		echo $this->Form->input('introduce');
		echo $this->Form->input('block_flg');
		echo $this->Form->input('del_flg');
		echo $this->Form->input('byebye_flag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
