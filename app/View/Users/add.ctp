<div class="users form">
<?php echo $this->Form->create('User', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Sign up'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('name');

        echo '<div class="input select">';
        echo '<label>Group</label>';
        echo $this->Form->select(
            'group_id',
            array('1' => 'STUDENT', '2' => 'TEACHER', '3' => 'STAFF'), 
            array('escape' => false));
        echo '</div>';

        echo $this->Form->input('img',array('type'=>'file','label'=>'picture'));

		echo $this->Form->input('birthday');
		echo $this->Form->input('coming_date');
		echo $this->Form->input('graduating_date');
		echo $this->Form->input('hobby');
		echo $this->Form->input('introduce');
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
