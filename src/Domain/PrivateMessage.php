<?php
namespace WF3\Domain;

class PrivateMessage{
    //déclaration des attributs
    private $id;
    private $sender_id;
    private $receiver_id;
    private $message;
    private $date_message;
    private $message_state;
  

    
    public function getId(){
        return $this->id;
    }
    
    public function getSender_id(){
        return $this->sender_id;
    }
    
    public function getReceiver_id(){
        return $this->receiver_id;
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function getDate_message(){
        return $this->date_message;
    }
    
    public function getMessage_state(){
        return $this->message_state;
    }    

    
        //setters
    public function setId($id){
        if(!empty($id) AND is_numeric($id)){
            $this->id = $id;
            return $this;
        }
        return false;
    }

    
    public function setSender_id($sender_id){
        if(!empty($sender_id)){
            $this->sender_id = $sender_id; 
        }
    }
    
    public function setReceiver_id($receiver_id){
        if(!empty($receiver_id)){
            $this->receiver_id = $receiver_id; 
        }
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

    public function setMessage_state($message_state){
        if(!empty($message_state) AND is_numeric($message_state)){
            $this->message_state = $message_state; 
        }
    }
    
}
