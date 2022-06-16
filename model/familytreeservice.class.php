<?php

require __SITE_PATH . '/vendor/' . 'autoload.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

class FamilyTreeService
{
	private $client = null;
	public function __construct() {
		$this->client = ClientBuilder::create()
				->withDriver('aura', 'neo4j+s://0df6d930.databases.neo4j.io', Authenticate::basic('neo4j', 'lv5PdN16PMP3JdPnaRMImoYN7E-VgJrQAZyIL3NqnJs'))
				->withDefaultDriver('aura')
				->build();
	}

	/*-------------------- CRUD operacije nad ljudima --------------------*/
	function getAllPersons() {

		$results = $this->client->run(
			'MATCH (p:Person)' .
			'RETURN p'
		);
		
		$all = [];
		foreach($results as $result) {
			$node = $result->get('p');
			$all[] = [
				'personID' => $node->getProperty('personID'),
				'firstName' => $node->getProperty('firstName'),
				'lastName' => $node->getProperty('lastName'),
				'gender' => $node->getProperty('gender'),
				'birthDate' => $node->getProperty('birthDate')
			];
		}

		return $all;
	}	

	function getPersonByID($id) {

		$results = $this->client->run(
			'MATCH (p:Person {personID: "' . $id . '"})' .
			'RETURN p'
		);
		
		if($results->count() === 0) exit("Ne postoji osoba s personID=" . $id);
		if($results->count() > 1) echo("Našao više od jednog čvora s personID=" . $id);

		$node = $results[0]->get('p');
		$one = [
			'personID' => $node->getProperty('personID'),
			'firstName' => $node->getProperty('firstName'),
			'lastName' => $node->getProperty('lastName'),
			'gender' => $node->getProperty('gender'),
			'birthDate' => $node->getProperty('birthDate')
		];

		return $one;
	}

	function getPersonByName($name, $surname) {

		$results = $this->client->run(
			'MATCH (p:Person)' .
			'WHERE TOLOWER(p.firstName) CONTAINS TOLOWER("' . $name . '")' . 
			'AND TOLOWER(p.lastName) CONTAINS TOLOWER("' . $surname . '")' .
			'RETURN p'
		);
		
		$all = [];
		foreach($results as $result) {
			$node = $result->get('p');
			$all[] = [
				'personID' => $node->getProperty('personID'),
				'firstName' => $node->getProperty('firstName'),
				'lastName' => $node->getProperty('lastName'),
				'gender' => $node->getProperty('gender'),
				'birthDate' => $node->getProperty('birthDate')
			];
		}

		return $all;
	}

	function createPerson($firstName, $lastName, $birthDate, $gender) {

		$results = $this->client->run(
			'MATCH (:Person)' . 
        	'WITH COUNT(*) + 1 AS c ' .
        	'CREATE (p:Person {' .
				'personID: "[I" + c + "]",' .
				'firstName: "' . $firstName . '",' .
				'lastName: "' . $lastName . '",' .
				'birthDate: "' . $birthDate . '",' .
				'gender: "' . $gender . '"})' .
			'RETURN p'
		);

		if($results->count() === 0) exit("Ne postoji osoba s personID=" . $id);
		if($results->count() > 1) echo("Našao više od jednog čvora s personID=" . $id);

		$node = $results[0]->get('p');
		$one = [
			'personID' => $node->getProperty('personID'),
			'firstName' => $node->getProperty('firstName'),
			'lastName' => $node->getProperty('lastName'),
			'gender' => $node->getProperty('gender'),
			'birthDate' => $node->getProperty('birthDate')
		];

		return $one;
	}

	function deletePerson($id) {

		$results = $this->client->run(
			'MATCH (p:Person {personID: "' . $id . '"})' .
			'DETACH DELETE p'
		);

		return 'success';
	}

	function modifyPerson($personID, $firstName, $lastName, $birthDate, $gender) {

		$results = $this->client->run(
			'MATCH (p:Person {personID: "' . $id . '"})' . 
			'SET firstName = "' . $firstName . '",' .
				'lastName = "' . $lastName . '",' .
				'birthDate = "' . $birthDate . '",' .
				'gender = "' . $gender . '" ' .
			'RETURN p'
		);
			
		if($results->count() === 0) exit("Ne postoji osoba s personID=" . $id);
		if($results->count() > 1) echo("Našao više od jednog čvora s personID=" . $id);

		$node = $results[0]->get('p');
		$one = [
			'personID' => $node->getProperty('personID'),
			'firstName' => $node->getProperty('firstName'),
			'lastName' => $node->getProperty('lastName'),
			'gender' => $node->getProperty('gender'),
			'birthDate' => $node->getProperty('birthDate')
		];

		return $one;
	}

	/*-------------------- pretraživanje šestog koljena --------------------*/
	function findSharedAncestor($id1, $id2) {

		$results = $this->client->run(
			'MATCH path = (:Person {personID: "' . $id1 . '"})' .
				'<-[:OFFSPRING*..6]-(ancestor)-[:OFFSPRING*..6]->' . 
				'(:Person {personID: "' . $id2 . '"})' .
			'RETURN ancestor' . 
			'ORDER BY length(path)' . 
			'LIMIT 1'
		);

		if($results->count() === 0) exit("Ne postoji zajednički predak");
		if($results->count() > 1) echo("Našao više od jednog na neku foru");

		$node = $results[0]->get('ancestor');
		$one = [
			'personID' => $node->getProperty('personID'),
			'firstName' => $node->getProperty('firstName'),
			'lastName' => $node->getProperty('lastName'),
			'gender' => $node->getProperty('gender'),
			'birthDate' => $node->getProperty('birthDate')
		];

		return $one;
	}

	/*-------------------- CRUD operacije nad vezama PARTNER --------------------*/
	function findPartners($id) { // popis ljudi koji su u vezi partner s osobom čiji personID je $id

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id . '"})-[:PARTNER]-(p:Person)' .
			'RETURN p'
		);
		
		$all = [];
		foreach($results as $result) {
			$node = $result->get('p');
			$all[] = [
				'personID' => $node->getProperty('personID'),
				'firstName' => $node->getProperty('firstName'),
				'lastName' => $node->getProperty('lastName'),
				'gender' => $node->getProperty('gender'),
				'birthDate' => $node->getProperty('birthDate')
			];
		}

		return $all;
	}

	function findPartnerRelationships($id1, $id2) {

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id1 . '"})-[p:PARTNER]-(:Person {personID: "' . $id2 . '"})' .
			'RETURN p'
		);
		
		if($results->count() === 0) exit("Ne postoji partnerska veza između " . $id1 . " i " . $id2);
		if($results->count() > 1) echo("Našao više od jedne veze");

		$node = $results[0]->get('p');
		$one = ['married' => $node->getProperty('married')];

		return $one;
	}

	function modifyPartnerRelationship($id1, $id2, $married) {

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id1 . '"})-[p:PARTNER]-(:Person {personID: "' . $id2 . '"})' .
			'SET p.married = ' . $married .	
			'RETURN p'
		);
		
		if($results->count() === 0) exit("Ne postoji partnerska veza između " . $id1 . " i " . $id2);
		if($results->count() > 1) echo("Našao više od jedne veze");

		$node = $results[0]->get('p');
		$one = ['married' => $node->getProperty('married')];

		return $one;
	}	

	function deletePartnerRelationship($id1, $id2) {

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id1 . '"})-[p:PARTNER]-(:Person {personID: "' . $id2 . '"})' .
			'DELETE p'
		);
	}

	function createPartnerRelationship($id1, $id2, $married) {
		$client = DB::getConnection();

		$results = $client->run(
			'MATCH (p1:Person {personID: "' . $id1 . '"}), (p2:Person {personID: "' . $id2 . '"})' .
			'CREATE (p1)-[rel:PARTNER {married: ' . $married . '}]->(p2)' .
			'RETURN rel'
		);
		
		if($results->count() === 0) exit("Nije stvorena partnerska veza između " . $id1 . " i " . $id2);
		if($results->count() > 1) echo("Našao više od jedne veze");

		$node = $results[0]->get('rel');
		$one = ['married' => $node->getProperty('married')];

		return $one;
	}

	/*-------------------- CRUD operacije nad vezama OFFSPRING --------------------*/	
	function getChildren($id) {		// direktni potomci osobe $id

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id . '"})-[:OFFSPRING]->(p:Person)' .
			'RETURN p'
		);
		
		$all = [];
		foreach($results as $result) {
			$node = $result->get('p');
			$all[] = [
				'personID' => $node->getProperty('personID'),
				'firstName' => $node->getProperty('firstName'),
				'lastName' => $node->getProperty('lastName'),
				'gender' => $node->getProperty('gender'),
				'birthDate' => $node->getProperty('birthDate')
			];
		}

		return $all;
	}
	
	function getParents($id) {		// direktni pretci osobe $id

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id . '"})<-[:OFFSPRING]-(p:Person)' .
			'RETURN p'
		);
		
		$all = [];
		foreach($results as $result) {
			$node = $result->get('p');
			$all[] = [
				'personID' => $node->getProperty('personID'),
				'firstName' => $node->getProperty('firstName'),
				'lastName' => $node->getProperty('lastName'),
				'gender' => $node->getProperty('gender'),
				'birthDate' => $node->getProperty('birthDate')
			];
		}

		return $all;
	}

	function modifyOffspringRelationship($id1, $id2) {

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id1 . '"})-[p:OFFSPRING]-(:Person {personID: "' . $id2 . '"})' .
			'SET p.adopted = ' . $adopted .	
			'RETURN p'
		);
		
		if($results->count() === 0) exit("Ne postoji obiteljska veza između " . $id1 . " i " . $id2);
		if($results->count() > 1) echo("Našao više od jedne veze");

		$node = $results[0]->get('p');
		$one = ['married' => $node->getProperty('married')];

		return $one;
	}

	function deleteOffspringRelationship($id1, $id2) {

		$results = $this->client->run(
			'MATCH (:Person {personID: "' . $id1 . '"})-[p:OFFSPRING]-(:Person {personID: "' . $id2 . '"})' .
			'DELETE p'
		);
	}

	function createOffspringRelationship($id1, $id2, $adopted) {	// kreiraj :offspring za ($idRoditelja, $idDjeteta) s atributom $adopted

		$results = $client->run(
			'MATCH (p1:Person {personID: "' . $id1 . '"}), (p2:Person {personID: "' . $id2 . '"})' .
			'CREATE (p1)-[rel:OFFSPRING {adopted: ' . $adopted . '}]->(p2)' .
			'RETURN rel'
		);
		
		if($results->count() === 0) exit("Nije stvorena obiteljska veza između " . $id1 . " i " . $id2);
		if($results->count() > 1) echo("Našao više od jedne veze");

		$node = $results[0]->get('rel');
		$one = ['adopted' => $node->getProperty('adopted')];

		return $one;
	}
};

?>