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
traži se i id osobe s kojom imamo vezu (za modify)-->

<?php

    $person = json_decode($data['person']);
    $parents = json_decode($data['parents']);
    $partners = json_decode($data['partners']);
    $children = json_decode($data['children']);

    echo '<table>';
    echo '<tr><td>First name: </td><td>' . $person->{'firstName'} . '</td></tr>';
    echo '<tr><td>Last name: </td><td>' . $person->{'lastName'} . '</td></tr>';
    echo '<tr><td>Family name: </td><td>' . $person->{'familyName'} . '</td></tr>';
    echo '<tr><td>Birth year: </td><td>' . $person->{'birthYear'} . '</td></tr>';
    echo '<tr><td>Gender: </td><td>' . $person->{'gender'} . '</td></tr>';
    echo '</table><br>';

    echo '<table>';
    echo '<th><td>Relationship type</td><td>Relationship value</td><td>Person</td></th>';
    foreach($parents as $parent){
        echo '<tr><td>Parent</td>';
        if($parent['atribut'] === NULL) echo '<td>/</td>';
        else echo '<td>' . $parent['atribut'] . '</td>';
        echo '<td>' . $parent['person']->{'firstName'} . ' ' . $parent['person']->{'lastName'} . '</td></tr>';
    }
    foreach($partners as $partner){
        echo '<tr><td>Partner</td>';
        if($partner['atribut'] === NULL) echo '<td>/</td>';
        else echo '<td>' . $partner['atribut'] . '</td>';
        echo '<td>' . $partner['person']->{'firstName'} . ' ' . $partner['person']->{'lastName'} . '</td></tr>';
    }
    foreach($children as $child){
        echo '<tr><td>Child</td>';
        if($child['atribut'] === NULL) echo '<td>/</td>';
        else echo '<td>' . $child['atribut'] . '</td>';
        echo '<td>' . $child['person']->{'firstName'} . ' ' . $child['person']->{'lastName'} . '</td></tr>';
    }
    echo '</table><br>';
?>

<button type="submit" name="deletePerson">Delete</button>
<button type="submit" name="modifyPerson">Modify person and relationships</button>
<button type="submit" name="newRelationship">Add new relationship</button>
</body>
</html>