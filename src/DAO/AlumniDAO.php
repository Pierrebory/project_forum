<?php


namespace WF3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use WF3\Domain\User;




class AlumniDao extends DAO implements UserProviderInterface
{
    
    
    //méthode de recherche d'un ancien élève par son nom
    public function findAlumniByUsername($username){
        $result = $this->bdd->prepare('SELECT promo, presentation, skills, status, searchjob, searchtime, job, contract, companytype, wage, companyname, linkedinurl, cv, sponsorship  FROM alumni INNER JOIN users ON alumni.alumni_id = users.id WHERE $username LIKE :username');
        $result->bindValue(':username', '%' . $username . '%');
        $result->execute();
        return $result->fetchALL(\PDO::FETCH_ASSOC);
    }  
    
    
    
    
    
    
        


  
}


