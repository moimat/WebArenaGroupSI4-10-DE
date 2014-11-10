<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fighter
 *
 * @author matthieu
 */

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

   );
    
function doMove($fighterId, $direction)
    {
        // récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);

        //@todo empêcher le joueur de sortir des limites du terrain
        //@todo empêcher le joueur de se déplacer sur une case occupée
        // falre la modif
        if ($direction == 'north')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
        elseif ($direction == 'south')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
        elseif ($direction == 'east')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
        elseif ($direction == 'west')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
        else
            return false;

        // sauver la modif
        $this->save();
        return true;
    }
}
