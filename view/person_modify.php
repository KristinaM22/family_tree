<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/setModifiedValues' ?>">
<table>
<?php
    echo '<tr><td>First name: </td><td><input type="text" name="firstName" value="' . $person->firstName . '" /></td></tr>';
    echo '<tr><td>Last name: </td><td><input type="text" name="lastName" value="' . $person->lastName . '" /></td></tr>';
    echo '<tr><td>Birth date: </td><td><input type="text" name="birthDate" value="' . $person->birthDate . '" /></td></tr>';
    echo '<tr><td>Gender: </td><td><input type="text" name="gender" value="' . $person->gender . '" /></td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<tr><th>Relationship type</th><th>Relationship value</th><th>Change</th><th>Person</th><th>Delete relationship</th></tr>';
    if(!empty($parents)){
    foreach($parents as $parent){
        $set = 'no';
        if($parent['atribut']['adopted'] === 'true') $set = 'yes';
        echo '<tr><td>Parent</td><td>Adopted: ' . $set . '</td> ';
        echo '<td><input type="checkbox" id="change_' . $parent['person']->personID . '" name="change_parents[]" value="' . $parent['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '"><label for="change_' . $parent['person']->personID . '">Change</label></td>';
        echo '<td>' . $parent['person']->firstName . ' ' . $parent['person']->lastName . '</td>';
        echo '<td><input type="checkbox" id="delete_' . $parent['person']->personID . '" name="delete_parents[]" value="' . $parent['person']->personID;
        echo '"><label for="delete_' . $parent['person']->personID . '">Delete</label></td></tr>';
    }}
    if(!empty($partners)){
    foreach($partners as $partner){
        $set = 'no';
        if($partner['atribut']['married'] === 'true') $set = 'yes';
        echo '<tr><td>Partner</td><td>Married: ' . $set . '</td>';
        echo '<td><input type="checkbox" id="change_' . $partner['person']->personID . '" name="change_partners[]" value="' . $partner['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '"></td>';
        echo '<td>' . $partner['person']->firstName . ' ' . $partner['person']->lastName . '</td>';
        echo '<td><input type="checkbox" id="delete_' . $partner['person']->personID . '" name="delete_partners[]" value="' . $partner['person']->personID;
        echo '"></td></tr>';
    }}
    if(!empty($children)){
    foreach($children as $child){
        $set = 'no';
        if($child['atribut']['adopted'] === 'true') $set = 'yes';
        echo '<tr><td>Child</td><td>Adopted: ' . $set . '</td>';
        echo '<td><input type="checkbox" id="change_' . $child['person']->personID . '" name="change_children[]" value="' . $child['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '"></td>';
        echo '<td>' . $child['person']->firstName . ' ' . $child['person']->lastName . '</td>';
        echo '<td><input type="checkbox" id="delete_' . $child['person']->personID . '" name="delete_children[]" value="' . $child['person']->personID;
        echo '"></td></tr>';
    }}
    echo '</table><br>';
?>

<button type="submit" name="save" value="<?php echo $person->personID ?>">Save</button>
</form><br>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>