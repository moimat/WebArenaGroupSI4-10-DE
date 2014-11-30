<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Nicolas
 */
App::uses('AppModel', 'Model');
class Tool extends AppModel {

    private function createTool($id, $type, $bonus, $randCoordX, $randCoordY) {

        $data = array(
            'id' => $id,
            'type' => $type,
            'bonus' => $bonus,
            'coordinate_x' => $randCoordX,
            'coordinate_y' => $randCoordY
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        $this->save($data);
    }

    public function createTools($arenaArray) {

        // arena array
        $arenaArray = array();

        // Delete previous datatable tools
        $this->deleteAll(array('1 = 1'));

        // Repopulate tools datatable
        for ($id = 1; $id <= 9; $id++) {

            // Create appropriate surrounding
            if (($id % 3) == 0) {
                $type = 'sight'; // Create one column for every 10 cells
                $bonus=$id/3;
            } elseif (($id % 3) == 1) {
                $type = 'strength'; // Create one invisible monster for every 10 cells
                $bonus=$id/3+1;
            } else {
                $type = 'health'; // Create one invisible trap for every 10 cells
                $bonus=$id/3;
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
            $this->createTool($id, $type, $bonus, $randCoordX, $randCoordY);
        }

        return $arenaArray;
    }
    
    public function pickUpTool($toolId) {
        $tool = $this->findById($toolId);
        $this->delete($tool['Tool']['id']);
    }
}
