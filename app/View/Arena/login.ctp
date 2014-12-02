<?php $this->assign('title', 'Login');?>
<h1>WebArena Login</h1>

<?php
echo $this->Form->create('login',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'Email','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Register','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('connexion',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'Email','class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'Password','class'=>'form-control'));
echo $this->Form->button('Forgotten password?', array('label' => 'password','class'=>'btn btn-danger'));
echo $this->Form->end(array('label'=>'Log In','div'=>false, 'class'=>'btn btn-primary'));
?>