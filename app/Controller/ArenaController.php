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

        if (!$this->Session->check('Connected') AND $this->request->params['action'] != 'login')
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
    }

    public function login() {

        if ($this->request->is('post')) {
            if (isset($this->request->data['login'])) {
                $this->Player->newPlayer($this->request->data['login']['email'], $this->request->data['login']['password']);
                $Email = new CakeEmail('gmail');
                $Email->from(array('mat.boucon@gmail.com' => 'WebArena'));
                $Email->to($this->request->data['login']['email']);
                $Email->subject('Inscription WebArena');
                $Email->send('Félicitations vous venez de vous inscrire au jeu WebArena !');
            }
            if (isset($this->request->data['connexion'])) {

                if ($this->Session->check('Connected')) {
                    if ($this->Session->delete('Connected'))
                        echo 'vous êtes déconnecté';
                }

                else {
                    $success = $this->Player->connexion($this->request->data['connexion']['email'], $this->request->data['connexion']['password']);
                    if ($success['success']) {

                        $this->Session->write('Connected', $success['id']);
                        echo $this->Session->read('Connected');
                    }
                }
            }
            if (isset($this->request->data['deco'])) {
                $this->Session->delete('Connected');
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
        $this->set('events', $this->Event->find('all'));
    }

    public function sight() {

        $components = array('Session');
        $idTest = 1;

        if ($this->request->is('post')) {
            pr($this->request->data);
            if (isset($this->request->data['Fightermove'])) {
                $eventArray = $this->Fighter->doMove($idTest, $this->request->data['Fightermove']['direction']);
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash('Un déplacement a été réalisé');
            }
            if (isset($this->request->data['Fighteratk'])) {
                $eventArray = $this->Fighter->doAttack($idTest, $this->request->data['Fighteratk']['direction']);
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash('Une attaque a été réalisée.');
            }
        }

        // Construct arena
        $this->Surrounding->createArena();
        $this->set('raw', $this->Fighter->findById($idTest));
        $this->set('surroundings', $this->Surrounding->find('all'));
    }

}
