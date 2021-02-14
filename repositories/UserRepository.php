<?php

namespace Repositories;

include_once 'models/User.php';

use \Models\User;

class UserRepository
{
    private $userList = array();

    public function __construct()
    {
        $this->userList[] = new User('teste1', 'teste1@email.com', '01/02/1980', 'm');
        $this->userList[] = new User('teste2', 'teste2@email.com', '01/02/1980', 'f');
    }

    /**
     * Add new User in array
     *
     * @param User $user
     * @return void
     */
    public function create(User $user)
    {
        $this->userList[] = $user;
        return $this->userList;
    }

    /**
     * Delete User by index
     *
     * @param integer $index
     * @return void
     */
    public function delete(int $index)
    {
        unset($this->userList[$index - 1]);
        return $this->userList;
    }

    /**
     * Update User by index
     *
     * @param User $user
     * @param integer $index
     * @return void
     */
    public function update(User $user, int $index)
    {
        $user1 = $this->userList[$index - 1];
        $user1->name = $user->name;
        $user1->email = $user->email;
        $user1->birthday = $user->birthday;
        $user1->gender = $user->gender;
        $this->userList[$index - 1] = $user1;
        return $this->userList;
    }

    /**
     * Get User by index
     *
     * @param integer $index
     * @return void
     */
    public function get(int $index)
    {
        return $this->userList[$index - 1];
    }

    /**
     * Get all Users in arra
     *
     * @return void
     */
    public function list()
    {
        return $this->userList;
    }
}
