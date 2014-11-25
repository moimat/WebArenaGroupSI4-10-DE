<div class="container">
    <div class="row clearfix">
        <div class="col-md-4 column">
            <h2>
                Player
            </h2>
            <div>
                <span class="label label-default">ID</span>
                    <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['id'];
                    }?>
            </div>
            <div>
                <span class="label label-primary">Name</span>
                <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['name'];
                    }?>
            </div>
            <div>
                <span class="label label-success">Level</span>
                <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['level'];
                    }?>
            </div>
            <div>
                <span class="label label-info">Sight</span>
                <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['skill_sight'];
                    }?>
            </div>
            <div>
                <span class="label label-warning">Strength</span>
                <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['skill_strength'];
                    }?>
            </div>
            <div>
                <span class="label label-danger">Health</span>
                <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['current_health'];
                    }?>
            </div>
        </div>
        <div class="col-md-4 column">
            <h2>
                Experience
            </h2>
            <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <?php
                    if (isset($this->request->data['viewchar'])) {
                        echo $raw['Fighter']['xp'];
                    } else {
                        echo ('Aucun');
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 column">
            <h2>
                Actions
            </h2>
            <?php
            echo $this->Form->create('viewchar', array('class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->end(array('label' => 'View Character', 'div' => false, 'class' => 'btn btn-primary'));
            ?>

            <?php
            echo $this->Form->create('lvlup', array('class' => 'form_inline formClass', 'role' => 'form'));
            echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
            echo $this->Form->end(array('label' => 'Level up', 'div' => false, 'class' => 'btn btn-primary'));
            ?>
            </p>
        </div>
    </div>
</div>

<?php $this->assign('title', 'Character'); ?>
<?php
if (isset($this->request->data['viewchar'])) {
    pr($raw);
}
?>


<?php
echo $this->Form->create('Upload', array('type' => 'file', 'class' => 'form_inline formClass', 'role' => 'form'));
echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->input('Avatar', array('type' => 'file'));
echo $this->Form->end(array('label' => 'Upload image', 'div' => false, 'class' => 'btn btn-primary'));
?>

<?php
echo $this->Form->create('createchar', array('class' => 'form_inline formClass', 'role' => 'form'));
echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->end(array('label' => 'Create Character', 'div' => false, 'class' => 'btn btn-primary'));
?>

