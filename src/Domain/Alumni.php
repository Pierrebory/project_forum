<?php

namespace WF3\Domain;

class Alumni{
   
    private $id;
    private $promo;
    private $presentation;
    private $skills;
    private $status;
    private $searchjob;
    private $searchtime;
    private $job;
    private $contract;
    private $companytype;
    private $wage;
    private $companyname;
    private $linkedinurl;
    private $cv;
    private $sponsorship;
    private $alertjob;
    private $alumni_id;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(!empty($id) AND is_numeric($id)){
        $this->id = $id;
        return $this;
        }
    }

    public function getPromo() {
        return $this->promo;
    }

    public function setPromo($promo) {
        if(!empty($promo) AND is_numeric($promo)){
        $this->promo = $promo;
        return $this;
        }
    }
    
    public function getPresentation() {
        return $this->presentation;
    }

    public function setPresentation($presentation) {
        if(!empty($presentation) AND is_string($presentation) AND mb_strlen($presentation) >= 10 AND mb_strlen($presentation) <=200){
        $this->presentation = $presentation;
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
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        if(!empty($status) AND is_string($status)){
        $this->status = $status;
        return $this;
    }
    }
    
    public function getSearchjob()
    {
        return $this->searchjob;
    }

    public function setSearchjob($searchjob) {
        
        $this->searchjob = $searchjob;
        return $this;
    }

    public function getSearchtime() {
        return $this->searchtime;
    }
    
    public function setSearchtime($searchtime) {
        if(!empty($searchtime) AND is_string($searchtime)){
        $this->searchtime = $searchtime;
        return $this;
    }
    }
    
    public function getJob() {
        return $this->job;
    }
    
    public function setJob($job) {
        if(!empty($job) AND is_string($job)){
        $this->job = $job;
        return $this;
    }
    }

    
    public function getContract() {
        return $this->contract;
    }
    
    public function setContract($contract) {
        if(!empty($contract) AND is_string($contract)){
        $this->contract = $contract;
        return $this;
    }
    }
    

    public function getCompanytype()
    {
        return $this->companytype;
    }

    public function setCompanytype($companytype) {
        if(!empty($companytype) AND is_string($companytype)){
        $this->companytype = $companytype;
        return $this;
    }
    }
    
    public function getWage()
    {
        return $this->wage;
    }

    public function setWage($wage) {
        if(!empty($wage) AND is_string($wage)){
        $this->wage = $wage;
        return $this;
    }
    }
        
        public function getCompanyname()
    {
        return $this->companyname;
    }

    public function setCompanyname($companyname) {
        if(!empty($companyname) AND is_string($companyname)){
        $this->companyname = $companyname;
        return $this;
    }
    }
        
        public function getLinkedinurl()
    {
        return $this->linkedinurl;
    }

    public function setLinkedinurl($linkedinurl) {
        if(!empty($linkedinurl) AND is_string($linkedinurl)){
        $this->linkedinurl = $linkedinurl;
        return $this;
    }
    }
        
        public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv) {
        if(!empty($cv) AND is_string($cv) AND filter_var($cv, FILTER_VALIDATE_URL)){
        $this->cv = $cv;
        return $this;
    }
    }
        public function getSponsorship()
    {
        return $this->sponsorship;
    }

    public function setSponsorship($sponsorship) {
        if(!empty($sponsorship)){
        $this->sponsorship = $sponsorship;
        return $this;
    }
    }
        
        public function getAlertjob()
    {
        return $this->alertjob;
    }

    public function setAlertjob($alertjob) {
        if(!empty($alertjob)){
        $this->alertjob = $alertjob;
        return $this;
    }
    }
        
        public function getAlumni_id()
    {
        return $this->alumni_id;
    }

    public function setAlumni_id($alumni_id) {
        if(!empty($alumni_id) AND is_numeric($alumni_id)){
        $this->alumni_id = $alumni_id;
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