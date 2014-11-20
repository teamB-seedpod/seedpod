<h2>Create an Event</h2>
<?php
	echo $this->Form->create('Event', array('type' => 'file'));
	echo $this->Form->input('title', array('placeholder' => 'Please name event title'));
	echo $this->Form->input('open_datetime');
	echo $this->Form->input('close_datetime');
	echo $this->Form->input('place', array('placeholder' => 'Where do you hold this event?'));
	echo $this->Form->input('detail', array('rows' => '5','placeholder' => 'Budget / Meeting Place / Map / Contact　e.t.c'));
	echo $this->Form->input('user_id', array('type' => 'hidden','value' => $loginUser['id']));
	echo $this->Form->input('img', array('type' => 'file', 'label' => 'Picture'));
	echo $this->Form->end('Save Event');
?>