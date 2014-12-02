<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Event', 'Surrounding', 'Tool');
    public $components = array('Session');

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'DataTable.DataTable'
    );

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
        $this->set('fighters', $this->Fighter->find('all'));
    }

    public function beforeFilter() {
        if (!$this->Session->read('Connected') AND $this->request->params['action'] != 'login') {
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
        } else {
            //echo "success variable status :";
            //echo $this->Session->read('Connected');
        }
        if (isset($this->request->data['deco'])) {
            $this->Session->delete('Connected');
            //$this->Session->destroy();
            //echo "déconnecté";
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
        }
        if ($this->request->params['action'] == 'character') {
            $this->set('raw', $this->Fighter->viewAllChars($this->Session->read('Connected')));
        }
        /* elseif($this->request->params['action']=='sight')
          {
          $this->redirect(array('controller'=>'Arena', 'action'=>'sight', 'sight', '#'=>'anchor'));
          } */
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
                $Email->send('Félicitations vous venez de vous inscrire au jeu WebArena ! Votre mot de passe est :' . $pwd);
            }
            if (isset($this->request->data['connexion'])) {
                $id = $this->Player->connexion($this->request->data['connexion']['email'], $this->request->data['connexion']['password']);
                if ($id) {
                    $this->Session->write('Connected', $id);
                    echo $id;
                    $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
                }
            }
        }
    }

    public function character() {

        if ($this->request->is('post')) {
            //if (isset($this->request->data['viewchar'])) {
            //$this->set('raw', $this->Fighter->viewAllChars($this->Session->read('Connected')));
            //$this->set('raw', $this->Fighter->findById($this->request->data['viewchar']['id']));
            //$id = $this->request->data['viewchar']['id'];
            //}
            if (isset($this->request->data['lvlup'])) {
                $eventArray = $this->Fighter->lvlUp($this->request->data['lvlup']['id'], $this->request->data['lvlup']['skillup']);
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash($eventArray["name"]);
                $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
            }

            if (isset($this->request->data['enter'])) {
                $id = $this->request->data['enter']['id'];
                if ($id) {
                    $this->Session->write('Enter', $id);
                    $this->Fighter->initialiseFighter($id);
                    $this->redirect(array('controller' => 'Arena', 'action' => 'sight'));
                }
            }

            if (isset($this->request->data['Upload'])) {
                $this->Fighter->fileUpload($this->request->data['Upload']['id']);
            }
            if (isset($this->request->data['createchar'])) {
                $eventArray = $this->Fighter->createCharacter($this->request->data['createchar']['name'], $this->Session->read('Connected'));
                $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                $this->Session->setFlash($eventArray["name"]);
                $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
            }
        }
    }

    public function diary() {
        $this->set('events', $this->Event->find('all'));
        $currentFighterId=$this->Session->read('Enter');
        if (!isset($currentFighterId)) {
            $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
        }
        else{
            $this->set('currentFighter', $this->Fighter->findById($currentFighterId));
        }
    }

    public function sight() {
        $arenaArray = $this->Surrounding->createSurroundings();
        $this->Tool->createTools($arenaArray);
        $currentFighterId = $this->Session->read('Enter');
        if (!isset($currentFighterId)) {
            $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
        }

        if ($this->request->is('post')) {
            if (isset($this->request->data['Fightermove'])) {
                $eventArray = $this->Fighter->doMove($currentFighterId, $this->request->data['Fightermove']['direction']);
                if ($eventArray["coordinate_x"] != NULL && $eventArray["coordinate_y"] != NULL) {
                    $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                    $this->Session->setFlash($eventArray["name"]);
                }
                if ($eventArray["fighterDeath"] == TRUE) {
                    $this->Session->write('Enter', NULL);
                    $this->redirect(array('controller' => 'Arena', 'action' => 'character'));
                }
            }
            if (isset($this->request->data['Fighteratk'])) {
                $eventArray = $this->Fighter->doAttack($currentFighterId, $this->request->data['Fighteratk']['direction']);
                if ($eventArray["coordinate_x"] != NULL && $eventArray["coordinate_y"] != NULL && $eventArray["name"] != NULL) {
                    $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                    $this->Session->setFlash('Une attaque a été réalisée.');

                    $eventArrayDead = $this->Fighter->eliminateDead();
                    if ($eventArrayDead["coordinate_x"] != NULL && $eventArrayDead["coordinate_y"] != NULL && $eventArrayDead["name"] != NULL) {
                        $this->Event->createEvent($eventArrayDead["coordinate_x"], $eventArrayDead["coordinate_y"], $eventArrayDead["date"], $eventArrayDead["name"]);
                        $this->Session->setFlash('Un combattant est mort.');
                    }
                }
            }
            if (isset($this->request->data['PickUp'])) {
                $eventArray = $this->Fighter->pickUpTool($currentFighterId);
                if ($eventArray["coordinate_x"] != NULL && $eventArray["coordinate_y"] != NULL) {
                    $this->Event->createEvent($eventArray["coordinate_x"], $eventArray["coordinate_y"], $eventArray["date"], $eventArray["name"]);
                    $this->Session->setFlash($eventArray["name"]);
                }
            }
            $this->redirect(array('controller' => 'Arena', 'action' => 'sight', 'sight', '#' => 'anchor'));
        }

        $this->set('tools', $this->Tool->find('all'));
        $this->set('fighters', $this->Fighter->find('all'));
        $this->set('currentFighter', $this->Fighter->findById($currentFighterId));
        $this->set('surroundings', $this->Surrounding->find('all'));
    }

    public function halloffame() {
        $this->set('raw', $this->Fighter->find('all'));
        $this->set('tab', $this->Event->query("SELECT day(date) As Jour,count(*) As NombreAtk FROM events AS Event where name like '%atta%' group by day(date) order by date;"));
        $this->set('tab2', $this->Event->query("SELECT day(date) As Jour,count(*) As NombreDep FROM events AS Event where name like '%déplace%' or name like '%moves%' group by day(date) order by date;"));
        $this->set('moy', $this->Fighter->calculatemoy());
    }

}
