<?php

if(!defined('DATA_DIR')) exit('First define DATA_DIR constant. It should be a path to the folder where we will store our notes without trailing /. It should be absolute or relative to the data-functions.php file. On Unix systems make sure that the path is writable.');
if(!defined('PRIMARY_KEY')) exit('Define constant PRIMARY_KEY. It should be a string with the name of the primary key piece of data (`id`).');
if(!defined('INDEX_DATA')) exit('Define constant INDEX_DATA. It should be an array of data that will be part of the index.');
if(!defined('NOTE_CLASS')) exit('Define constant NOTE_CLASS. It should contain the name of a class that will be used to store notes (`note`).');

function database_please_get_index()
{
    $index = json_decode(database_please_get_index_contents(), true);

    return $index;
}

function database_please_get_all_notes()
{
    $index = database_please_get_index();

    $notes = [];
    foreach($index as $id => $index_info)
    {
        $notes[$id] = database_please_get_note($id);
    }

    return array_filter($notes);
}

function database_please_get_note($pk)
{
    if(file_exists(DATA_DIR.'/'.$pk.'.json'))
    {
        $data = json_decode(file_get_contents(DATA_DIR.'/'.$pk.'.json'), true);
        $class = NOTE_CLASS;
        $note = new $class();
        foreach($data as $key => $value)
        {
            $note->$key = $value;
        }
        return $note;
    }
    return null;
}

function database_please_save_note($note)
{
    $data = (array)$note;

    $missing_data = array_diff(INDEX_DATA, array_keys($data));
    if($missing_data)
    {
        throw new Exception('`' . join('`, `', $missing_data) . '` not found in saved data.');
        return false;
    }

    $index = database_please_get_index();
    if(empty($data[PRIMARY_KEY]))
    {
        $data[PRIMARY_KEY] = $index ? max(array_keys($index))+1 : 1;
    }
    elseif(!preg_match('#^\d+$#', $data[PRIMARY_KEY]))
    {
        throw new Exception('Invalid Primary Key. Primary Key must be an integer.');
        return false;
    }

    $index[$data[PRIMARY_KEY]] = array_intersect_key($data, array_fill_keys(INDEX_DATA, null));

    // save index
    file_put_contents(DATA_DIR.'/index.json', json_encode($index));

    // save note
    file_put_contents(DATA_DIR.'/'.$data[PRIMARY_KEY].'.json', json_encode($data));

    return $data[PRIMARY_KEY];
}

function database_please_delete_note($pk)
{
    $return = true; // if everyhting goes well

    $index = database_please_get_index();
    
    if(array_key_exists($pk, $index))
    {
        unset($index[$pk]);
        
        // save index
        file_put_contents(DATA_DIR.'/index.json', json_encode($index));
    }
    else
    {
        $return = false;
    }

    // delete note
    if(file_exists(DATA_DIR.'/'.$pk.'.json'))
    {
        unlink(DATA_DIR.'/'.$pk.'.json');
    }
    else
    {
        $return = false;
    }

    return $return;
}

// protected
function database_please_get_index_contents()
{
    if(!file_exists(DATA_DIR.'/index.json'))
    {
        $contents = json_encode([]);
        file_put_contents(DATA_DIR.'/index.json', $contents);
        return $contents;
    }
    return file_get_contents(DATA_DIR.'/index.json');
}