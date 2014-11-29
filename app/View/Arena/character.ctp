<?php $this->assign('title', 'Character'); ?>
<h1>WebArena Character </h1>
<?php 
echo"
<div class=\"container\">";

if(isset($raw)) 
foreach($raw as $key => $value)
    {
echo"<div class=\"row clearfix\">
 
        <div class=\"col-md-4 column\">
            <h2>
                Player
            </h2>";
echo"
            <div>
                <span class=\"label label-default\">ID</span>";
        echo $raw[$key]['Fighter']['id'];
echo"
            </div>
            <div>
                <span class=\"label label-primary\">Name</span>";
        echo $raw[$key]['Fighter']['name'];
echo"
            </div>
            <div>";
        $id=$raw[$key]['Fighter']['id'];
        echo $this->Html->image('Avatars/avatar-' . $id . '.jpg', array('alt' => 'CakePHP'));
echo"
            </div>
        </div>
        <div class=\"col-md-4 column\">
            <h2>
                Caractéristiques
            </h2>
            <div>
                <span class=\"label label-success\">Level</span>";
        echo $raw[$key]['Fighter']['level'];
echo"
            </div>
            <div>
                <span class=\"label label-info\">Sight</span>";
        echo $raw[$key]['Fighter']['skill_sight'];
echo"
            </div>
            <div>
                <span class=\"label label-warning\">Strength</span>";
        echo $raw[$key]['Fighter']['skill_strength'];
echo"
            </div>
            <div>
                <span class=\"label label-danger\">Health</span>";
        echo $raw[$key]['Fighter']['current_health'];
echo"
            </div>
            <div class=\"progress\">
                <div class=\"progress-bar progress-bar-success progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 40%\">";
        echo $raw[$key]['Fighter']['xp'];
echo"
                </div>
            </div>
        </div>
        <div class=\"col-md-4 column\">";
        echo $raw[$key]['Fighter']['xp'];
echo "        </div>
   </div>";
    }
    
echo"
    <div>
        <div>
            <h2>
                Actions
            </h2>";
            echo $this->Form->create('viewchar', array('class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->end(array('label' => 'View Character', 'div' => false, 'class' => 'btn btn-primary'));
     
            echo $this->Form->create('lvlup', array('class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->end(array('label' => 'Level up', 'div' => false, 'class' => 'btn btn-primary'));
           
            echo $this->Form->create('Upload', array('type' => 'file', 'class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->input('Avatar', array('type' => 'file'));
            echo $this->Form->end(array('label' => 'Upload image', 'div' => false, 'class' => 'btn btn-primary'));
           
            echo $this->Form->create('createchar', array('class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->input('name', array('label' => 'name', 'class' => 'form-control'));
            echo $this->Form->end(array('label' => 'Create Character', 'div' => false, 'class' => 'btn btn-primary'));
echo"
            </p>
            <p><br><br></p>
        </div>
  </div>
</div>";