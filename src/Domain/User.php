<?php

namespace WF3\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
   
    private $id;
    private $username;
    private $firstname;
    private $email;
    private $password;
    private $salt;
    private $phone;
    private $city;
    private $avatar;
    private $role;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(!empty($id) AND is_numeric($id)){
        $this->id = $id;
        return $this;
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($name) {
        if(!empty($name) AND is_string($name) AND mb_strlen($name) >= 2){
        $this->username = $name;
        return $this;
        }
    }
    
    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        if(!empty($firstname) AND is_string($firstname) AND mb_strlen($firstname) >= 2){
        $this->firstname = $firstname;
        return $this;
    }
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if(!empty($email) AND is_string($email) AND filter_var($email, FILTER_VALIDATE_EMAIL)){
        $this->email = $email;
        return $this;
    }
    }
    
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        if(!empty($password) AND is_string($password) AND mb_strlen($password) >= 4){
        $this->password = $password;
        return $this;
    }
    }
    
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt) {
        
        
        $this->salt = $salt;
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }
    
    public function setPhone($phone) {
        if(!empty($phone) AND is_numeric($phone)){
        $this->phone = $phone;
        return $this;
    }
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setCity($city) {
        if(!empty($city) AND is_string($city) AND mb_strlen($city) >= 2){
        $this->city = $city;
        return $this;
    }
    }

    
    public function getAvatar() {
        return $this->avatar;
    }
    
    public function setAvatar($avatar) {
        //verife a voir
        $this->avatar = $avatar;
        return $this;
    }
    

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        if(!empty($role) AND is_string($role)){
        $this->role = $role;
        return $this;
    }
    }
    
    

    public function getRoles()
    {
        return array($this->getRole());
    }
    
        public function eraseCredentials() {
        // Nothing to do here
    }


}