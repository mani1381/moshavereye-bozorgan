<?php

$people = file_get_contents('./people.json');
$people2 = json_decode($people, true);
$question = $_POST['question'];
$messages = explode("\n", file_get_contents('./messages.txt'));

if (is_null($_POST['person'])==1) 
{
    $fa_name = $json_people[$en_name];
    $en_name = array_rand($people2);
} 
else 
{
    $fa_name = $people2[$en_name];
    $en_name = $_POST['person'];
}
if (empty($question)) 
{
    $msg = "سوال خود را بپرس!";
} 
elseif ((substr(trim($question), -1) != "?" && substr(trim($question), -2) != "؟") || explode(' ', trim($question))[0] != "آیا") 
{
    $msg = "سوال درستی پرسیده نشده";
} 
else 
{
    $msg = $messages[hexdec(substr(md5($question . $en_name), 0, 15)) % count($messages)];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label" style="display: <?php echo empty($question) ? 'none' : 'inline' ?>;">پرسش:</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach ($people2 as $key => $value) 
                {
                    echo '<option name="" value="'.$key.'" '. ($en_name == $key ? 'selected' : '') .'>'.$value.'</option>';
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>