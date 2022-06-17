<?php 

class PersonController extends BaseController
{
	public function index() 
	{
		$fts = new FamilyTreeService();

		$this->registry->template->title = 'Family trees';

        $this->registry->template->show( 'index' );
	}

	public function showAll()
	{
		$fts = new FamilyTreeService();

		$this->registry->template->title = 'Family trees';
		$this->registry->template->personsList = $fts->getAllPersons();

		$this->registry->template->show( 'persons_list' );
	}

	public function show()
	{
		$fts = new FamilyTreeService();

		$id = $_POST['selected'];

		$person = $fts->getPersonByID($id);

		if(is_string($person)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = $person . ', id=' . $id;
			$this->registry->template->show( 'message' );
			return;
		}

		$parents = array();
		$result = $fts->getParents($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Parents: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $parent){
			$parents[$index]['person'] = $fts->getPersonByID($parent->personID);
			if(is_string($parents[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent: ' . $parents[$index]['person'] . ', id=' . $id . ' & parent id=' . $parent->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$parents[$index]['atribut'] = $fts->findOffspringRelationship($parent->personID, $id);
			if(is_string($parents[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent relationship: ' . $parents[$index]['atribut'] . ', id=' . $id . ' & parent id=' . $parent->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$partners = array();
		$result = $fts->findPartners($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Partners: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $partner){
			$partners[$index]['person'] = $fts->getPersonByID($partner->personID);
			if(is_string($partners[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner: ' . $partners[$index]['person'] . ', id=' . $id . ' & id partner id=' . $partner->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$partners[$index]['atribut'] = $fts->findPartnerRelationship($partner->personID, $id);
			if(is_string($partners[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner reltionship: ' . $partners[$index]['atribut'] . ', id=' . $id . ' & partner id=' . $partner->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$children = array();
		$result = $fts->getChildren($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Children: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $child){
			$children[$index]['person'] = $fts->getPersonByID($child->personID);
			if(is_string($children[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child: ' . $children[$index]['person'] . ', id=' . $id . ' & child id=' . $child->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$children[$index]['atribut'] = $fts->findOffspringRelationship($child->personID, $id);
			if(is_string($children[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child relationship: ' . $children[$index]['atribut'] . ', id=' . $id . ' & child id=' . $child->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$this->registry->template->title = 'Family trees';
		$this->registry->template->person = $person;
		$this->registry->template->parents = $parents;
		$this->registry->template->partners = $partners;
		$this->registry->template->children = $children;

		$this->registry->template->show( 'person_show' );
	}

	public function handle_request(){
		if(isset($_POST['deletePerson'])){
			$this->deletePerson($_POST['deletePerson']);
		}
		else if(isset($_POST['modifyPerson'])){
			$this->modifyPerson($_POST['modifyPerson']);
		}
		else if(isset($_POST['newRelationship'])){
			$this->newRelationship($_POST['newRelationship']);
		}
	}

	public function deletePerson($_id){;

		$fts = new FamilyTreeService();

		$this->registry->template->title = 'Family trees';
		$this->registry->template->msg = $fts->deletePerson($_id);
		$this->registry->template->show( 'message' );
	}

	public function modifyPerson($_id){

		$id = $_id;

		$fts = new FamilyTreeService();

		$person = $fts->getPersonByID($id);

		if(is_string($person)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = $person . ', id=' . $id;
			$this->registry->template->show( 'message' );
			return;
		}

		$parents = array();
		$result = $fts->getParents($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Parents: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $parent){
			$parents[$index]['person'] = $fts->getPersonByID($parent->personID);
			if(is_string($parents[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent: ' . $parents[$index]['person'] . ', id=' . $id . ' & parent id=' . $parent->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$parents[$index]['atribut'] = $fts->findOffspringRelationship($parent->personID, $id);
			if(is_string($parents[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent relationship: ' . $parents[$index]['atribut'] . ', id=' . $id . ' & parent id=' . $parent->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$partners = array();
		$result = $fts->findPartners($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Partners: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $partner){
			$partners[$index]['person'] = $fts->getPersonByID($partner->personID);
			if(is_string($partners[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner: ' . $partners[$index]['person'] . ', id=' . $id . ' & id partner id=' . $partner->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$partners[$index]['atribut'] = $fts->findPartnerRelationship($partner->personID, $id);
			if(is_string($partners[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner reltionship: ' . $partners[$index]['atribut'] . ', id=' . $id . ' & partner id=' . $partner->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$children = array();
		$result = $fts->getChildren($id);
		if(is_string($result)){
			$this->registry->template->title = 'Family trees';
			$this->registry->template->msg = 'Children: ' . $result;
			$this->registry->template->show( 'message' );
			return;
		}
		$index = 0;
		foreach($result as $child){
			$children[$index]['person'] = $fts->getPersonByID($child->personID);
			if(is_string($children[$index]['person'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child: ' . $children[$index]['person'] . ', id=' . $id . ' & child id=' . $child->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$children[$index]['atribut'] = $fts->findOffspringRelationship($child->personID, $id);
			if(is_string($children[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child relationship: ' . $children[$index]['atribut'] . ', id=' . $id . ' & child id=' . $child->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$index++;
		}

		$this->registry->template->title = 'Family trees';
		$this->registry->template->person = $person;
		$this->registry->template->parents = $parents;
		$this->registry->template->partners = $partners;
		$this->registry->template->children = $children;

		$this->registry->template->show( 'person_modify' );
	}

	public function newRelationship($_id){
		$id = $_id;
		$this->registry->template->title = 'Family trees';
		$this->registry->template->id = $id;
		$this->registry->template->show( 'person_newRelationship' );
	}

	public function setModifiedValues(){
		
		$fts = new FamilyTreeService();
		$id = $_POST['save'];
		$msg = '<br>';

		$person = $fts->modifyPerson($id, $_POST['firstName'], $_POST['lastName'], $_POST['birthDate'], $_POST['gender']);
		if(is_string($person)){
			$msg = $msg . $person . ', id=' . $id . '<br>';
		}
		else{
			$msg = $msg . 'Person change successful.<br>';
			$msg = $msg . 'firstName: ' . $person->firstName . ', lastName: ' . $person->lastName . ', birthDate: ' . $person->birthDate . ', gender: ' . $person->gender . '<br>';
		}

		if(isset($_POST['change_parents'])){
		foreach($_POST['change_parents'] as $checkbox) {
			$value = explode('_', $checkbox);
			$set = 'false';
			if($value[1] === 'yes') $set = 'true';
			$result = $fts->modifyOffspringRelationship($id, $value[0], $set);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' attribute change: ' . $result['adopted'] . '<br>';
		}}

		if(isset($_POST['delete_parents'])){
		foreach($_POST['delete_parents'] as $checkbox) {
			$value = explode('_', $checkbox);
			$result = $fts->deleteOffspringRelationship($id, $value[0]);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' delete: ' . $result . '<br>';
		}}

		if(isset($_POST['change_partners'])){
		foreach($_POST['change_partners'] as $checkbox) {
			$value = explode('_', $checkbox);
			$set = 'false';
			if($value[1] === 'yes') $set = 'true';
			$result = $fts->modifyPartnerRelationship($id, $value[0], $set);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' attribute change: ' . $result['married'] . '<br>';
		}}

		if(isset($_POST['delete_partners'])){
		foreach($_POST['delete_partners'] as $checkbox) {
			$value = explode('_', $checkbox);
			$result = $fts->deletePartnerRelationship($id, $value[0]);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' delete: ' . $result . '<br>';
		}}

		if(isset($_POST['change_children'])){
		foreach($_POST['change_children'] as $checkbox) {
			$value = explode('_', $checkbox);
			$set = 'false';
			if($value[1] === 'yes') $set = 'true';
			$result = $fts->modifyOffspringRelationship($id, $value[0], $set);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' attribute change: ' . $result['adopted'] . '<br>';
		}}

		if(isset($_POST['delete_children'])){
		foreach($_POST['delete_children'] as $checkbox) {
			$value = explode('_', $checkbox);
			$result = $fts->deleteOffspringRelationship($id, $value[0]);
			$msg = $msg . 'Relationship with id=' . $value[0] . ' delete: ' . $result . '<br>';
		}}

		$this->registry->template->title = 'Family trees';
		$this->registry->template->msg = $msg;
		$this->registry->template->show( 'message' );
	}

	public function addNewRelationship(){

		$fts = new FamilyTreeService();

		$msg = '';

		$selectedRelationship = $_POST['relationshipType'];
		$person_id = $_POST['radioOptions'];
		$id = $_POST['add'];

		if($selectedRelationship === 'offspring') $result = $fts->findOffspringRelationship($id, $person_id);
		else if ($selectedRelationship === 'partner') $result = $fts->findPartnerRelationship($id, $person_id);

		if(!is_string($result)){
			$msg = 'Relationship of that type between those people already exists or error occured.';
		}
		else{
			$val = 'false';
			if(isset($_POST['setValue'])) $val = 'true';
			if($selectedRelationship === 'offspring') $result = $fts->createOffspringRelationship($id, $person_id, $val);
			else if ($selectedRelationship === 'partner') $result = $fts->createPartnerRelationship($id, $person_id, $val);
			if(is_string($result)){
				$msg = $result . ', id1=' . $id . ', id2=' . $person_id;
			}
			else $msg = 'Relationship created: ' . $selectedRelationship . ', with ids: ' . $id . ', ' . $person_id . ', attribute value: ' . $val;
		}

		$this->registry->template->title = 'Family trees';
		$this->registry->template->msg = $msg;
		$this->registry->template->show( 'message' );
	}

	public function createNew(){
		$this->registry->template->title = 'Family trees';
		$this->registry->template->show( 'person_createNew' );
	}

	public function addNewPerson(){

		$fts = new FamilyTreeService();

		$msg = '';
		if($_POST['firstName'] == ''){
			$msg = 'First name required.';
			$this->registry->template->msg = $msg;
			$this->registry->template->show( 'message' );
			return;
		}
		$person = $fts->createPerson($_POST['firstName'], $_POST['lastName'], $_POST['birthDate'], $_POST['gender']);

		if(is_string($person)){
			$msg = $msg . $person;
		}
		else{
			$msg = $msg . 'Person creation successful.<br>';
			$msg = $msg . 'firstName: ' . $person->firstName . ', lastName: ' . $person->lastName . ', birthDate: ' . $person->birthDate . ', gender: ' . $person->gender . '<br>';
		}

		$this->registry->template->msg = $msg;
		$this->registry->template->title = 'Family trees';
		$this->registry->template->show( 'message' );
	}

	public function findAncestor(){
		$this->registry->template->title = 'Family trees';
		$this->registry->template->show( 'person_checkSixthCousin' );
	}

	public function ancestorResponse(){

		$fts = new FamilyTreeService();
		$msg = '';

		if(!isset($_POST['radioOptions1']) || !isset($_POST['radioOptions2'])){
			$msg = 'Input error';
		}
		else{
			$result = $fts->findSharedAncestor($_POST['radioOptions1'], $_POST['radioOptions2']);
			if(is_string($result)){
				if(is_string($fts->findOffspringRelationship($_POST['radioOptions1'], $_POST['radioOptions2'])))
					$msg = 'Parent and child.';
				else $msg = 'Shared ancestor: ' . $result;
			} 
			else $msg = "Shared ancestor found: first name: " . $result->firstName . ', last name: ' . $result->lastName . ', birth date: ' . $result->birthDate . ', gender: ' . $result->gender;
		}
		
		$this->registry->template->msg = $msg;
		$this->registry->template->title = 'Family trees';
		$this->registry->template->show( 'message' );
	}

	public function search(){
		$this->registry->template->title = 'Family trees';
		$this->registry->template->show( 'person_search' );
	}

	public function searchResult(){

		$fts = new FamilyTreeService();

		$firstName = $_GET['firstNameSearch'];
		$lastName = $_GET['lastNameSearch'];

		$result = $fts->getPersonByName($firstName, $lastName);
		$data = array();
		$index = 0;
		foreach($result as $person){
			$data[$index]['personID'] = $person->personID; 
			$data[$index]['firstName'] = $person->firstName;
			$data[$index]['lastName'] = $person->lastName;
			$data[$index]['birthDate'] = $person->birthDate;
			$data[$index]['gender'] = $person->gender;
			$index++;
		}
		$this->registry->template->send_json( $data );
	}
}; 

?>
