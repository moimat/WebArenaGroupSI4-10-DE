<?php $this->assign('title', 'Sight');?>
<?php pr($raw); ?>
<?php
echo $this->Form->create('Fighteratk');
echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id');
echo $this->Form->end('Attack');

echo $this->Form->create('Fightermove');
echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id');
echo $this->Form->end('Move');
?>


