<?php $this->assign('title', 'Sight'); ?>
<div>
    <h1>WebArena Game Board</h1>
    <a name="anchor"></a>
    <div>
        <?php echo $this->Form->end(); ?>
        <?php
        foreach ($tools as $key => $value) {
            // Afficher le bouton pour ramasser l'objet si on est sur la case
            if ($tools[$key]['Tool']['coordinate_x'] == $currentFighter['Fighter']['coordinate_x'] && $tools[$key]['Tool']['coordinate_y'] == $currentFighter['Fighter']['coordinate_y']) {
                echo $this->Form->create('PickUp', array('class' => 'form_inline formClass', 'role' => 'form'));
                ?>
                <button id="tool" class="btn btn-primary" controller="Arena" action="sight" type=direction name=data[PickUp] value="refresh">
                    <span class="glyphicon glyphicon-gift"> Pick Tool</span> 
                </button>
                <?php
                echo $this->Form->end();
            }
        }
        ?>

        <?php
        echo $this->Form->create('Fightermove', array('class' => 'form_inline formClass', 'role' => 'form'));
        echo $this->Form->label('Move:');
        ?>
        <div class="btn-group">
            <button class="btn btn-warning" controller="Arena" action="sight" type=direction name=data[Fightermove][direction] value="west">
                <span class="glyphicon glyphicon-arrow-left"> West</span> 
            </button>
            <button class="btn btn-warning" controller="Arena" action="sight" type=direction name=data[Fightermove][direction] value="east">
                <span class="glyphicon glyphicon-arrow-right"> East</span> 
            </button>
            <button class="btn btn-warning" controller="Arena" action="sight" type=direction name=data[Fightermove][direction] value=north>
                <span class="glyphicon glyphicon-arrow-up"> North</span> 
            </button>
            <button class="btn btn-warning" controller="Arena" action="sight" type=direction name=data[Fightermove][direction] value=south>
                <span class="glyphicon glyphicon-arrow-down"> South</span> 
            </button>
        </div>
    </div>

    <div>
        <?php echo $this->Form->create('Refresh', array('class' => 'form_inline formClass', 'role' => 'form'));
        ?>
        <button id="refresh" class="btn btn-success" controller="Arena" action="sight" type=direction name=data[Refresh] value="refresh">
            <span class="glyphicon glyphicon-refresh"> Regenerate Arena</span> 
        </button>
        <?php echo $this->Form->end(); ?>

        <?php
        echo $this->Form->create('Fighteratk', array('class' => 'form_inline formClass', 'role' => 'form'));
        echo $this->Form->label('Attack:');
        ?>
        <div class="btn-group">
            <button class="btn btn-info" controller="Arena" action="sight" type=direction name=data[Fighteratk][direction] value="west">
                <span class="glyphicon glyphicon-arrow-left"> West</span> 
            </button>
            <button class="btn btn-info" controller="Arena" action="sight" type=direction name=data[Fighteratk][direction] value="east">
                <span class="glyphicon glyphicon-arrow-right"> East</span> 
            </button>
            <button class="btn btn-info" controller="Arena" action="sight" type=direction name=data[Fighteratk][direction] value=north>
                <span class="glyphicon glyphicon-arrow-up"> North</span> 
            </button>
            <button class="btn btn-info" controller="Arena" action="sight" type=direction name=data[Fighteratk][direction] value=south>
                <span class="glyphicon glyphicon-arrow-down"> South</span> 
            </button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <table class= "table table-striped table-bordered fixed">
        <thead>
            <tr>
                <?php
                for ($i = BORDER_WEST; $i <= BORDER_EAST; $i++) {
                    echo '<th>' . $i . '</th>';
                }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php
            for ($j = BORDER_NORTH; $j <= BORDER_SOUTH; $j++) {
                echo '<tr>';
                for ($i = BORDER_WEST; $i <= BORDER_EAST; $i++) {
                    // Initialise cell
                    $element = '';
                    $classDisplay = '';
                    $distanceX = 0;
                    $distanceY = 0;
                    $surroundingNextCell = false;
                    $tooltipTitle = '';

                    /*
                     * Griser cases pas à portée de vue du combattant
                     */

                    // Calcul distance x
                    if ($currentFighter['Fighter']['coordinate_x'] > $i) {
                        $distanceX = $currentFighter['Fighter']['coordinate_x'] - $i;
                    } else {
                        $distanceX = $i - $currentFighter['Fighter']['coordinate_x'];
                    }

                    // Calcul distance y
                    if ($currentFighter['Fighter']['coordinate_y'] > $j) {
                        $distanceY = $currentFighter['Fighter']['coordinate_y'] - $j;
                    } else {
                        $distanceY = $j - $currentFighter['Fighter']['coordinate_y'];
                    }

                    // Griser si la caractéristique de vue est inférieur à la distance de la case
                    if (($distanceX + $distanceY) > $currentFighter['Fighter']['skill_sight']) {
                        $classDisplay = HIDDEN_CELL;
                    } else {
                        $classDisplay = VISIBLE_CELL;
                    }

                    // Afficher combattants
                    foreach ($fighters as $key => $value) {
                        if ($classDisplay == VISIBLE_CELL) {
                            if ($fighters[$key]['Fighter']['coordinate_x'] == $i && $fighters[$key]['Fighter']['coordinate_y'] == $j) {
                                $element = FIGHTER_CELL;
                                $tooltipTitle = $fighters[$key]['Fighter']['name'] . ' : [' . $i . '][' . $j . ']';
                            }
                        }
                    }

                    // Si case joueur (combattant actuel)
                    if ($currentFighter['Fighter']['coordinate_x'] == $i && $currentFighter['Fighter']['coordinate_y'] == $j) {

                        // Boucle surroundings
                        foreach ($surroundings as $key => $value) {
                            // Si on est a une case du combattant
                            if ((($surroundings[$key]['Surrounding']['coordinate_x'] + 1) == $i) && ($surroundings[$key]['Surrounding']['coordinate_y'] == $j)) {
                                $surroundingNextCell = true;
                            } elseif ((($surroundings[$key]['Surrounding']['coordinate_x'] - 1) == $i) && ($surroundings[$key]['Surrounding']['coordinate_y'] == $j)) {
                                $surroundingNextCell = true;
                            } elseif ((($surroundings[$key]['Surrounding']['coordinate_y'] + 1) == $j) && ($surroundings[$key]['Surrounding']['coordinate_x'] == $i)) {
                                $surroundingNextCell = true;
                            } elseif ((($surroundings[$key]['Surrounding']['coordinate_y'] - 1) == $j) && ($surroundings[$key]['Surrounding']['coordinate_x'] == $i)) {
                                $surroundingNextCell = true;
                            } else {
                                $surroundingNextCell = false;
                            }

                            // Si surrounding trouvé, tester son type
                            if ($surroundingNextCell) {
                                // Alerter pieges invisibles
                                if ($surroundings[$key]['Surrounding']['type'] == 'piege') {
                                    $element = $element . WARNING_CELL . 'Brise suspecte';
                                }
                                // Alerter monstre invisible
                                if ($surroundings[$key]['Surrounding']['type'] == 'monstre') {
                                    $element = $element . WARNING_CELL . 'Puanteur';
                                }
                            }
                        }
                    }
                    // Représentation obstacles sur le terrain
                    foreach ($surroundings as $key => $value) {
                        // Afficher tour
                        if ($surroundings[$key]['Surrounding']['coordinate_x'] == $i && $surroundings[$key]['Surrounding']['coordinate_y'] == $j) {
                            if ($classDisplay == VISIBLE_CELL) {
                                if ($surroundings[$key]['Surrounding']['type'] == 'colonne') {
                                    $element = COLUMN_CELL;
                                    $tooltipTitle= 'Column'. ' : [' . $i . '][' . $j . ']';
                                }
                            }
                        }
                    }

                    // Représentation tools sur le terrain
                    foreach ($tools as $key => $value) {
                        // Afficher tool
                        if ($tools[$key]['Tool']['coordinate_x'] == $i && $tools[$key]['Tool']['coordinate_y'] == $j) {
                            if ($classDisplay == VISIBLE_CELL) {
                                if ($tools[$key]['Tool']['bonus'] == 1) {
                                    $quality = 'Small';
                                } elseif ($tools[$key]['Tool']['bonus'] == 2) {
                                    $quality = 'Medium';
                                } else {
                                    $quality = 'Big';
                                }
                                if ($tools[$key]['Tool']['type'] == 'health') {
                                    $element = $element . HEALTH_CELL;
                                    $tooltipTitle = $quality . ' Health Powerup'. ' : [' . $i . '][' . $j . ']';
                                } elseif ($tools[$key]['Tool']['type'] == 'sight') {
                                    $element = $element . SIGHT_CELL;
                                    $tooltipTitle = $quality . ' Sight Powerup'. ' : [' . $i . '][' . $j . ']';
                                } else {
                                    $element = $element . STRENGTH_CELL;
                                    $tooltipTitle = $quality . ' Strength Powerup'. ' : [' . $i . '][' . $j . ']';
                                }
                            }
                        }
                    }
                    $tooltip = 'data-toggle="tooltip" data-placement="bottom" title="' . $tooltipTitle . '" ';
                    $displayElement = '<td ' . $tooltip . $classDisplay . '>' . $element . '</td>';
                    echo $displayElement;
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <p><br><br></p>
</div>