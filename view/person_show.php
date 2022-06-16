<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
<?php
    echo '<tr><td>First name: </td><td>' . $person->firstName . '</td></tr>';
    echo '<tr><td>Last name: </td><td>' . $person->lastName . '</td></tr>';
    echo '<tr><td>Birth date: </td><td>' . $person->birthDate . '</td></tr>';
    echo '<tr><td>Gender: </td><td>' . $person->gender . '</td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<tr><th>Relationship type</th><th>Relationship value</th><th>Person</th></tr>';
    if(!empty($parents)){
    foreach($parents as $parent){
        echo '<tr><td>Parent</td>';
        if($parent['atribut'] === 'true') echo '<td>Adopted</td>';
        else echo '<td>/</td>';
        echo '<td>' . $parent['person']->firstName . ' ' . $parent['person']->lastName . '</td></tr>';
    }}
    if(!empty($partners)){
    foreach($partners as $partner){
        echo '<tr><td>Partner</td>';
        if($partner['atribut'] === 'true') echo '<td>Married</td>';
        else echo '<td>/</td>';
        echo '<td>' . $partner['person']->firstName . ' ' . $partner['person']->lastName . '</td></tr>';
    }}
    if(!empty($children)){
    foreach($children as $child){
        echo '<tr><td>Child</td>';
        if($child['atribut'] === 'true') echo '<td>Adopted</td>';
        else echo '<td>/</td>';
        echo '<td>' . $child['person']->firstName . ' ' . $child['person']->lastName . '</td></tr>';
    }}
    echo '</table><br>';
?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/handle_request' ?>">
    <button type="submit" name="deletePerson" value="<?php echo $person->personID ?>">Delete</button>
    <button type="submit" name="modifyPerson" value="<?php echo $person->personID ?>">Modify person and relationships</button>
    <button type="submit" name="newRelationship" value="<?php echo $person->personID ?>">Add new relationship</button>
</form><br>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>