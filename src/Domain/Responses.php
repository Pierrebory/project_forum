<?php
namespace WF3\Domain;

class Responses{
    //déclaration des attributs
    private $id;
    private $message;
    private $date_message;
    private $date_edit;
    private $user_id;

    
    public function getId(){
        return $this->id;
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function getDate_message(){
        return $this->date_message;
    }
    
    public function getDate_edit(){
        return $this->date_edit;
    }
    
    public function getuser_id(){
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

    public function setMessage($message){
        if(!empty($message) AND is_string($message)){
            $this->message = $message; 
        }
    }

    public function setDate_message($date_message){
        if(!empty($date_message) AND is_string($date_message)){
            $this->date_message = $date_message; 
        }
    }

    public function setDate_edit($date_edit){
        if(!empty($date_edit) AND is_string($date_edit)){
            $this->date_edit = $date_edit; 
        }
    }

    public function setUser_id($user_id){  
        if(!empty($user_id) AND is_numeric($user_id)){
            $this->user_id = $user_id;         
    }
    
}
}