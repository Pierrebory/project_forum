<?php
namespace WF3\DAO;

use WF3\Domain\Resetpass;


class ResetpassDAO extends DAO{

    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
    private $userDAO;
    //le setter associé
    public function setUserDAO(UsersDAO $userDAO){
        $this->userDAO = $userDAO;
    }


    public function selectReset($email){
        $result = $this->bdd->prepare('SELECT id, username FROM users WHERE email = :email');
        $result->bindValue(':email', $email);      
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC); 
/*        $row = $result->fetch(\PDO::FETCH_ASSOC);
        return $this->buildObject($row); */
    }


    public function insertReset($token, $user_id){
        $result = $this->bdd->prepare('INSERT INTO resetpass (token, user_id) VALUES (:token, :user_id)');      
        $result->bindValue(':token', $token); 
        $result->bindValue(':user_id', $user_id);        
        return $result->execute();    
    }

}