<?php
namespace App\Controller;

use Cake\Event\EventInterface;

class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
    }

    public function login()
    {
        // Handle user login logic
    }

    public function register()
    {
        // Handle user registration logic
    }
}
