<?php

namespace WF3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use WF3\Domain\User;

class UsersDAO extends DAO implements UserProviderInterface
{
    
    public function setUsersDAO(UsersDAO $usersDAO){
        $this->UsersDAO = $userDAO;
    }
    
    //méthode pour afficher les avatars, prénoms, noms, ville et la promo de tous les anciens
    public function displayName(){
        $result = $this->bdd->query('SELECT avatar, firstname, username, city, promo FROM users INNER JOIN alumni ON alumni.alumni_id = users.id');
        return $result->fetchALL(\PDO::FETCH_ASSOC);
    }  

    
    
    //méthode pour afficher la fiche complète d'un ancien élève 
    public function displayAlumni($userid){
        $result = $this->bdd->prepare('SELECT users.id, username, firstname, phone, city, promo, presentation, skills, status, searchjob, searchtime, job, contract, companyname, linkedinurl, cv, sponsorship FROM users INNER JOIN alumni ON alumni.alumni_id = users.id WHERE users.id = :iduser');
        $result->bindValue(':iduser', $userid);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);   
    }

    //liste des emails
    public function findEmails(){
        $result = $this->bdd->query('SELECT email FROM users');
        return $result->fetchAll(\PDO::FETCH_ASSOC);   
    }    
    
    //liste des infos qui ne peuvent pas être en plusieurs exemplaires
    public function findUniqueValues(){
        $result = $this->bdd->query('SELECT username, email, phone FROM users');
        return $result->fetchAll(\PDO::FETCH_ASSOC);   
    }      

    //liste des infos qui ne peuvent pas être en plusieurs exemplaires
    public function findOtherValues($id){
        $result = $this->bdd->query('SELECT email, phone FROM users WHERE id != ' . $id);
        return $result->fetchAll(\PDO::FETCH_ASSOC);   
    }      

    // update les infos de l'utilisateur (sauf password et avatar) 
    public function updateUser($id, $data){

        if(is_object($data)){

           //on va transformer l'objet en tableau php        
           $dataArray = ['lastname' => $data->getLastname() , 'firstname' => $data->getFirstname(), 'email' => $data->getEmail(), 'phone' => $data->getPhone(), 'city' => $data->getCity()];
           $data = $dataArray;

        }

        $sql = 'UPDATE users SET ' ;
        
        foreach($data as $key=>$value){
        //on rajoute à la suite de sql avec .=
        $sql .= "$key = :$key, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .=  ' WHERE id = :id';

     
        
        $update = $this->bdd->prepare($sql);

        foreach($data as $key=>$value){
            //on va créer les lignes bindvalue correspondantes
            $update->bindvalue(':' .$key, strip_tags($value));
        }
        
        $update->bindvalue(':id', $id, \PDO::PARAM_INT);

        if($update->execute()){
            return true;
        }
         
        return false;          
    }

    // update le password
    public function updatePassword($id, $data){

        if(is_object($data)){
           //on va transformer l'objet en tableau php        
           $dataArray = ['password' => $data->getPassword() , 'salt' => $data->getSalt()];
           $data = $dataArray;

        }

        $update = $this->bdd->prepare('UPDATE users SET password = :password, salt = :salt WHERE id = :id');

        foreach($data as $key=>$value){
            //on va créer les lignes bindvalue correspondantes
            $update->bindvalue(':' .$key, strip_tags($value));
        }  
        $update->bindvalue(':id', $id, \PDO::PARAM_INT);

        if($update->execute()){
            return true;
        }
         
        return false;          
    }
         
    
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from " . $this->getTableName() . " where username=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'WF3\Domain\User' === $class;
    }

    
    
    public function getUsernameLike($username){
        $result = $this->bdd->prepare('SELECT * FROM users  WHERE username LIKE :username');
        $result->bindValue(':username', '%'.$username.'%');
        $result->execute();
        $rows =  $result->fetchALL(\PDO::FETCH_ASSOC);
        $user = [];
        foreach($rows as $row){
            $users = $this->buildobject($row);
            $user[$row['username']] = $users;
        }
        return $user;
    }

    
}