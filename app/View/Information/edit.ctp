<h2>Edit Post</h2>

<?php
echo $this->Form->create('Information',array('action' =>'edit'));
echo $this->Form->input('title');
echo $this->Form->input('detail', array('rows'=>3));
echo $this->Form->end('Save!');
?>


