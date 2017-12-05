<?php
namespace WF3\DAO;

class SubjectDAO extends DAO{
    
    public function getSubject(){
		$result = $this->bdd->query('SELECT title, message, date_message FROM forum_subjects INNER JOIN users ON forum_subjects.user_id = users.id');
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}
}