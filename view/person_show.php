<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
<?php
    echo '<tr><td>First name: </td><td>' . $person->firstName . '</td></tr>';
    echo '<tr><td>Last name: </td><td>' . $person->lastName . '</td></tr>';
    echo '<tr><td>Birth year: </td><td>' . $person->birthDate . '</td></tr>';
    echo '<tr><td>Gender: </td><td>' . $person->gender . '</td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<th><td>Relationship type</td><td>Relationship value</td><td>Person</td></th>';
    if(!empty($parents)){
    foreach($parents as $parent){
        echo '<tr><td>Parent</td>';
        if($parent['atribut'] === 'false') echo '<td>/</td>';
        else echo '<td>Adopted</td>';
        echo '<td>' . $parent['person']->firstName . ' ' . $parent['person']->lastName . '</td></tr>';
    }}
    if(!empty($partners)){
    foreach($partners as $partner){
        echo '<tr><td>Partner</td>';
        if($partner['atribut'] === 'false') echo '<td>/</td>';
        else echo '<td>Married</td>';
        echo '<td>' . $partner['person']->firstName . ' ' . $partner['person']->lastName . '</td></tr>';
    }}
    if(!empty($children)){
    foreach($children as $child){
        echo '<tr><td>Child</td>';
        if($child['atribut'] === 'true') echo '<td>Adopted</td>';
        else echo '<td>/</td>';
        echo '<td>' . $child['person']->firstName . ' ' . $child['person']->lastName . '</td></tr>';
    }}
    echo '</table>';
?>

<form method="get" action="<?php echo __SITE_URL . '/familytree.php?rt=person/handle_request'?>">
    <button type="submit" name="deletePerson">Delete</button>
    <button type="submit" name="modifyPerson">Modify person and relationships</button>
    <button type="submit" name="newRelationship">Add new relationship</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>