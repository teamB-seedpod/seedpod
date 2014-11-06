<h2><?php echo h($event['Event']['title']); ?></h2>

<dt>Date：</dt>
	<dd><?php echo h($event['Event']['open_datetime']); ?></dd>
<dt>Hosting：</dt>
<dd><?php echo h($hosting['User']['name']); ?></dd>
<dt>Place：</dt>
	<dd><?php echo h($event['Event']['place']); ?></dd>
<dt>Detail：</dt>
	<dd><?php echo h($event['Event']['detail']); ?></dd>
<p><?php echo $this->Html->link('Edit',array('action' => 'edit', $event['Event']['id'])); ?></p>
<p><?php echo $this->Form->postLink('Delete',array('action' => 'delete', $event['Event']['id']),array('confirm' => 'Are you sure?')); ?></p>


<!--          CSSで体裁を整える        -->
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
</head>

<style>
dt{
  font-size : 20px;
  font-weight : bold;

  margin-bottom : 0px;

  border-left-width : 7px;
  border-left-style : solid;
  border-left-color : #666666;

  padding-top : 2px;
  padding-left : 8px;
  padding-bottom : 2px;
}

dd{  
  font-size : 100%;
  line-height : 1.8;    
  margin-bottom : 45px;    
  
  /*padding-left : 30px;*/
  /*padding-right : 15px;*/
}
</style>