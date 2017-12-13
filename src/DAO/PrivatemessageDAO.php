<?php
namespace WF3\DAO;



class PrivatemessageDAO extends DAO{

	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    
    // update le password
    public function findConversations($id){
        $result = $this->bdd->prepare('SELECT m.*
from
  privatemessage m inner join (
    select
      least(sender_id, receiver_id) as user_1,
      greatest(sender_id, receiver_id) as user_2,
      max(id) as last_id,
      max(date_message) as last_timestamp
    from
      privatemessage where :id in (sender_id, receiver_id) 
    group by
      least(sender_id, receiver_id),
      greatest(sender_id, receiver_id)
  ) s on least(sender_id, receiver_id)=user_1
         and greatest(sender_id, receiver_id)=user_2
         and m.id = s.last_id order by date_message desc');
        $result->bindValue(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach($rows as $row){
            $users[] = $this->buildObject($row);
        }
        return $users;
    } 
       

    
    
    
    //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $article de la classe Article
    	$privatemessage = parent::buildObject($row);
    	//getAuthor() renvoie l'id de l'auteur de l'offre d'emploi
    	
        $idreceiver = $privatemessage->getReceiver_id();
        $idsender = $privatemessage->getSender_id();

    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	
        
        if(array_key_exists('receiver_id', $row) AND is_numeric($row['receiver_id'])){
        	$receiver = $this->userDAO->find($idreceiver);
            //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur   
            $privatemessage->setReceiver_id($receiver);
        }
        
        if(array_key_exists('sender_id', $row) AND is_numeric($row['sender_id'])){
            $sender = $this->userDAO->find($idsender);
            //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur   
            $privatemessage->setSender_id($sender);
        }        

        //on renvoie le message
        return $privatemessage;
    }
   

    
    
    
}

    