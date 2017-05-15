<?php

require 'bootstrap.php';
// retrieve all notes from database

$notes = database_please_get_all_notes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of notes</title>
</head>
<body>
    <h1>List of Notes</h1>
    <!-- display the retrieved notes -->
     <ul>
        <?php foreach($notes as $note) : ?>

            <li>
                <?php echo $note->title; ?>
                <a href="<?php echo $note->getEditUrl(); ?>">edit</a>
            </li>

        <?php endforeach; ?>

    </ul>
</body>
</html>