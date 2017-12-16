<?php
namespace WF3\DAO;



class PrivatemessageDAO extends DAO{

	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    
    // afficher le dernier message de chaque conversation
    public function findConversations($userId){
        $result = $this->bdd->prepare('SELECT m.*
        FROM
          privatemessage m INNER JOIN (
        SELECT
          least(sender_id, receiver_id) AS user_1,
          greatest(sender_id, receiver_id) AS user_2,
          max(id) AS last_id,
          max(date_message) AS last_timestamp,
          message_state
        FROM
          privatemessage
        WHERE 
          :id IN (sender_id, receiver_id) 
        GROUP BY
          least(sender_id, receiver_id),
          greatest(sender_id, receiver_id)
          ) s ON least(sender_id, receiver_id)=user_1
             AND greatest(sender_id, receiver_id)=user_2
             AND m.id = s.last_id ORDER BY date_message DESC');
        
        $result->bindValue(':id', $userId, \PDO::PARAM_INT);
        $result->execute();
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach($rows as $row){
            $users[] = $this->buildObject($row);
        }
        return $users;
    } 
       
    // afficher le dernier message de la conversation
    public function findConversation($userId, $contactId){
        $result = $this->bdd->prepare('SELECT m.*
        FROM
          privatemessage m INNER JOIN (
        SELECT
          least(sender_id, receiver_id) AS user_1,
          greatest(sender_id, receiver_id) AS user_2,
          id,
          date_message
        FROM
          privatemessage
        WHERE 
          :userId IN (sender_id, receiver_id) 
        AND
          :contactId IN (sender_id, receiver_id)         
        GROUP BY
          least(sender_id, receiver_id),
          greatest(sender_id, receiver_id)
          ) s ON least(sender_id, receiver_id)=user_1
             AND greatest(sender_id, receiver_id)=user_2
             ORDER BY date_message');
        
        $result->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $result->bindValue(':contactId', $contactId, \PDO::PARAM_INT);        
        $result->execute();
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $users = [];
        foreach($rows as $row){
            $users[] = $this->buildObject($row);
        }
        return $users;
    } 

    // afficher le dernier message de la conversation
    public function unreadMessages($userId){
        $result = $this->bdd->prepare('SELECT id FROM privatemessage WHERE receiver_id = :id AND message_state = 0');
        
        $result->bindValue(':id', $userId, \PDO::PARAM_INT);    
        $result->execute();
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        $counter = 0;
        foreach($rows as $row){
            $counter += 1;
        }
        return $counter;
    }     
    
 
    // afficher le dernier message de la conversation
    public function updateMessagesState($contactId){
        $result = $this->bdd->prepare('UPDATE privatemessage SET message_state = 1 WHERE sender_id = :id');       
        $result->bindValue(':id', $contactId, \PDO::PARAM_INT);    
        return $result->execute();
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

    