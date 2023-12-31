<?php

include_once '../../config.php';
require_once '../../Model/agent.php';

class agentC{
    // CRUD
    public function afficher_agent(){
        $sql="SELECT * FROM agent" ;
        $db = config::getConnexion() ;
        try {
            $liste = $db->query($sql) ;
            return $liste ;
        }
        catch(Exception $e) {
            die('Erreur:' .$e->getMessage()) ;
        }
    }

    function ajouter_agent($agent){
        $sql="INSERT INTO agent (cin,nom,prenom,mail,motdepasse,role) 
				VALUES (:cin,:nom,:prenom,:mail,:motdepasse,:role)";
        $db = config::getConnexion();
        try{
            $query = $db->prepare($sql);

            $query->execute([
                'cin' => $agent->getcin(),
                'nom' => $agent->getnom(),
                'prenom' => $agent->getprenom(),
                'mail' => $agent->getmail(),
                'motdepasse' => $agent->getmotdepasse(),
                'role' => $agent->getrole()
                
            ]);
        }
        catch (Exception $e){
            echo 'Erreur: '.$e->getMessage();
        }
    }

    function supprimer_agent($cin){
        $sql="DELETE FROM agent WHERE cin= :cin";
        $db = config::getConnexion();
        $req=$db->prepare($sql);
        $req->bindValue(':cin',$cin);
        try{
            $req->execute();
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
    }

    function modifier_agent($agent, $cin){
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                "UPDATE agent SET 
						cin = :cin, 
						nom = :nom, 
						prenom = :prenom, 
						mail = :mail,
						motdepasse = :motdepasse, 
						role = :role 
						
					WHERE cin = :cin"
            );

            $query->execute([
                'cin' => $agent->getcin(),
                'nom' => $agent->getnom(),
                'prenom' => $agent->getprenom(),
                'mail' => $agent->getmail(),
                'motdepasse' => $agent->getmotdepasse(),
                'role' => $agent->getrole()
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function getagentbycin($cin)
    {
        $requete = "select * from agent where cin= '".$cin."'";
        $config = config::getConnexion();
        try {
            $querry = $config->prepare($requete);
            $querry->execute();
            $result = $querry->fetch();
            return $result ;
        } catch (PDOException $th) {
           echo $th->getMessage();
        }
    }




}
?>