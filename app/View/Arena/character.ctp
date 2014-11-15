<?php if(isset($this->request->data['viewchar'])) pr($raw); ?>

<?php
echo $this->Form->create('viewchar');
echo $this->Form->input('id',array('options' => array('1'=>'1','2'=>'2'), 'default' => '1'));
echo $this->Form->end('view character');
?>

