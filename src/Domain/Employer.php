<?php

namespace WF3\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Employer implements UserInterface
{
   
    private $id;
    private $company;
    private $job;
    private $employer_id;
    


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(!empty($id) AND is_numeric($id)){
        $this->id = $id;
        return $this;
        }
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        if(!empty($company) AND is_string($company)){
        $this->company = $company;
        return $this;
        }
    }
    
    public function getJob() {
        return $this->firstname;
    }

    public function setJob($job) {
        if(!empty($job) AND is_string($job)){
        $this->job = $job;
        return $this;
    }
    }

    public function getEmployer_id() {
        return $this->employer_id;
    }

    public function setEmployer_id($employer_id) {
        if(!empty($employer_id) AND is_int($employer_id)){
        $this->employer_id = $employer_id;
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