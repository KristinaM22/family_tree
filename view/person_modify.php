<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form>
<table>
<?php
    echo '<tr><td>First name: </td><td><input type="text" name="firstName" value="' . $person->firstName . '" /></td></tr>';
    echo '<tr><td>Last name: </td><td><input type="text" name="lastName" value="' . $person->lastName . '" /></td></tr>';
    echo '<tr><td>Birth year: </td><td><input type="text" name="birthYear" value="' . $person->birthDate . '" /></td></tr>';
    echo '<tr><td>Gender: </td><td><input type="text" name="gender" value="' . $person->gender . '" /></td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<tr><th>Relationship type</th><th>Relationship value</th><th>Person</th><th>Delete relationship</th></tr>';
    if(!empty($parents)){
    foreach($parents as $parent){
        $set = 'no';
        if($parent['atribut'] !== 'false') $set = 'yes';
        echo '<tr><td>Parent</td><td>Adopted: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $parent['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $parent['person']->firstName . ' ' . $parent['person']->lastName . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $parent['person']->personID;
        echo '" />Delete</label></td></tr>';
    }}
    if(!empty($partners)){
    foreach($partners as $partner){
        $set = 'no';
        if($partner['atribut'] !== 'false') $set = 'yes';
        echo '<tr><td>Partner</td><td>Married: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $partner['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $partner['person']->firstName . ' ' . $partner['person']->lastName . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $partner['person']->personID;
        echo '" />Delete</label></td></tr>';
    }}
    if(!empty($children)){
    foreach($children as $child){
        $set = 'no';
        if($child['atribut'] !== 'false') $set = 'yes';
        echo '<tr><td>Child</td><td>Adopted: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $child['person']->personID;
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $child['person']->firstName . ' ' . $child['person']->lastName . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $child['person']->personID;
        echo '" />Delete</label></td></tr>';
    }}
    echo '</table><br>';
?>

<button type="submit" name="save">Save</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>