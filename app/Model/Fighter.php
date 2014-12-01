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
        $posx = 0;
        $posy = 0;
        //@todo empêcher le joueur de sortir des limites du terrain
        //@todo empêcher le joueur de se déplacer sur une case occupée
        /// Observer la direction choisie, positions limites et persos ennemis du terrain
        if ($direction == 'north') {
            if ($joueur['Fighter']['coordinate_y'] != BORDER_NORTH && empty($this->find('first', array('conditions' =>
                                array('coordinate_x' => $joueur['Fighter']['coordinate_x'],
                                    'coordinate_y' => $joueur['Fighter']['coordinate_y'] - 1)))) == true) {
                $this->set('coordinate_y', $joueur['Fighter']['coordinate_y'] - 1);
                $posx = $joueur['Fighter']['coordinate_x'];
                $posy = $joueur['Fighter']['coordinate_y'] - 1;
            }
        } elseif ($direction == 'south') {
            if ($joueur['Fighter']['coordinate_y'] != BORDER_SOUTH && empty($this->find('first', array('conditions' =>
                                array('coordinate_x' => $joueur['Fighter']['coordinate_x'],
                                    'coordinate_y' => $joueur['Fighter']['coordinate_y'] + 1)))) == true) {
                $this->set('coordinate_y', $joueur['Fighter']['coordinate_y'] + 1);
                $posx = $joueur['Fighter']['coordinate_x'];
                $posy = $joueur['Fighter']['coordinate_y'] + 1;
            }
        } elseif ($direction == 'east') {
            if ($joueur['Fighter']['coordinate_x'] != BORDER_EAST && empty($this->find('first', array('conditions' =>
                                array('coordinate_x' => $joueur['Fighter']['coordinate_x'] + 1,
                                    'coordinate_y' => $joueur['Fighter']['coordinate_y'])))) == true) {
                $this->set('coordinate_x', $joueur['Fighter']['coordinate_x'] + 1);
                $posx = $joueur['Fighter']['coordinate_x'] + 1;
                $posy = $joueur['Fighter']['coordinate_y'];
            }
        } elseif ($direction == 'west') {
            if ($joueur['Fighter']['coordinate_x'] != BORDER_WEST && empty($this->find('first', array('conditions' =>
                                array('coordinate_x' => $joueur['Fighter']['coordinate_x'] - 1,
                                    'coordinate_y' => $joueur['Fighter']['coordinate_y'])))) == true) {
                $this->set('coordinate_x', $joueur['Fighter']['coordinate_x'] - 1);
                $posx = $joueur['Fighter']['coordinate_x'] - 1;
                $posy = $joueur['Fighter']['coordinate_y'];
            }
        }

        // Si le déplacement est possible
        if ($posx != 0 && $posy != 0) {
            $fighterMove = TRUE;
            $fighterDeath = FALSE;
            $surrounding = ClassRegistry::init('Surrounding');
            $surroundings = $surrounding->find('all');
            $surroundingArray = array();

            // Pour chaque obstacle environnant
            foreach ($surroundings as $key => $value) {

                // Regarder sa position
                $posSurroundingX = $surroundings[$key]['Surrounding']['coordinate_x'];
                $posSurroundingY = $surroundings[$key]['Surrounding']['coordinate_y'];

                // Regarder si le perso est sur la case de l'obstacle
                if ($posx == $posSurroundingX && $posy == $posSurroundingY) {
                    // Regarder si il s'agit d'un piege
                    if ($surroundings[$key]['Surrounding']['type'] == 'piege') {
                        $fighterMove = FALSE;
                        $fighterDeath = TRUE;
                        $this->killCharacter($fighterId);
                        $nameEvent = $joueur['Fighter']['name'] . ' tué par piège en: ' . $posx . ':' . $posy;
                    }
                    // Regarder s'il s'agit d'un monstre
                    elseif ($surroundings[$key]['Surrounding']['type'] == 'monstre') {
                        $fighterMove = FALSE;
                        $fighterDeath = TRUE;
                        $this->killCharacter($fighterId);
                        $nameEvent = $joueur['Fighter']['name'] . ' tué par monstre en: ' . $posx . ':' . $posy;
                    }
                    // S'il s'agit d'une colonne
                    else {
                        $fighterMove = FALSE;
                        $nameEvent = $joueur['Fighter']['name'] . ' est bloqué par une colonne en: ' . $posx . ':' . $posy;
                    }
                }
            }

            $dateNow = date("Y-m-d H:i:s");

            if ($fighterMove == TRUE) {
                $nameEvent = $joueur['Fighter']['name'] . ' se déplace en: ' . $posx . ':' . $posy;
            }

            $eventArray = array(
                "coordinate_x" => $posx,
                "coordinate_y" => $posy,
                "date" => $dateNow,
                "name" => $nameEvent,
                "fighterMove" => $fighterMove,
                "fighterDeath" => $fighterDeath
            );

            // sauver le déplacement du perso
            if ($fighterMove == TRUE) {
                $this->save();
            }

            return $eventArray;
        } else {
            return false;
        }
    }

    public function lvlUp($fighterId,$skill) {
        pr($skill);
        $data = $this->read(null, $fighterId);
        $name = $data['Fighter']['name'];
        $posx = $data['Fighter']['coordinate_x'];
        $posy = $data['Fighter']['coordinate_y'];
        $xp = $data['Fighter']['xp'];
        $level = $data['Fighter']['level'];
        if ($xp >= 4) {
            $level = $level + 1;
            $xp = $xp - 4;
            $this->set('level', $level);
            $this->set('xp', $xp);
            $this->save();
            // Create corresponding Event  
            $nameEvent = $name . ' est maintenant niveau ' . $data['Fighter']['level'];
            if($skill==0)
            {
                $this->set('current_health',$data['Fighter']['skill_health']);
                $this->set('skill_health',$data['Fighter']['skill_health']+3);
                $this->save();
            }
            elseif($skill==1)
            {
                $this->set('skill_sight',$data['Fighter']['skill_sight']+1);
                $this->save();
            }
            elseif($skill==2)
            {
                $this->set('skill_strength',$data['Fighter']['skill_strength']+1);
                $this->save();
            }
        } else {

            $nameEvent = 'Echec Level Up Personnage ' . $name;
        }

        // Create corresponding Event        
        $dateNow = date("Y-m-d H:i:s");

        $eventArray = array(
            "coordinate_x" => $posx,
            "coordinate_y" => $posy,
            "date" => $dateNow,
            "name" => $nameEvent);
        return $eventArray;
    }

    public function doAttack($fighterId, $direction) {
        // récupérer la position et fixer l'id de travail
        $joueur = $this->read(null, $fighterId);
        $liste = $this->find('all');
        $posx = $joueur['Fighter']['coordinate_x'];
        $posy = $joueur['Fighter']['coordinate_y'];
        $nameEvent = NULL;

        if ($direction == 'north') {
            $posx_cible = $posx;
            $posy_cible = $posy - 1;
        }
        if ($direction == 'south') {
            $posx_cible = $posx;
            $posy_cible = $posy + 1;
        }
        if ($direction == 'east') {
            $posx_cible = $posx + 1;
            $posy_cible = $posy;
        }
        if ($direction == 'west') {
            $posx_cible = $posx - 1;
            $posy_cible = $posy;
        }

        // Gestion attaque sur autre perso
        foreach ($liste as $key => $value) {
            if ($liste[$key]['Fighter']['coordinate_x'] == $posx_cible && $liste[$key]['Fighter']['coordinate_y'] == $posy_cible) {
                $idcible = $liste[$key]['Fighter']['id'];
                $cible = $this->read(null, $idcible);
                pr($cible);
                $rand = rand(1, 20);
                $seuil = $cible['Fighter']['level'] - $joueur['Fighter']['level'] + 10;
                $success = NULL;
                if ($rand > $seuil) {
                    pr('attaque reussie');
                    $success = 'succès';

                    $currentHealthCible = $cible['Fighter']['current_health'] - $joueur['Fighter']['skill_strength'];
                    $this->set('current_health', $currentHealthCible);

                    $this->save();
                    $joueur = $this->read(null, $fighterId);
                    $this->set('xp', $joueur['Fighter']['xp'] + 1);
                    pr('Xp augmentée');
                } else {
                    pr('attaque échouée');
                    $success = 'echec';
                }
                $nameEvent = $joueur['Fighter']['name'] . ' attaque ' . $cible['Fighter']['name'] . ':' . $success;
            }
        }

        // Gestion attaque sur monstre
        if ($nameEvent == NULL) {
            $surrounding = ClassRegistry::init('Surrounding');
            $surroundings = $surrounding->find('all');
            // Pour chaque obstacle environnant
            foreach ($surroundings as $key => $value) {

                // Regarder sa position
                $posSurroundingX = $surroundings[$key]['Surrounding']['coordinate_x'];
                $posSurroundingY = $surroundings[$key]['Surrounding']['coordinate_y'];

                // Regarder si l'obstacle est attaqué
                if ($posx_cible == $posSurroundingX && $posy_cible == $posSurroundingY) {

                    // Regarder s'il s'agit d'un monstre
                    if ($surroundings[$key]['Surrounding']['type'] == 'monstre') {
                        $surrounding->killMonster($surroundings[$key]['Surrounding']['id']);
                        $nameEvent = $joueur['Fighter']['name'] . ' tue le monstre en ' . $posSurroundingX . ':' . $posSurroundingY;
                    }
                }
            }
        }
        // Create corresponding Event        
        $dateNow = date("Y-m-d H:i:s");

        $eventArray = array(
            "coordinate_x" => $posx_cible,
            "coordinate_y" => $posy_cible,
            "date" => $dateNow,
            "name" => $nameEvent);
        // sauver la modif
        $this->save();
        //$cible_after = $this->read(null, $idcible);
        //pr($cible_after);
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
        $posx = -1;
        $posy = -1;
        $data = array(
            'id' => $id,
            'player_id' => $playerID,
            'name' => $newName,
            'coordinate_x' => $posx,
            'coordinate_y' => $posy,
            'level' => 1,
            'xp' => 0,
            'skill_sight' => 1,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3,
            'next_action_time' => '0000-00-00 00:00:00',
            'guild_id' => NULL
        );

        // Create corresponding Event        
        $dateNow = date("Y-m-d H:i:s");
        $nameEvent = $newName . ' créé';

        $eventArray = array(
            "coordinate_x" => $posx,
            "coordinate_y" => $posy,
            "date" => $dateNow,
            "name" => $nameEvent);

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);

        return $eventArray;
    }

    public function viewAllChars($playerID) {
        $allChars = $this->find('all', array('conditions' => array('Fighter.player_id' => $playerID)));
        /* foreach($allChars as $key => $value)
          {
          echo $allChars[$key]['Fighter']['name'];
          } */
        return $allChars;
    }

    public function pickUpTool($fighterId) {

        // Récupérer le tableau référençant l'ensemble des tools
        $arenaArray = array();
        $tool = ClassRegistry::init('Tool');
        $tools = $tool->find('all');
        $bonus = NULL;
        $type = NULL;

        // Find current fighter
        $fighter = $this->read(null, $fighterId);

        // Find his positions
        $posFighterX = $fighter['Fighter']['coordinate_x'];
        $posFighterY = $fighter['Fighter']['coordinate_y'];

        // Get tools positions
        foreach ($tools as $key => $value) {
            $posToolX = $tools[$key]['Tool']['coordinate_x'];
            $posToolY = $tools[$key]['Tool']['coordinate_y'];

            // If matching positions
            if ($posFighterX == $posToolX && $posFighterY == $posToolY) {

                // Set appropriate Bonus to fighter
                $bonus = $tools[$key]['Tool']['bonus'];
                $type = $tools[$key]['Tool']['type'];

                if ($type == 'sight') {
                    $this->set('skill_sight', $fighter['Fighter']['skill_sight'] + $bonus);
                    $this->save();
                } elseif ($type == 'strength') {
                    $this->set('skill_strength', $fighter['Fighter']['skill_strength'] + $bonus);
                    $this->save();
                } elseif ($type == 'health') {
                    $this->set('skill_health', $fighter['Fighter']['skill_health'] + $bonus);
                    $this->set('current_health', $fighter['Fighter']['current_health'] + $bonus);
                    $this->save();
                }

                $tool->deleteTool($tools[$key]['Tool']['id']);
            }
        }
        if ($bonus != NULL && $type != NULL) {


            // Create corresponding Event        
            $dateNow = date("Y-m-d H:i:s");
            $nameEvent = $fighter['Fighter']['name'] . ' a trouvé objet ' . $type . ' : +' . $bonus;

            $eventArray = array(
                "coordinate_x" => $posFighterX,
                "coordinate_y" => $posFighterY,
                "date" => $dateNow,
                "name" => $nameEvent);

            return $eventArray;
        } else {
            return FALSE;
        }
    }

    public function initialiseFighter($fighterId) {

        // Récupérer le tableau référençant l'ensemble des éléments de l'arène
        $arenaArray = array();
        $surrounding = ClassRegistry::init('Surrounding');
        $surroundings = $surrounding->find('all');

        $tool = ClassRegistry::init('Tool');
        $tools = $tool->find('all');

        $fighters = $this->find('all');

        // Boucle surroundings
        foreach ($surroundings as $key => $value) {
            // Get array of surroundings positions
            $posX = $surroundings[$key]['Surrounding']['coordinate_x'];
            $posY = $surroundings[$key]['Surrounding']['coordinate_y'];
            $element = array($posX, $posY);
            array_push($arenaArray, $element);
        }

        // Boucle tools
        foreach ($tools as $key => $value) {
            // Get array of tools positions
            $posX = $tools[$key]['Tool']['coordinate_x'];
            $posY = $tools[$key]['Tool']['coordinate_y'];
            $element = array($posX, $posY);
            array_push($arenaArray, $element);
        }

        // Boucle fighters
        foreach ($fighters as $key => $value) {
            // Get array of surroundings positions
            $posX = $fighters[$key]['Fighter']['coordinate_x'];
            $posY = $fighters[$key]['Fighter']['coordinate_y'];
            $element = array($posX, $posY);
            array_push($arenaArray, $element);
        }

        // Find current fighter
        $this->read(null, $fighterId);

        // Generate non conflicting random positions of fighters
  
        do {
            $randCoordX = rand(BORDER_WEST, BORDER_EAST);
            $randCoordY = rand(BORDER_NORTH, BORDER_SOUTH);
            $elementToAdd = array($randCoordX, $randCoordY);
        } while (in_array($elementToAdd, $arenaArray));

        // save fighter positions
        $this->set('coordinate_x', $randCoordX);
        $this->set('coordinate_y', $randCoordY);
        $this->save();
    }

    public function eliminateDead() {
        $fighters = $this->find('all');
        $fighterDeadId = NULL;

        foreach ($fighters as $key => $value) {
            if ($fighters[$key]['Fighter']['current_health'] <= 0) {

                // Create corresponding Event
                $nameDead = $fighters[$key]['Fighter']['name'];
                $posDeadX = $fighters[$key]['Fighter']['coordinate_x'];
                $posDeadY = $fighters[$key]['Fighter']['coordinate_y'];
                $dateNow = date("Y-m-d H:i:s");
                $nameEvent = $nameDead . ' est mort en ' . $posDeadX . ':' . $posDeadY;

                $eventArray = array(
                    "coordinate_x" => $posDeadX,
                    "coordinate_y" => $posDeadY,
                    "date" => $dateNow,
                    "name" => $nameEvent);
                
                $this->killCharacter($fighters[$key]['Fighter']['id']);

                return $eventArray;
            }
        }
    }

    public function killCharacter($fighterId) {
        $fighter = $this->read(null, $fighterId);
        pr($fighter);
        $this->delete($fighter['Fighter']['id']);
    }

    public function repositionActiveFighters() {
        $fighters = $this->find('all');

        foreach ($fighters as $key => $value) {
            if ($fighters[$key]['Fighter']['coordinate_x'] != -1 && $fighters[$key]['Fighter']['coordinate_y'] != -1) {
                $this->initialiseFighter($fighters[$key]['Fighter']['id']);
            }
        }
    }

}
