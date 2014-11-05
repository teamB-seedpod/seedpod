<h2>Nexseed Billboard </h2>

<ul>
<?php foreach ($Information as $Info) : ?>
<li>
<?php
//debug($Info);
//echo h($Info['Information']['title']);


echo $this->Html->link($Info['Information']['title'],'/Information/view/'.$Info['Information']['id']);
?>
</li>
<?php endforeach; ?>
</ul>