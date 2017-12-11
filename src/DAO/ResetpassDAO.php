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

    public function findToken($idUser){
        $result = $this->bdd->query('SELECT token, user_id FROM resetpass WHERE user_id = ' . $idUser);            
        return $result->fetch(\PDO::FETCH_ASSOC);   
    }   

    public function updatePassword($id, $token, $data){

               
/*        $update = $this->bdd->prepare('UPDATE users INNER JOIN resetpass ON users.id = resetpass.user_id SET password = :password, salt = :salt WHERE users.id = :id AND token = :token');

        $update->bindvalue(':password', $password);         
        $update->bindvalue(':salt', $salt); 
        $update->bindvalue(':token', $token);        
        $update->bindvalue(':id', $id, \PDO::PARAM_INT);
        
        if($update->execute()){
            return true;
            }
         
            return false;        */        
        if(is_object($data)){

           //on va transformer l'objet en tableau php        
           $dataArray = ['password' => $data->getPassword() , 'salt' => $data->getSalt()];
           $data = $dataArray;

        }

        $update = $this->bdd->prepare('UPDATE users INNER JOIN resetpass ON users.id = resetpass.user_id SET password = :password, salt = :salt WHERE users.id = :id AND token = :token');

        foreach($data as $key=>$value){
            //on va créer les lignes bindvalue correspondantes
            $update->bindvalue(':' .$key, strip_tags($value));
        }
        $update->bindvalue(':token', $token);        
        $update->bindvalue(':id', $id, \PDO::PARAM_INT);

        if($update->execute()){
            return true;
        }
         
        return false;          
    }

    public function deleteToken($idUser){
        $delete = $this->bdd->query('DELETE FROM resetpass WHERE user_id = ' . $idUser);
        return $delete->execute();
    }

}