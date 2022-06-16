<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
<?php
    echo '<tr><td>First name: </td><td>' . $person->firstName . '</td></tr>';
    echo '<tr><td>Last name: </td><td>' . $person->lastName . '</td></tr>';
    echo '<tr><td>Birth year: </td><td>' . $person->birthDate . '</td></tr>';
    echo '<tr><td>Gender: </td><td>' . $person->gender . '</td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<tr><th>Relationship type</th><th>Relationship value</th><th>Person</th></tr>';
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
        if($child['atribut'] === 'false') echo '<td>/</td>';
        else echo '<td>Adopted</td>';
        echo '<td>' . $child['person']->firstName . ' ' . $child['person']->lastName . '</td></tr>';
    }}
    echo '</table><br>';
?>

<form method="get" action="<?php echo __SITE_URL . '/familytree.php?rt=person/handle_request'?>">
    <button type="submit" name="btn" value="delete">Delete</button>
    <button type="submit" name="btn" value="modify">Modify person and relationships</button>
    <button type="submit" name="btn" value="newrel">Add new relationship</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>