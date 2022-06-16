<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Naslov</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="./hello.css">
</head>
<body>
<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/createNew'?>">
    <table>
        <tr><td>First name: </td><td><input type="text" name="firstName" value="" /></td></tr>
        <tr><td>Last name: </td><td><input type="text" name="lastName" value="" /></td></tr>
        <tr><td>Family name: </td><td><input type="text" name="familyName" value="" /></td></tr>
        <tr><td>Birth year: </td><td><input type="text" name="birthYear" value="" /></td></tr>
        <tr><td>Gender: </td><td><input type="text" name="gender" value="" /></td></tr>
    </table>
    <button type="submit" name="save">Save</button>
</form>

</body>
</html>