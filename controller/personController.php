<?php 

/*function getAllPersons() // vraca array ljudi
function getPersonByID($id) // vraca jednu osobu
function getPersonByName($name, $surname) // vraca array ljudi
function createPerson($firstName, $lastName, $birthDate, $gender) // vraca jednu osobu
function deletePerson($id) // ne vraca nista
function modifyPerson($personID, $firstName, $lastName, $birthDate, $gender) // vraca 1 osobu
function findSharedAncestor($id1, $id2) // vraca 1 osobu
function findPartners($id) // vraca array ljudi (sve s kojima je $id bio u braku)
function findPartnerRelationships($id1, $id2) // vraca 1 relationship - ne znam hoce li ovo bit potrebno al nek stoji
function modifyPartnerRelationship($id1, $id2, $married) // vraca 1 relationship, $married  je string true ili false*/

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
			$this->registry->template->msg = $person;
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
			if(is_string($parents[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent: ' . $parents[$index]['atribut'] . ', parent id=' . $parent->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$parents[$index]['atribut'] = $fts->findOffspringRelationship($parent->personID, $id);
			if(is_string($parents[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Parent relationship: ' . $parents[$index]['atribut'] . ', parent id=' . $parent->personID;
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
			if(is_string($partners[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner: ' . $partners[$index]['atribut'] . ', partner id=' . $partner->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$partners[$index]['atribut'] = $fts->findOffspringRelationship($partner->personID, $id);
			if(is_string($partners[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Partner reltionship: ' . $partners[$index]['atribut'] . ', partner id=' . $partner->personID;
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
			if(is_string($children[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child: ' . $children[$index]['atribut'] . ', child id=' . $child->personID;
				$this->registry->template->show( 'message' );
				return;
			}
			$children[$index]['atribut'] = $fts->findOffspringRelationship($child->personID, $id);
			if(is_string($children[$index]['atribut'])){
				$this->registry->template->title = 'Family trees';
				$this->registry->template->msg = 'Child relationship: ' . $children[$index]['atribut'] . ', child id=' . $child->personID;
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

	/*public function user() 
	{
		$tus = new TeamUpService();

		$id = $_SESSION['id_user'];

		$this->registry->template->title = 'TeamUp!';
		$this->registry->template->projectList = $tus->getProjectsByUser( $id );
		$this->registry->template->user = $tus->getUserById( $id );
        $this->registry->template->show( 'projects_user' );
	}

	public function new() 
	{
		$this->registry->template->title = 'TeamUp!';
        $this->registry->template->show( 'projects_new' );
	}

	public function createNew() 
	{
		$tus = new TeamUpService();

		$id = $_SESSION['id_user'];

		if( !isset( $_POST['title'] ) || !isset( $_POST['abstract'] ) || !isset( $_POST['number'] ) )
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=projects/new');
			exit();
		}

		$title = $tus->createNewProject( $id, $_POST['title'], $_POST['abstract'], $_POST['number'] );

		$this->registry->template->title = 'TeamUp!';
		$this->registry->template->msg = 'New project ' . $title . ' created.';
		$this->registry->template->show( 'projects_confirmNewProject' );
	}

	public function show()
	{
		$tus = new TeamUpService();

		$project = $tus->getProjectById( $_GET['id_project'] );
		$id = $_SESSION['id_user'];

		$view = 'projects_show';
		$projects = $tus->getProjectsByUser( $id );
		$arr = array();
		foreach( $projects as $p )
			$arr[$p->id] = $p;
		
		if( $project->status === 'open' && !isset( $arr[$project->id] ) )
			$view = $view . 'Apply';
		else if( $project->status === 'open' && $id === $project->author_id ){
			$this->registry->template->applicationList = $tus->getApplicationsbyProject( $_GET['id_project'] );
			$view = $view . 'Applications';
		}

		$this->registry->template->title = 'TeamUp!';
		$this->registry->template->project = $project;
		$this->registry->template->id_user = $_SESSION['id_user'];
		$this->registry->template->show( $view );
	}*/
}; 

?>
