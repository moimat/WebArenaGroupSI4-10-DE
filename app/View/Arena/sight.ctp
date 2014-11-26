<table class= "table table-striped table-bordered fixed">
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
                $element = '';
                $classDisplay = '';
                $distanceX = 0;
                $distanceY = 0;

                // Afficher Combattants
                //foreach ($raw as $key => $value) {
                if ($raw[0]['Fighter']['coordinate_x'] == $i && $raw[0]['Fighter']['coordinate_y'] == $j) {
                    $element = FIGHTER_CELL . $raw[0]['Fighter']['name'];
                }

                /*
                 * Griser cases pas à portée de vue du combattant
                 */

                // Calcul distance x
                if ($raw[0]['Fighter']['coordinate_x'] > $i) {
                    $distanceX = $raw[0]['Fighter']['coordinate_x'] - $i;
                } else {
                    $distanceX = $i - $raw[0]['Fighter']['coordinate_x'];
                }

                // Calcul distance y
                if ($raw[0]['Fighter']['coordinate_y'] > $j) {
                    $distanceY = $raw[0]['Fighter']['coordinate_y'] - $j;
                } else {
                    $distanceY = $j - $raw[0]['Fighter']['coordinate_y'];
                }

                // Griser si la caractéristique de vue est inférieur à la distance de la case
                if (($distanceX + $distanceY) > $raw[0]['Fighter']['skill_sight']) {
                    $classDisplay = HIDDEN_CELL;
                } else {
                    $classDisplay = VISIBLE_CELL;
                }
                //}
                // Afficher Obstacles
                foreach ($surroundings as $key => $value) {
                    if ($surroundings[$key]['Surrounding']['coordinate_x'] == $i && $surroundings[$key]['Surrounding']['coordinate_y'] == $j) {
                        if ($classDisplay == VISIBLE_CELL) {
                            if ($surroundings[$key]['Surrounding']['type'] == 'colonne')
                                $element = COLUMN_CELL;

                            elseif ($surroundings[$key]['Surrounding']['type'] == 'piege')
                                $element = TRAP_CELL;

                            elseif ($surroundings[$key]['Surrounding']['type'] == 'monstre')
                                $element = MONSTER_CELL;
                        }
                    }
                }

                $displayElement = '<td ' . $classDisplay . '>' . $element . '</td>';
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