<h2>Create new information</h2>

<?php
echo $this->Form->create('Information');
echo $this->Form->input('user_id', array('type' => 'hidden','value' => $loginUser['id']));
echo $this->Form->input('title');
echo $this->Form->input('detail', array('rows' => 5));
echo $this->Form->end('Save Post');

?>