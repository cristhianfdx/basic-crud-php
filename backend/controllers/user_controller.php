<?php
require '../dao/user_dao_impl.php';
require '../vo/user_vo.php';

class UserController
{

    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDaoImpl();
    }

    public function user_get()
    {
        $this->userDao->getUsers();
    }

    public function user_post($user)
    {
        $userVO = new UserVO();
        $userVO->setName($user['name']);
        $userVO->setEmail($user['email']);

        $this->userDao->saveUser($userVO);
    }
}
