<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Family Trees</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>

    <link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>

<nav>
    <a name="persons_list" id="persons_list" href="<?php echo __SITE_URL; ?>/familytree.php?rt=handle_request">Show all people</a> |
    <a name="person_search" id="person_search" href="<?php echo __SITE_URL; ?>/familytree.php?rt=handle_request">Search people by name</a> |
    <a name="person_create" id="person_create" href="<?php echo __SITE_URL; ?>/familytree.php?rt=handle_request">Create new person</a> |
    <a name="check6th" id="check6th" href="<?php echo __SITE_URL; ?>/familytree.php?rt=handle_request">Find closest shared ancestor</a>
</nav>
