<?php

require 'bootstrap.php';

$notes = database_please_get_all_notes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note detail</title>
</head>
<body>
<h1>List of Notes</h1>    
    <?php foreach($notes as $note) : ?>

<li>
            <?php echo $note->text; ?>
            <a href="<?php echo $note->getDetailUrl(); ?>">detail</a>
</li>

    <?php endforeach; ?>
</body>
</html>