<?php $this->assign('title', 'Login');?>
S'inscrire 
Se connecter
Récupérer son mot de passe

<?php
echo $this->Form->create('login',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'email','class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'password','class'=>'form-control'));
echo $this->Form->end(array('label'=>'inscription','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('connexion',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'email','class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'password','class'=>'form-control'));
echo $this->Form->button('mot de passe oublié?', array('label' => 'password','class'=>'btn btn-danger'));
echo $this->Form->end(array('label'=>'se connecter','div'=>false, 'class'=>'btn btn-primary'));
?>