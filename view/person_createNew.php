<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/addNewPerson'?>">
    <table>
        <tr><td>First name: </td><td><input type="text" name="firstName" value="" /></td></tr>
        <tr><td>Last name: </td><td><input type="text" name="lastName" value="" /></td></tr>
        <tr><td>Birth year: </td><td><input type="text" name="birthDate" value="" /></td></tr>
        <tr><td>Gender: </td><td><input type="text" name="gender" value="" /></td></tr>
    </table>
    <button type="submit" name="save">Save</button>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>