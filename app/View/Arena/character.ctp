<?php $this->assign('title', 'Character'); ?>

<h1>Characters</h1>
<?php
echo"
<div class=\"container\">";

if (isset($raw))
    {
foreach ($raw as $key => $value) {
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
        $id = $raw[$key]['Fighter']['id'];
        echo $this->Html->image('/img/Avatars/avatar-' . $id . '.jpg', array('alt' => 'CakePHP','width' => '30%', 'height' => '20%'));
        echo"
            </div>
        </div>
        <div class=\"col-md-4 column\">
            <h2>
                Abilities
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
                <span class=\"label label-danger\">Position (x,y)</span>";
        
        $posx=strval($raw[$key]['Fighter']['coordinate_x']);
        $posy=strval($raw[$key]['Fighter']['coordinate_y']);
        echo "($posx,$posy)";
        
        $current_health=strval($raw[$key]['Fighter']['current_health']);
        $skill_health=strval($raw[$key]['Fighter']['skill_health']);
        $width_health=($current_health/$skill_health)*100;
        echo"
            </div>
            <div class=\"progress\">
<div class=\"progress-bar progress-bar-success progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"$current_health\" aria-valuemin=\"0\" aria-valuemax=\"$skill_health\" style=\"width: $width_health%\">";        
        $xp=strval($raw[$key]['Fighter']['xp']);
        $width_xp=($xp/4)*100;
        echo "Health : $current_health / $skill_health";
        echo"
                </div>
            </div>
            <div class=\"progress\">
            <div class=\"progress-bar progress-bar-info progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"$xp\" aria-valuemin=\"0\" aria-valuemax=\"4\" style=\"width: $width_xp%\">";
        echo "Experience : $xp / 4";
        echo"
                </div>
            </div>
        </div>
        <div class=\"col-md-4 column\">";
        echo $this->Form->create('enter', array('class' => 'form_inline formClass', 'role' => 'form'));
        echo"
        <button class=\"btn btn-warning\" controller=\"Arena\" action=\"character\" type=id name=data[enter][id] value=\"$id\">
        <span>Enter Arena</span> 
    </button>";
        echo $this->Form->end();
        
        echo $this->Form->create('lvlup', array('class' => 'form_inline formClass', 'role' => 'form'));
        echo $this->Form->input('skillup',array('label' => 'skill to upgrade','options' => array('health','sight','strength')));
        echo"
        <button class=\"btn btn-primary\" controller=\"Arena\" action=\"character\" type=id name=data[lvlup][id] value=\"$id\">
        <span>Level Up</span> 
        </button>";
        echo $this->Form->end();//array('label' => 'Level Up', 'div' => false, 'class' => 'btn btn-primary'));
        
        echo $this->Form->create('Upload', array('type' => 'file', 'class' => 'form_inline formClass', 'role' => 'form'));
        //echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
        echo $this->Form->input('Avatar', array('type' => 'file'));
        echo"
        <button class=\"btn btn-primary\" controller=\"Arena\" action=\"character\" type=id name=data[Upload][id] value=\"$id\">
        <span>Upload avatar</span> 
        </button>";
        echo $this->Form->end();//array('label' => 'Upload image', 'div' => false, 'class' => 'btn btn-primary'));
        
        echo "        </div>
   </div>";
    }
}

echo"
    <div>
        <div>
            <h2>
                Actions
            </h2>";
/*echo $this->Form->create('viewchar', array('class' => 'form_inline formClass', 'role' => 'form'));
//echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));?>
<button class="btn btn-info" controller="Arena" action="character" type=view name=data[viewchar][view] value="ok">View All Characters
</button><?php
echo $this->Form->end();//array('label' => 'View Character', 'div' => false, 'class' => 'btn btn-primary'));*/

/*echo $this->Form->create('Upload', array('type' => 'file', 'class' => 'form_inline formClass', 'role' => 'form'));
echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->input('Avatar', array('type' => 'file'));
echo $this->Form->end(array('label' => 'Upload image', 'div' => false, 'class' => 'btn btn-primary'));*/

echo $this->Form->create('createchar', array('class' => 'form_inline formClass', 'role' => 'form'));
//echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->input('name', array('label' => 'name', 'class' => 'form-control'));
echo $this->Form->end(array('label' => 'Create Character', 'div' => false, 'class' => 'btn btn-primary'));
echo"
            </p>
            <p><br><br></p>
        </div>
  </div>
</div>";
