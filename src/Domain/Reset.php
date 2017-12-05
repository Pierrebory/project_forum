<?php
namespace WF3\Domain;

class Reset{
    //déclaration des attributs
    private $id;
    private $token;
    private $user_id;
    

    
    public function getId(){
        return $this->id;
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function getUser_id(){
        return $this->user_id;
    }
    
    
    
        //setters
    public function setId($id){
        if(!empty($id) AND is_numeric($id)){
            $this->id = $id;
            return $this;
        }
        return false;
    }
    
    public function setToken($token){
        if(!empty($token) AND is_string($token)){
            $this->token = $token; 
        }
    }

    public function setUser_id($user_id){
        if(!empty($user_id) AND is_string($user_id)){
            $this->user_id = $user_id; 
        }
    }

   
}