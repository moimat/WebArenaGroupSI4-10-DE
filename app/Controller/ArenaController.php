<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Event', 'Surrounding');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
       
        $this->set('myname', "Matthieu Boucon");
    }
    
   public function beforeFilter()
   {
       if (!$this->Session->read('Connected') AND $this->request->params['action'] != 'login')
       {
           $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
       }
       else
       {
            echo "success variable status :";
            echo $this->Session->read('Connected');
       }
   }

    public function login() {
        
        if ($this->request->is('post')) {
            if (isset($this->request->data['inscription'])) {
                $this->Player->newPlayer($this->request->data['inscription']['email'], $this->request->data['inscription']['password']);

            }
            if (isset($this->request->data['connexion'])) {
                $id=$this->Player->connexion($this->request->data['connexion']['email'], $this->request->data['connexion']['password']);
                if ($id) {
                    $this->Session->write('Connected',$id);
                    echo $id;  
                }
            }
            if (isset($this->request->data['deco'])){
                $this->Session->delete('Connected');
                echo "déconécté";
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

        if ($this->request->is('post')) {
            pr($this->request->data);
            if (isset($this->request->data['Fightermove'])) {
                $eventArray=$this->Fighter->doMove($this->request->data['Fightermove']['id'], $this->request->data['Fightermove']['direction']);
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash('Un déplacement a été réalisé');
            }
            if (isset($this->request->data['Fighteratk'])) {
                $eventArray=$this->Fighter->doAttack($this->request->data['Fighteratk']['id'], $this->request->data['Fighteratk']['direction']);
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash('Une attaque a été réalisée.');
            }
        }
        
        // Construct arena
        $this->Surrounding->createArena();
        $this->set('raw', $this->Fighter->findById(1));
        $this->set('surroundings', $this->Surrounding->find('all'));
        
    }

}
?>