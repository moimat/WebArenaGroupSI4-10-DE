<?php $this->assign('title', 'Character');?>
<?php if(isset($this->request->data['viewchar'])) pr($raw); ?>

<?php
echo $this->Form->create('viewchar',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'View Character','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('lvlup',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Level up','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('Upload',array('type'=>'file','class'=>'form_inline','role'=>'form'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->input('Avatar',array('type'=>'file'));
echo $this->Form->end(array('label'=>'Upload image','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('createchar',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('name', array('label' => 'name','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Create Character','div'=>false, 'class'=>'btn btn-primary'));
?>

