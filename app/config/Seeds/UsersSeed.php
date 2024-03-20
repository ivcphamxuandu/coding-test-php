<?php
declare(strict_types=1);
use Cake\Auth\DefaultPasswordHasher;
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run() : void
    {
        $data = [
            [
                'id' => 5,
                'email' => 'user12@example.com',
                'password' => $this->hashPassword('1'),
                'created_at' => '2024-03-21 02:17:38',
                'updated_at' => '2024-03-21 02:17:44',
            ],
        ];

        $this->insert('users', $data);
    }

    protected function hashPassword($password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
