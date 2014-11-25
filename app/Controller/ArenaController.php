<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Event');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
        $this->set('myname', "Matthieu Boucon");
    }

    public function login() {
        if ($this->request->is('post')) {
            if (isset($this->request->data['login'])) {
                $this->Player->newPlayer($this->request->data['login']['email'], $this->request->data['login']['password']);
            }
            if (isset($this->request->data['connexion'])) {
                if ($this->Player->connexion($this->request->data['connexion']['email'], $this->request->data['connexion']['password'])) {
                    //$this->Session->write('connected',id);
                    //echo $this->Session->write('connected',id);
                }
            }
        }
    }

    public function character() {
        if ($this->request->is('post')) {
            if (isset($this->request->data['viewchar'])) {
                $this->set('raw', $this->Fighter->findById($this->request->data['viewchar']['id']));
                $id = $this->request->data['viewchar']['id'];
            }
            if (isset($this->request->data['lvlup'])) {
                $this->Fighter->lvlUp($this->request->data['lvlup']['id']);
            }

            if (isset($this->request->data['Upload'])) {
                $this->Fighter->fileUpload($this->request->data['Upload']['id']);
            }
            if (isset($this->request->data['createchar'])) {
                $this->Fighter->createCharacter($this->request->data['createchar']['name']);
            }
        }
    }

    public function diary() {
        $this->set('raw', $this->Event->find());
    }

    public function sight() {
        $components = array('Session');

        if ($this->request->is('post')) {
            pr($this->request->data);
            if (isset($this->request->data['Fightermove'])) {
                $this->Fighter->doMove($this->request->data['Fightermove']['id'], $this->request->data['Fightermove']['direction']);
                $this->Session->setFlash('Un déplacement a été réalisé');
            }
            if (isset($this->request->data['Fighteratk'])) {
                $this->Fighter->doAttack($this->request->data['Fighteratk']['id'], $this->request->data['Fighteratk']['direction']);
                $this->Session->setFlash('Une attaque a été réalisée.');
            }
        }
        
        // Construct arena
        
        $this->set('raw', $this->Fighter->find('all'));
        
    }

}
?>