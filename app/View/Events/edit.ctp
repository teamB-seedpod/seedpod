<h1>Edit</h1>
<?php
echo $this->Form->create('Event');
echo $this->Form->input('title');
echo $this->Form->input('open_datetime');
echo $this->Form->input('place');
echo $this->Form->input('detail', array('rows' => '5'));
echo $this->Form->input('id',array('type' => 'hidden'));
echo $this->Form->end('Save Event');
?>