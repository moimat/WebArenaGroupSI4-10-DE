<?php $this->assign('title', 'Character');?>
<?php if(isset($this->request->data['viewchar'])) pr($raw); ?>

<?php
echo $this->Form->create('viewchar');
echo $this->Form->input('id');
echo $this->Form->end('view character');
?>

<?php
echo $this->Form->create('lvlup');
echo $this->Form->input('id');
echo $this->Form->end('level up');
?>

<?php
echo $this->Form->create('Upload', array('type' => 'file'));
echo $this->Form->input('id');
echo $this->Form->input('Avatar',array('type'=>'file'));
echo $this->Form->end('Upload image');
?>

<?php
echo $this->Form->create('createchar');
echo $this->Form->input('name');
echo $this->Form->end('Create Character');
?>

