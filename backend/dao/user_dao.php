<?php

interface UserDao {

    public function saveUser($userVO);

    public function getUsers();

}