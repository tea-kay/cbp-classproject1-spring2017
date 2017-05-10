<?php

//activate error reporting (for debugging)
ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('DATA_DIR', 'data');
define('NOTE_CLASS', 'note');
define('PRIMARY_KEY', 'id');
define('INDEX_DATA', ['title']);

require('database.php');


/* 
available functions:
-------------------

// database_please_get_index()
// database_please_get_all_notes()
// database_please_get_note($note_id)
// database_please_save_note($note_object)
// database_please_delete_note($pk)
*/

class note 
{
    public $id = null;
    public $title = null;
    public $text = null;
    public $created_at = null;
    public $updated_at = null;

}
$message =[]; //Messages to be displayed to the user

// RETREIVE DATA FROM DB OR INITIALIZE EMPTY DATA
$note = new note(); 


if($_POST) 
// if($_SERVER['REQUEST_METHOD'] == 'POST') // also possible
{
    // GET THE SUBMITTED DATE
    //getting everything that starts with note[];
    $note_array = $_POST['note'];

    // UPDAATE THE RETRIEVED DATA WITH SUBMITTED DATA
    $note->title = $note_array['title'];
    $note->text = $note_array['text'];

    // IS THE UPDATE VALID?
    $valid = true;
    if(strlen($note->title) == 0) {
        $message[] = 'The title must not be empty';
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

    <form action="" method="post">

        <labe for="note_title">Title</label>
        <br>
        <input type="text" name="note[title]" value="">
        <br>
        <labe for="note_title">Text</label>
        <br>
        <textarea name="note[text]"></textarea>
        <br>
        <input type="submit" value="Save">
</body>
</html>