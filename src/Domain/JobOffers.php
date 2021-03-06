<?php

namespace WF3\Domain;

use WF3\Domain\Employers;
use WF3\Domain\JobOffers;

class JobOffers
{
   
    private $id;
    private $title;
    private $company;
    private $city;
    private $date_offer;
    private $description;
    private $skills;
    private $advantages;
    private $contract;
    private $contractduration;
    private $timetable;
    private $recruitername;
    private $recruitercontact;
    private $users_id;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(!empty($id) AND is_numeric($id)){
        $this->id = $id;
        return $this;
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        if(!empty($title) AND is_string($title) AND mb_strlen($title) >= 2){
        $this->title = $title;
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
    
    
    
    
    
    
    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        if(!empty($city) AND is_string($city)){
        $this->city = $city;
        return $this;
        }
    }
    
    public function getDate_offer() {
        return $this->date_offer;
    }

    public function setDate_offer($date_offer) {
        if(!empty($date_offer) AND is_string($date_offer)){
        $this->date_offer = $date_offer;
        return $this;
        }
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if(!empty($description) AND is_string($description) AND mb_strlen($description) >= 3){
        $this->description = $description;
        return $this;
    }
    }

    public function getSkills() {
        return $this->skills;
    }

    public function setSkills($skills) {
        if(!empty($skills) AND is_string($skills)){
        $this->skills = $skills;
        return $this;
    }
    }
    
    public function getAdvantages() {
        return $this->advantages;
    }

    public function setAdvantages($advantages) {
        if(!empty($advantages) AND is_string($advantages) AND mb_strlen($advantages) >= 4){
        $this->advantages = $advantages;
        return $this;
    }
    }
    
    public function getContract()
    {
        return $this->contract;
    }

    public function setContract($contract) {
        
         if(!empty($contract) AND is_string($contract)){
        $this->contract = $contract;
        return $this;
    }
            }

    public function getContractduration() {
        return $this->contractduration;
    }
    
    public function setContractduration($contractduration) {
        if(!empty($contractduration) AND is_string($contractduration)){
        $this->contractduration = $contractduration;
        return $this;
    }
    }
    
    public function getTimetable() {
        return $this->timetable;
    }
    
    public function setTimetable($timetable) {
        if(!empty($timetable) AND is_string($timetable)){
        $this->timetable = $timetable;
        return $this;
    }
    }

    
    
    
    public function getRecruitername() {
        return $this->recruitername;
    }

    public function setRecruitername($recruitername) {
        if(!empty($recruitername) AND is_string($recruitername)){
        $this->recruitername = $recruitername;
        return $this;
        }
    }
    
    
    public function getRecruitercontact() {
        return $this->recruitercontact;
    }

    public function setRecruitercontact($recruitercontact) {
        if(!empty($recruitercontact) AND filter_var($recruitercontact, FILTER_VALIDATE_EMAIL)){
        $this->recruitercontact = $recruitercontact;
        return $this;
        }
    }
    
    
    

    public function getUsers_id()
    {
        return $this->users_id;
    }

    public function setUsers_id($users_id) {
        if(!empty($users_id) AND is_numeric($users_id)){
        $this->users_id = $users_id;
        return $this;
    }


    }
    }