<h2>Create new information</h2>

<?php
echo $this->Form->create('Information');
echo $this->Form->input('user_id', array('type' => 'number')); 
echo $this->Form->input('title');
echo $this->Form->input('detail', array('rows'=>5));
//array('rows'=>5)は行数を指定している。
echo $this->Form->end('Save Post');

?>