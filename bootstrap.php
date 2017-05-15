<?php

//activate error reporting (for debugging)
ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('DATA_DIR', 'data');
define('NOTE_CLASS', 'note');
define('PRIMARY_KEY', 'id');
define('INDEX_DATA', ['title']);

require('database.php');
require('html_helper.php');


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
    public $category = null;
    public $created_at = null;
    public $updated_at = null;

    public function getEditUrl() 
    {
        return 'form.php?id=' . $this->id;
    }
    public function getDetailUrl() 
    {
        return 'detail.php?id=' . $this->id;
    }

}