<h2>Create an Event</h2>
<?php
echo $this->Form->create('Event');
echo $this->Form->input('title', array('placeholder' => 'Please name event title'));
echo $this->Form->input('open_datetime');
echo $this->Form->input('place', array('placeholder' => 'Where do you hold this event?'));
echo $this->Form->input('detail', array('rows' => '5','placeholder' => 'Budget / Meeting Place / Map / Contact         e.t.c'));
echo $this->Form->input('user_id', array('type' => 'hidden','value' => 2));  //最終的にAuthを利用する。
echo $this->Form->end('Save Event');
?>