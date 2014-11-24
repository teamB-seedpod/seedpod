<h1>Edit</h1>
<?php
	echo $this->Form->create('Event', array('type' => 'file'));
	echo $this->Form->input('title');
	echo $this->Form->input('open_datetime', array('minYear' => date('Y')));
	echo $this->Form->input('close_datetime', array('minYear' => date('Y')));
	echo $this->Form->input('place');
	echo $this->Form->input('detail', array('rows' => '5'));
	echo $this->Form->input('user_id',array('type' => 'hidden'));
	echo $this->Form->input('img', array('type' => 'file', 'label' => 'Picture'));
	echo $this->Form->end('Save Event');
?>