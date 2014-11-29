<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Event', 'Surrounding');
    public $components = array('Session');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {

        $this->set('myname', "Matthieu Boucon");
    }

    public function beforeFilter() {
        if (!$this->Session->read('Connected') AND $this->request->params['action'] != 'login') {
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
        } else {
            echo "success variable status :";
            echo $this->Session->read('Connected');
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if (isset($this->request->data['login'])) {
                $pwd = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$'), 0, 10);
                echo $pwd;
                $this->Player->newPlayer($this->request->data['login']['email'], $pwd);
                $Email = new CakeEmail('gmail');
                $Email->from(array('mat.boucon@gmail.com' => 'WebArena'));
                $Email->to($this->request->data['login']['email']);
                $Email->subject('Inscription WebArena');
                $Email->send('Félicitations vous venez de vous inscrire au jeu WebArena ! Votre mot de passe est :'.$pwd);
            }
            if (isset($this->request->data['connexion'])) {
                $id = $this->Player->connexion($this->request->data['connexion']['email'], $this->request->data['connexion']['password']);
                
                if ($id) {
                    $this->Session->write('Connected', $id);
                    
                    $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
                }
            }
            if (isset($this->request->data['deco'])) {
                //$this->Session->delete('Connected');
                //$this->Session->destroy();
                echo "déconnecté";
            }
        }
    }

    public function character() {

        if ($this->request->is('post')) {
            if (isset($this->request->data['viewchar'])) {
                $this->set('raw',$this->Fighter->viewAllChars($this->Session->read('Connected')));
                //$this->set('raw', $this->Fighter->findById($this->request->data['viewchar']['id']));
                //$id = $this->request->data['viewchar']['id'];
            }
            if (isset($this->request->data['lvlup'])) {
                $this->Fighter->lvlUp($this->request->data['lvlup']['id']);
            }

            if (isset($this->request->data['Upload'])) {
                $this->Fighter->fileUpload($this->request->data['Upload']['id']);
            }
            if (isset($this->request->data['createchar'])) {
                $this->Fighter->createCharacter($this->request->data['createchar']['id'],$this->request->data['createchar']['name'],$this->Session->read('Connected'));
            }
        }
    }

    public function diary() {
        $this->set('events', $this->Event->find('all'));
    }

    public function sight() {
        
        $components = array('Session');
        $idTest = 1;

        // Construct arena
        if ($this->Session->check('arenaCreated') == FALSE) {
            $arenaArray=$this->Surrounding->createArena();
            $this->Fighter->createFighters($arenaArray,$this->Fighter->find('all'));
            $this->Session->write('arenaCreated', TRUE);
        }

        if ($this->request->is('post')) {
            pr($this->request->data);
            if (isset($this->request->data['Fightermove'])) {
                $eventArray = $this->Fighter->doMove($idTest, $this->request->data['Fightermove']['direction']);
                if ($eventArray["coordinate_x"] != NULL && $eventArray["coordinate_y"] != NULL) {
                    $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                    $this->Session->setFlash('Un déplacement a été réalisé');
                }
            }
            if (isset($this->request->data['Fighteratk'])) {
                $eventArray = $this->Fighter->doAttack($idTest, $this->request->data['Fighteratk']['direction']);
                if ($eventArray["coordinate_x"] != NULL && $eventArray["coordinate_y"] != NULL) {
                    $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                    $this->Session->setFlash('Une attaque a été réalisée.');
                }
            }
        }

        $this->set('fighters', $this->Fighter->find('all'));
        $this->set('currentFighter', $this->Fighter->findById($idTest));
        $this->set('surroundings', $this->Surrounding->find('all'));
    }

}
