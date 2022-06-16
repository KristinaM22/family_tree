<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/show'?>">
    <table>
        <?php
            foreach ($personsList as $person)
            {
                echo '<tr><td>' . $person->firstName . ' ' . $person->lastName . '</td>';
                echo '<td><button type="submit" name="selected" value="' . $person->personID . '">Show</button></td></tr>';
            }
        ?>
    </table>
</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>