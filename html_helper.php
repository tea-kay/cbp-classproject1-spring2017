<?php


function text_input($name, $value, $attributes = array()) 
{
    // generate a string containing HTML for a <input type="text">
    $html = "";
    $html .= "input type='text' "; 
    // $name would be used as $name attribute
    $html .= "name='" .htmlspecialchars($name)."' "; 
    // $value would be used as $value attribute
    $html .= 'value="'.htmlspecialchars($value).'" ';
    // foreach ($attribute as $attribute_name => $attribute_value)
    foreach($attributes as $attribute_name => $attribute_value) {
    // add another attribute
    $html .=$attribute_name.'="'.htmlspecialchars($attribute_value).'" ';
    }
    $html .= '>';

    return $html;
}

// calling:
// echo text_input('title', 'My amazing title', ['id' => 'title_input']);
// generates:
// <input type="text" value="My amazing title" id="title">

function paragraph($content, $class) 
{
    $paragraph = '';
    $paragraph .= '<p="' .htmlspecialchars($class). '">' .$content. '</p>';
    return $paragraph;
}

// echo paragraph('Hello', 'first'); 

function option($label, $value, $is_selected = false) 
{
    if ($is_selected)
    { 
        $selected_string = 'selected';
    } 
    else 
    {
        $selected_string ='';
    }
    $option = '';
    $option .= '<option value="' .htmlspecialchars($value). '"' .$selected_string. '>' .$label. '</option>';
    return $option; 
}

$options = [
    0 => 'unknown',
    1 => 'Icecream',
    2 => 'Hamburger',
    3 => 'Pizza'
];

?>

<!--What are we going to eat?<br>-->
<!--<select name="food">
    <?php foreach($options as $value => $name) : ?>

        <?php echo option($name, $value, $value == 3);?>

    <?php endforeach; ?>

</select>-->