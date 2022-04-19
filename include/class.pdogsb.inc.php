<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsb';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, visiteur.statut as statut from visiteur 
		where visiteur.login='$login' and visiteur.mdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant','')";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
	
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
	

/**
*Permet la sélection des mois dans la fiche frais
*pour les mettre dans une liste pour sélectionner les fiche d'un visiteur suivant le mois
*@return un tableau avec les mois dans la table fiche frais
*/
	public function getLesMois(){
		$req = "select fichefrais.mois as mois from  fichefrais order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
					"mois"=>"$mois",
					"numAnnee"  => "$numAnnee",
					"numMois"  => "$numMois"
			);
			$laLigne = $res->fetch();
		}
		return $lesMois;
	}
	
/**
* Selectionne tout les champs de la table fiche frais suivant la variable mois
* @return un tableau contenant toutes les valeurs de la table fiche frais pour le mois donné
*/
	public function getLesFichesFrais($mois){
		$req = "SELECT * FROM fichefrais INNER JOIN visiteur ON idVisiteur=id WHERE mois=".$mois;
		$res = PdoGsb::$monPdo->query($req);
		$lesFiches = array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$id = $laLigne['id'];
			$nom = $laLigne['nom'];
			$prenom = $laLigne['prenom'];
			$montant = $laLigne['montantValide'];
			$lesFiches["$id"]=array(
					"id"=>"$id",
					"nom"  => "$nom",
					"prenom"  => "$prenom",
					"montantValide" => "$montant"
			);
			$laLigne = $res->fetch();
		}
		return $lesFiches;
	}
	/**
* Recupère toute les fiches d'un visiteurs qui sont mise en paiement (MP)

* @param $visiteur qui est id dans la BDD
*/
	
	public function getLesFichesFraisRemboursement($visiteur){
		$req = "SELECT * FROM fichefrais INNER JOIN visiteur ON idVisiteur=id WHERE id='".$visiteur."' AND idEtat='MP'";
		$res = PdoGsb::$monPdo->query ( $req );
		$lesFiches = $res->fetchAll ();
		return $lesFiches;
	}
	
/**
* Recupère tous les visiteurs ayant une fiche de frais mise en paiement (MP)
*@return les visiteurs possédant une fiche de frais MP
*/	
	
	public function getLesVisiteursRemboursement(){
		$req = "SELECT DISTINCT(id),nom,prenom FROM fichefrais INNER JOIN visiteur ON idVisiteur=id WHERE idEtat='MP'";
		$res = PdoGsb::$monPdo->query ( $req );
		$lesFiches = $res->fetchAll ();
		return $lesFiches;
	}
	
/**
* Modifie idEtat d'une fiche défini par son visiteur et son moi (passage de MP en RB)
	
* @param $visiteur
* @param $mois sous la forme aaaamm
*/
	
	public function modificationRemboursement($visiteur, $mois){
		$req = "UPDATE fichefrais SET idEtat='RB' WHERE idVisiteur='".$visiteur."' AND mois='".$mois."'";
		PdoGsb::$monPdo->exec($req);
	}
	
	/**
	 * retourne les informations des fiches de frais des visiteur pour lequel le paiement n'a pas encore été fait
	 *
	 * @return l'id,le nom,le prénom, le mois et  le montant de frais pour chaque personne
	 *
	 */
	public function getlesFichesdeFrais() {
		$req = " select  idVisiteur, nom, prenom, mois, montantValide
			from (visiteur v inner join FicheFrais f on v.id=f.idVisiteur) inner join etat e on e.id=f.idEtat
			where idEtat = 'VA' ";
		$res = PdoGsb::$monPdo->query ( $req );
		$lesResultats = $res->fetchAll ();
		//var_dump($lesResultats);
		return $lesResultats;
	}
	/**
	 * param $idVisiteur est l'identifiant du visiteur
	 * Met à jour la table FicheFrais en modifiant la dernière date de modification et l'état en passant de VA à MB
	 */
	public function majFicheFrais() {
		$req1 = " update fichefrais set dateModif = NOW() ,idEtat = 'MP'
			where idEtat = 'VA' ";
		$req1 = " update fichefrais set dateModif = NOW() ,idEtat = 'MP' where idEtat='VA'";
		PdoGsb::$monPdo->exec ( $req1 );
	}

/**
* Cette fonction permet de sélectionner tout les visiteur possédant une fiche frais qui est non valide (VA)
* Retourne donc les caractéristique des visiteurs
*/
	public function getLesVisiteurs(){
		$req="select * from visiteur where visiteur.id IN (select fichefrais.idVisiteur from fichefrais where fichefrais.idVisiteur=visiteur.id AND idEtat='CR')";
		$res = PdoGsb::$monPdo->query ( $req );
		$lesResultats = $res->fetchAll ();
		return $lesResultats;
	}
	
/**
* Cette fonction permet de mettre à jour la table lignefraisforfait (Kilomètre, Etape, Nuit Hotel et repas)
* qui récupère toutes les informations des frais suivant le visiteur
*@param $idVisiteur
*@param $etp qui est le nombre de frais étape
*@param $km qui est le nombre de frais kilomètrique
*@param $nui qui est le nombre de frais de nuitée à l'hotel
*@param $rep qui est le nombre de frais de repas
*/
	public function majInfoFraisForfaitise($idVisiteur, $etp, $km, $nui, $rep){
		$req1="update lignefraisforfait set quantite='$etp' where idVisiteur='$idVisiteur' AND idFraisForfait='ETP'";
		PdoGsb::$monPdo->query ( $req1 );		
		$req2="update lignefraisforfait set quantite='$km' where idVisiteur='$idVisiteur' AND idFraisForfait='KM'";
		PdoGsb::$monPdo->query ( $req2 );
		$req3="update lignefraisforfait set quantite='$nui' where idVisiteur='$idVisiteur' AND idFraisForfait='NUI'";
		PdoGsb::$monPdo->query ( $req3 );
		$req4="update lignefraisforfait set quantite='$rep' where idVisiteur='$idVisiteur' AND idFraisForfait='REP'";
		PdoGsb::$monPdo->query ( $req4 );
		//total du tarif avec la valeur des hors forfait
		$total=($etp * 110.00)+($km * 0.62)+($nui * 80.00)+($rep * 25.00);
		$req5="update fichefrais set montantValide='$total' where idVisiteur='$idVisiteur'";
		PdoGsb::$monPdo->query ( $req5 );
	}
	
/**
* Cette fonction a pour but de refuser un frais hors forfait
* En cliquant sur refuser, le libellé tronquer à le mot REFUSER qui se rajoute devant pour montrer qu'il est bien REFUSER 
* et l'état du frais change en REF
*@param $idFrais qui est le numéro de l'id du frais hors forfait
*/	
	public function refuserFrais($idFrais){
		$req="SELECT * from lignefraishorsforfait where id='$idFrais'";
		$res = PdoGsb::$monPdo->query ( $req );
		$leResultat=$res->fetchAll();
		foreach ($leResultat as $unResultat){
			$libelle=$unResultat['libelle'];
		}
		$libelle='REFUSER '.$libelle;
		$libelle=substr($libelle,0,100);
		$req="UPDATE lignefraishorsforfait set libelle = '$libelle', etat='REF' where id='$idFrais' AND etat NOT IN ('REF')";
		$res = PdoGsb::$monPdo->query ( $req );
	}
	
/**
* Cette fonction valide la fiche de frais pour un visiteur et un mois donnés
* Elle met donc à jour la fiche de rais en VA
*@param $idFicheVisiteur qui récupère l'id de la fiche du visiteur
*@param $leMois qui correspond au mois donné
*/
	public function validerFiche($idFicheVisiteur,$leMois){
		$date=date("Y-m-d");
		$req="UPDATE fichefrais set dateModif = '$date', idEtat = 'VA' where idVisiteur='$idFicheVisiteur' AND mois='$leMois'";
		$res = PdoGsb::$monPdo->query ( $req );
	}
	
/**
* Cette fonction permet de repporter des frais au mois suivant
* Selection des informations de la ligne de frais hors forfait suivant l'id du hors forfait
* Supprime la ligne hors forfait suivant l'id du frais
*@param $idFrais correspondant à l'id du frais de la table lignefraishorsforfait
* @return le resultat de la requete select ($req executé en premier)
*/
	public function reporterFrais($idFrais){		
		$req="select * from lignefraishorsforfait where id='$idFrais'";
		$res = PdoGsb::$monPdo->query ( $req );
		$leResultat=$res->fetchAll();
		//fonctionne
		$req="delete from lignefraishorsforfait where id='$idFrais'";
		$res = PdoGsb::$monPdo->query ( $req );
		return $leResultat;
	}	
}
?>