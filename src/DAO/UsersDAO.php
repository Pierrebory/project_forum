<?php

namespace WF3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use WF3\Domain\User;

class UsersDAO extends DAO implements UserProviderInterface
{
    

    
    //méthode pour afficher les avatars, prénoms, noms, ville et la promo de tous les anciens
    public function displayName(){
        $result = $this->bdd->query('SELECT avatar, firstname, username, city, promo FROM users INNER JOIN alumni ON alumni.alumni_id = users.id');
        return $result->fetchALL(\PDO::FETCH_ASSOC);
    }  

    
    
    //méthode pour afficher la fiche complète d'un ancien élève 
    public function displayAlumni($userid){
        $result = $this->bdd->prepare('SELECT users.id AS userid, avatar, firstname, username, phone, city, promo, presentation, skills, status, searchjob, searchtime, job, contract, companyname, linkedinurl, cv, sponsorship  INNER JOIN alumni ON alumni.alumni_id = users.id WHERE userid = :iduser');
        $result->bindValue(':iduser', $userid);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);   
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

    

    
}