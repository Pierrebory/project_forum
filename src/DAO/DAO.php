<?php


namespace WF3\DAO;

class DAO implements DB{
    
    //contiendra l'instance de la connexion SQL
    //la visibilité protected rend l'attribut ou la méthode disponible à l'intérieur des classes filles
    //par contre, l'attribut ou la méthode protected n'est pas disponible à l'extérieur de la classe ou des classes filles
    
    protected $bdd;
    protected $tableName;
    protected $objectClassName;
    
    
    public function __construct($db, $tableName, $nomDeLaClasse){
        
        
        $this->bdd = $db; 
        //on injecte le nom de la table passé en paramètre lors de l'instanciation
        //dans l'attribut tablename
        $this->tableName = $tableName;
        //pareil avec le nom de la classe que l'on va utiliser pour créer des objets
        $this->objectClassName= $nomDeLaClasse;
        
    }
    
    public function buildObject(array $row){
        $class = $this->objectClassName;
        $object = new $class();
        foreach($row as $key=>$value){
            // à chaque tour de boucle
            //on crée le nom de la méthode grâce à la clé du tableau : setId, setTitle...
            $method = 'set'.ucfirst($key);
            //echo $method;
            // si cette méthode existe bien dans l'objet
            if(method_exists($object, $method)){
                //on l'exécute en lui passant en paramètre la valeur associée
                $object->$method($value);
            }
 
    }
         return $object;
    }
    
    
    public function getTableName(){
        return $this->tableName;
    }
    
    
    public function getDb(){
        return $this->bdd;
    }
    
    
    
    //lecture de la table
    
    public function findAll(){
        $resultat = $this->bdd->query(' SELECT * FROM ' . $this->tableName);
        $rows = $resultat->fetchAll(\PDO::FETCH_ASSOC);
        $objectsArray = [];
        foreach($rows as $row){
            $objectsArray[$row['id']] = $this->buildObject($row);
        }
        return $objectsArray;
        
    }
    

 
    
    public function find($id){
        $resultat = $this->bdd->prepare('SELECT * FROM ' . $this->tableName .  ' WHERE id = :id');
        $resultat->bindvalue(':id', $id);
        $resultat->execute();
        $row = $resultat->fetch(\PDO::FETCH_ASSOC);
        return $this->buildObject($row);
        
    }
    
    
    
    public function delete($id){
        if(!empty($id) AND is_numeric($id)){ 
        $resultat = $this->bdd->prepare('DELETE FROM ' . $this->tableName . ' WHERE id = :idAsupprimer');
        $resultat->bindvalue(':idAsupprimer', $id, \PDO::PARAM_INT);
        
        if($resultat->execute()){
            return true;
            }
        } 
            return false;
   
    }
 
    
    
    public function insert($data){
        
        if(is_object($data)){

           //on va transformer l'objet en tableau php        
           $dataArray = [];

           //on crée un tableau qui contient les noms des méthodes de notre objet
           $methods = get_class_methods($data);

           //je fais une boucle sur mes méthodes
           foreach($methods as $method){
               //si ma méthode est un setter (commence par set)
               //et que le getter correspondant existe
               if(preg_match('#^set#', $method) AND method_exists($data, str_replace('set', 'get', $method))){
                   //je récupère le getter
                   $getter = str_replace('set', 'get', $method);
                   //je rempli mon tableau avec en clé le nom de l'attribut (donc on enlève set et on met en minuscules)
                   //en valuer , le résultat de mon appel au getter
                   $dataArray[strtolower(str_replace('set', '', $method))] = $data->$getter();
               }
           }

           $data = $dataArray;

       }
        

        
        //création de la requête INSERT INTO nomdelatable
        $sql = 'INSERT INTO ' .$this->tableName . ' (';

        foreach($data as $key=>$value){
        //on rajoute à la suite de sql avec .=
        $sql .= $key . ', ';
        }
        //on supprime les deux derniers caractères (on veut supprimer la virgule)
        $sql = substr($sql, 0, -2);
        $sql .= ') VALUES (';

        // on écrit les marqueurs
        foreach($data as $key=>$value){
        //on rajoute à la suite de sql avec .=
        $sql .= ':' . $key . ', ';
        }
        $sql = substr($sql, 0, -2);
        //on ferme la parenthèse
        $sql .= ')';
        
    
        
        $add = $this->bdd->prepare($sql);
        foreach($data as $key=>$value){
            //on va créer les lignes bindvalue correspondantes
            $add->bindvalue(':' . $key, strip_tags($value));
        }
        if($add->execute()){
            return true;
            }
         
            return false;
    
}
    
    
    public function update($id, $data){
        
        if(is_object($data)){

           //on va transformer l'objet en tableau php        
           $dataArray = [];

           //on crée un tableau qui contient les noms des méthodes de notre objet
           $methods = get_class_methods($data);

           //je fais une boucle sur mes méthodes
           foreach($methods as $method){
               //si ma méthode est un setter (commence par set)
               //et que le getter correspondant existe
               if(preg_match('#^set#', $method) AND method_exists($data, str_replace('set', 'get', $method))){
                   //je récupère le getter
                   $getter = str_replace('set', 'get', $method);
                   //je rempli mon tableau avec en clé le nom de l'attribut (donc on enlève set et on met en minuscules)
                   //en valuer , le résultat de mon appel au getter
                   $dataArray[strtolower(str_replace('set', '', $method))] = $data->$getter();
               }
           }

           $data = $dataArray;

       }
        
        
        
        
        
        $sql = 'UPDATE ' . $this->tableName . ' SET ' ;
        
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
    
    
    
    
    
    
    
}
    
    
    
    
    
    