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

    public function doMove($fighterId, $direction) {
        // récupérer la position et fixer l'id de travail
        $joueur = $this->read(null, $fighterId);
        $posx=0;
        $posy=0;
        //@todo empêcher le joueur de sortir des limites du terrain
        //@todo empêcher le joueur de se déplacer sur une case occupée
        // falre la modif
        if ($direction == 'north') {
            if ($joueur['Fighter']['coordinate_y'] != BORDER_NORTH) {
                $this->set('coordinate_y', $joueur['Fighter']['coordinate_y'] - 1);
                $posx = $joueur['Fighter']['coordinate_x'];
                $posy = $joueur['Fighter']['coordinate_y']-1;
            }
        } elseif ($direction == 'south') {
            if ($joueur['Fighter']['coordinate_y'] != BORDER_SOUTH) {
                $this->set('coordinate_y', $joueur['Fighter']['coordinate_y'] + 1);
                $posx = $joueur['Fighter']['coordinate_x'];
                $posy = $joueur['Fighter']['coordinate_y']+1;
            }
        } elseif ($direction == 'east') {
            if ($joueur['Fighter']['coordinate_x'] != BORDER_EAST) {
                $this->set('coordinate_x', $joueur['Fighter']['coordinate_x'] + 1);
                $posx = $joueur['Fighter']['coordinate_x']+1;
                $posy = $joueur['Fighter']['coordinate_y'];
            }
        } elseif ($direction == 'west') {
            if ($joueur['Fighter']['coordinate_x'] != BORDER_WEST) {
                $this->set('coordinate_x', $joueur['Fighter']['coordinate_x'] - 1);
                $posx = $joueur['Fighter']['coordinate_x']-1;
                $posy = $joueur['Fighter']['coordinate_y'];
            }
        }

        if ($posx != 0 && $posy != 0) {
            $dateNow = date("Y-m-d H:i:s");
            $nameEvent = $joueur['Fighter']['name'] . ' se déplace en: ' . $posx . ':' . $posy;

            $eventArray = array(
                "coordinate_x" => $posx,
                "coordinate_y" => $posy,
                "date" => $dateNow,
                "name" => $nameEvent);

            // sauver la modif
            $this->save();

            return $eventArray;
        } else {
            return false;
        }
    }

    public function lvlUp($fighterId) {
        $datas = $this->read(null, $fighterId);
        $this->set('level', $datas['Fighter']['level'] + 1);
        $this->save();
    }

    public function doAttack($fighterId, $direction) {
        // récupérer la position et fixer l'id de travail
        $joueur = $this->read(null, $fighterId);
        $liste=$this->find('all');
        $posx = $joueur['Fighter']['coordinate_x'];
        $posy = $joueur['Fighter']['coordinate_y'];
        
        if($direction=='north'){
            $posx_cible=$posx;
            $posy_cible=$posy-1;
        }
        if($direction=='south'){
            $posx_cible=$posx;
            $posy_cible=$posy+1;
        }
        if($direction=='east'){
            $posx_cible=$posx+1;
            $posy_cible=$posy;
        }
        if($direction=='west'){
            $posx_cible=$posx-1;
            $posy_cible=$posy;
        }
        
        foreach ($liste as $key => $value) {
            if($liste[$key]['Fighter']['coordinate_x']==$posx_cible && $liste[$key]['Fighter']['coordinate_y']==$posy_cible){
                $idcible=$liste[$key]['Fighter']['id'];
                $cible=$this->read(null,$idcible);
                pr($cible);
                $rand=rand(1,20);
                $seuil=$cible['Fighter']['level']-$joueur['Fighter']['level']+10;
                $success=NULL;
                if ($rand>$seuil){
                    $this->set('current_health', $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength']);
                    $this->save();
                    pr('attaque reussie');
                    $success='succès';
                    $joueur = $this->read(null, $fighterId);
                    $this->set('xp', $joueur['Fighter']['xp']+1);
                    pr('Xp augmentée');
                }
                else{
                    pr('attaque échouée');
                    $success='echec';
                }
            }    
        }
        // Create corresponding Event        
        $dateNow = date("Y-m-d H:i:s");
        $nameEvent = $joueur['Fighter']['name'] . ' attaque ' . $cible['Fighter']['name'] . ':' . $success;

        $eventArray = array(
            "coordinate_x" => $posx,
            "coordinate_y" => $posy,
            "date" => $dateNow,
            "name" => $nameEvent);
        // sauver la modif
        $this->save();
        $cible_after=$this->read(null,$idcible);
                pr($cible_after);
        return $eventArray;
    }

    public function fileUpload($id) {

        $repertoire = "img/Avatars/";

        $image = $repertoire . 'avatar-' . $id . '.jpg';

        if (move_uploaded_file($_FILES['data']['tmp_name']['Upload']['Avatar'], WWW_ROOT . $image)) {
            echo "The file " . basename($_FILES["data"]["name"]['Upload']['Avatar']) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    public function createCharacter($newName, $playerID) {
        // Give new Id to row
        $id = $this->find('count');
        $id++;

        $data = array(
            'id' => $id,
            'player_id' => $playerID,
            'name' => $newName,
            'coordinate_x' => -1,
            'coordinate_y' => -1,
            'level' => 1,
            'xp' => 0,
            'skill_sight' => 1,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3,  
            'next_action_time' => '0000-00-00 00:00:00',
            'guild_id' => NULL
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }
    
    public function viewAllChars($playerID)
    {
        $allChars = $this->find('all', array('conditions' => array('Fighter.player_id' => $playerID)));
        /*foreach($allChars as $key => $value)
        {
            echo $allChars[$key]['Fighter']['name'];
        }*/
        return $allChars;
    }

}
