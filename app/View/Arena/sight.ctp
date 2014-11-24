<table class= "table table-striped table-bordered">
    <thead>
        <tr>
            <?php		// pour chaque colonne (de la ligne)
                        for ($i=BORDER_WEST; $i<BORDER_EAST; $i++) 
                        { 
        ?>		<th>
        <?php			// -------------------------
                                // DONNEES A AFFICHER dans la cellule
                                echo $i; // CONTENU de la CELLULE (exemple)
                                // -------------------------
        ?>		</th>
        <?php	} // end for
        ?>
        </tr>
    </thead>
    
    <tbody>
    <?php
            // pour chaque ligne
            for ($j=BORDER_NORTH; $j<BORDER_SOUTH; $j++) 
            { 
    ?>
            <tr>
    <?php		// pour chaque colonne (de la ligne)
                    for ($i=BORDER_WEST; $i<BORDER_EAST; $i++) 
                    { 
    ?>		<td>
    <?php			// -------------------------
                            // DONNEES A AFFICHER dans la cellule
                            foreach ($raw as $key => $value) {
                                if($raw[$key]['Fighter']['coordinate_x']==$i && $raw[$key]['Fighter']['coordinate_y']==$j){
                                    echo $raw[$key]['Fighter']['name'];
                                }else{
                                    //echo 'ligne '. $i .', colonne '. $j; // CONTENU de la CELLULE (exemple)
                                } 
                            }
                            // -------------------------
    ?>		</td>
    <?php	} // end for
    ?>
            </tr>
    <?php
            } // end for
    ?>
    </tbody>
</table>

<?php
echo $this->Form->create('Fighteratk',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Attack','div'=>false, 'class'=>'btn btn-primary')); 

echo $this->Form->create('Fightermove',array('class'=>'form_inline','role'=>'form'));
echo $this->Form->input('direction',array('class'=>'form-control','options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->input('id', array('label' => 'id','class'=>'form-control'));
echo $this->Form->end(array('label'=>'Move','div'=>false, 'class'=>'btn btn-primary')); 
?>

<?php $this->assign('title', 'Sight');?>
<?php pr($raw); ?>