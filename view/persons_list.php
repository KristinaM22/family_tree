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

<form>
    <table>
    <?php
        $personsList = json_decode($data);      //idk kako vraća podatke
        foreach ($personsList as $person) {     
            echo '<tr><td>' . $person->{'firstName'} . ' ' . $person->{'lastName'} . '</td>';
            echo '<td><button type="submit" name="selected" value="' . $person->{'personID'} . '">Show</button></td></tr>'; 
        }
    ?>
    </table><br>
</form>

</body>
</html>