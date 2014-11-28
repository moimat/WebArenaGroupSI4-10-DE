<?php $this->assign('title', 'Login');?>
<h1>WebArena Login</h1>
S'inscrire 
Se connecter
Récupérer son mot de passe

<?php
echo $this->Form->create('login',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'email','class'=>'form-control'));
echo $this->Form->end(array('label'=>'inscription','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('connexion',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('email', array('label' => 'email','class'=>'form-control'));
echo $this->Form->input('password', array('label' => 'password','class'=>'form-control'));
echo $this->Form->button('mot de passe oublié?', array('label' => 'password','class'=>'btn btn-danger'));
echo $this->Form->end(array('label'=>'se connecter','div'=>false, 'class'=>'btn btn-primary'));
?>

<?php
echo $this->Form->create('deco',array('class'=>'form_inline formClass','role'=>'form'));
echo $this->Form->input('password', array('label' => 'confirmer mot de passe','class'=>'form-control'));
echo $this->Form->end(array('label'=>'se deconnecter','div'=>false, 'class'=>'btn btn-primary'));
?>


<form name="deco" class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>

