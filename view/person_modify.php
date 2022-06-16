<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Naslov</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="./hello.css">-->
</head>
<body>
<!--pretpostavljamo: "person":personInfo, "parents":conn1, "partners":partnerConn, "children":conn2
također pretpostavljamo da je atribut veze pod 'atribut', a osoba pod 'person'
traži se i id osobe s kojom imamo vezu (za modify)
provjeriti da firstname i lastname nisu oba "" pa ako jesu, ne mijenjati osobu?-->

<form>
<?php

    $person = json_decode($data['person']);
    $parents = json_decode($data['parents']);
    $partners = json_decode($data['partners']);
    $children = json_decode($data['children']);

    echo '<table>';
    echo '<tr><td>First name: </td><td><input type="text" name="firstName" value="' . $person->{'firstName'} . '" /></td></tr>';
    echo '<tr><td>Last name: </td><td><input type="text" name="lastName" value="' . $person->{'lastName'} . '" /></td></tr>';
    echo '<tr><td>Family name: </td><td><input type="text" name="familyName" value="' . $person->{'familyName'} . '" /></td></tr>';
    echo '<tr><td>Birth year: </td><td><input type="text" name="birthYear" value="' . $person->{'birthYear'} . '" /></td></tr>';
    echo '<tr><td>Gender: </td><td><input type="text" name="gender" value="' . $person->{'gender'} . '" /></td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<th><td>Relationship type</td><td>Relationship value</td><td>Person</td><td>Delete relationship</td></th>';
    foreach($parents as $parent){
        $set = 'no';
        if($parent['atribut'] !== NULL) $set = 'yes';
        echo '<tr><td>Parent</td><td>Adopted: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $parent['person']->{'id'};
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $parent['person']->{'firstName'} . ' ' . $parent['person']->{'lastName'} . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $parent['person']->{'id'};
        echo '" />Delete</label></td></tr>';
    }
    foreach($partners as $partner){
        $set = 'no';
        if($partner['atribut'] !== NULL) $set = 'yes';
        echo '<tr><td>Partner</td><td>Married: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $partner['person']->{'id'};
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $partner['person']->{'firstName'} . ' ' . $partner['person']->{'lastName'} . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $partner['person']->{'id'};
        echo '" />Delete</label></td></tr>';
    }
    foreach($children as $child){
        $set = 'no';
        if($child['atribut'] !== NULL) $set = 'yes';
        echo '<tr><td>Child</td><td>Adopted: ' . $set . ' ';
        echo '<label><input type="checkbox" name="change" value="' . $child['person']->{'id'};
        if($set === 'yes') echo '_no';
        else echo '_yes';
        echo '" />Change</label></td>';
        echo '<td>' . $child['person']->{'firstName'} . ' ' . $child['person']->{'lastName'} . '</td>';
        echo '<td><label><input type="checkbox" name="delete" value="' . $child['person']->{'id'};
        echo '" />Delete</label></td></tr>';
    }
    echo '</table><br>';
?>

    <button type="submit" name="save">Save</button>
</form>

</body>
</html>