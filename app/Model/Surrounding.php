<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Nicolas
 */

class Surrounding extends AppModel {

    private function createSurrounding($id, $type, $randCoordX, $randCoordY) {

        $data = array(
            'id' => $id,
            'type' => $type,
            'coordinate_x' => $randCoordX,
            'coordinate_y' => $randCoordY
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }

    public function createSurroundings() {

        // arena array
        $arenaArray = array();

        // Delete previous datatable surroundings
        $this->deleteAll(array('1 = 1'));

        // Repopulate surroundings datatable
        for ($id = 1; $id <= 45; $id++) {

            // Create appropriate surrounding
            if (($id % 3) == 0) {
                $type = 'colonne'; // Create one column for every 10 cells
            } elseif (($id % 3) == 1) {
                $type = 'monstre'; // Create one invisible monster for every 10 cells
            } else {
                $type = 'piege'; // Create one invisible trap for every 10 cells
            }
            
             // Generate non conflicting random positions of surroundings
            do {
                $randCoordX = rand(BORDER_WEST, BORDER_EAST);
                $randCoordY = rand(BORDER_NORTH, BORDER_SOUTH);
                $elementToAdd = array($randCoordX, $randCoordY);
            } while (in_array($elementToAdd, $arenaArray));
            
            
            // add surrounding positions to array
            array_push($arenaArray, $elementToAdd);

            // add surrounding element with type to database
            $this->createSurrounding($id, $type, $randCoordX, $randCoordY);
        }

        return $arenaArray;
    }
    
    public function killMonster($monsterId) {
        $monster = $this->findById($monsterId);
        $this->delete($monster['Surrounding']['id']);
    }
}
