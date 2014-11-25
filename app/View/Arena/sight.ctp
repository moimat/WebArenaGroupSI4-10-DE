<table class= "table table-striped table-bordered">
    <thead>
        <tr>
            <?php
            for ($i = BORDER_WEST; $i < BORDER_EAST; $i++) {
                echo '<th>' . $i . '</th>';
            }
            ?>
        </tr>
    </thead>

    <tbody>
        <?php
        for ($j = BORDER_NORTH; $j < BORDER_SOUTH; $j++) {
            echo '<tr>';
            for ($i = BORDER_WEST; $i < BORDER_EAST; $i++) {
                // Initialise cell
                $element='';
                
                // DONNEES A AFFICHER dans la cellule
                foreach ($raw as $key => $value) {
                    if ($raw[$key]['Fighter']['coordinate_x'] == $i && $raw[$key]['Fighter']['coordinate_y'] == $j) {
                        $element='<span class="glyphicon glyphicon-user"></span> ' . $raw[$key]['Fighter']['name'];
                    }
                }
                foreach ($surroundings as $key => $value) {
                    if ($surroundings[$key]['Surrounding']['coordinate_x'] == $i && $surroundings[$key]['Surrounding']['coordinate_y'] == $j) {
                        if($surroundings[$key]['Surrounding']['type']=='colonne')
                        $element='<span class="glyphicon glyphicon-tower"></span>';
                        
                        elseif($surroundings[$key]['Surrounding']['type']=='piege')
                        $element='<span class="glyphicon glyphicon-remove-sign"></span>';
                        
                        elseif($surroundings[$key]['Surrounding']['type']=='monstre')
                        $element='<span class="glyphicon glyphicon-certificate"></span>';
                    }
                }
                $displayElement='<td>'.$element.'</td>';
                echo $displayElement;
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<?php
echo $this->Form->create('Fighteratk', array('class' => 'form_inline formClass', 'role' => 'form'));
echo $this->Form->input('direction', array('class' => 'form-control', 'options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->end(array('label' => 'Attack', 'div' => false, 'class' => 'btn btn-primary'));

echo $this->Form->create('Fightermove', array('class' => 'form_inline formClass', 'role' => 'form'));
echo $this->Form->input('direction', array('class' => 'form-control', 'options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id', 'class' => 'form-control'));
echo $this->Form->end(array('label' => 'Move', 'div' => false, 'class' => 'btn btn-primary'));
?>

<?php $this->assign('title', 'Sight'); ?>
<?php pr($raw); ?>