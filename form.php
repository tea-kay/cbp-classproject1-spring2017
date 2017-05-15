<?php

require 'bootstrap.php';

$messages =[]; //Messages to be displayed to the user

// RETREIVE DATA FROM DB OR INITIALIZE EMPTY DATA

// if there was id in GET parameter

// if(isset ($_GET['id']) && $_GET['id']) {
if(!empty($_GET['id'])) {
    // retrieve existing note
    $note = database_please_get_note($_GET['id']);
    var_dump($note);
} else {
    // create a new note
    $note = new note();
}


if($_POST) 
// if($_SERVER['REQUEST_METHOD'] == 'POST') // also possible
{
    // GET THE SUBMITTED DATE
    //getting everything that starts with note[];
    $note_array = $_POST['note'];

    // UPDATE THE RETRIEVED DATA WITH SUBMITTED DATA
    $note->title = $note_array['title'];
    $note->text = $note_array['text'];

    // IS THE UPDATE VALID?
    $valid = true;
    if(strlen($note->title) == 0) {
        $messages[] = 'The title must not be empty';
        $valid = false; //switch the valid status to false
    }
    if($valid) {

        $note->created_at = date('Y-m-d H:i:s');
        $note->updated_at = date('Y-m-d H:i:s');
        // SAVE UPDATED DATA
        database_please_save_note($note);
        
        //REDIRECT
        header('Location: form.php');
        exit(); //end the script after redirection (should not be necessary)
    }

    var_dump($_POST);

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Form</title>
</head>
<body>
    <h1>The Form</h1>

    <?php if($messages) : // if the array of the message is not empty?>
        <div class="messages"> 
            <?php foreach($messages as $message) : // loop through messages ?>
                <div class="message">
                    <?= $message; ?>
                </div>
            <?php endforeach;?>
        </div>
    <?php endif;?>



    <form action="" method="post">

        <labe for="note_title">Title</label>
        <?php echo text_input('note[title]', $note->title, ['id' => 'note_title'])?>
        <br>
        <select name="category" form="">
            <option value="Javascript">Javascript</option>
            <option value="CSS">CSS</option>
            <option value="Git">Git</option>
            <option value="PHP">PHP</option>
        </select>
        <br>
        <input type="text" name="note[title]" value="<?php echo htmlspecialchars($note->title);?>" id="note_title">
        <br>
        <labe for="note_title">Text</label>
        <br>
        <textarea name="note[text]" id="note_text"><?php echo htmlspecialchars($note->text);?></textarea>
        <br>
        <input type="submit" value="Save">
</body>
</html>