<?php $this->assign('title', 'Sight');?>
<?php pr($raw); ?>
<?php
echo $this->Form->create('Fighteratk',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Attack','div'=>false, 'class'=>'btn btn-primary')); 

echo $this->Form->create('Fightermove',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Move','div'=>false, 'class'=>'btn btn-primary')); 
?>
