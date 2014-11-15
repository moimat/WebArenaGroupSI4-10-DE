<?php pr($raw); ?>

<?php
echo $this->Form->create('Avatar');
echo $this->Form->input('avatar',array('options' => array('brun'=>'1'), 'default' => '1'));
echo $this->Form->end('Choose');
?>

