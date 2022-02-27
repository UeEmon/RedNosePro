<?php

$category = "碁";

$players = array();
$players[] = array("name" => "加賀", "gender" => "M");
$players[] = array("name" => "奈瀬", "gender" => "F");
$players[] = array("name" => "飯島", "gender" => "M");

print_r($players);

$arrayValues = "";


foreach ($players as $player) {
    $name   = $player['name'];
    $gender = $player['gender'];
    $arrayValues = "('{$category}', '{$name}', '{$gender}')";
}

print_r($arrayValues);


//$sql = "INSERT INTO hogeTable (category, name, gender) VALUES " .join(",", $arrayValues);

//print_r($sql);