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
		$tus = new FamilyTreeService();

		$this->registry->template->title = 'Family tree';
		$this->registry->template->personsList = $tus->getAllPersons();
		$newList = array();
		//$newList['personID'] = $tus->getPersonByID('I0404');
		$newList['personName'] = $tus->getPersonByName('Maria', '');
		$newList['new'] = $tus->createPerson('first', 'last', '00-00-0000', 'male');
		$newList['newGet'] = $tus->getPersonByID($newList['new']['personID']);
		$this->registry->template->msg = $tus->deletePerson($newList['new']['personID']);
		$this->registry->template->newList = $newList;

        $this->registry->template->show( 'index' );
	}

	public function user() 
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
	}
}; 

?>
