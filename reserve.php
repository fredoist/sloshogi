<?php

$in = file_get_contents('php://input');
$decoded = json_decode($in, true);
$gametofind = $decoded['gameId'];

$link = mysqli_connect('localhost', 'christopherd', 'A*3BYyM5o#Qcs', 'sloshogi');//*******UPDATE**********/

    $updatecommand = 'UPDATE gamerecord SET reservation = "' . $decoded['reservationmoves'] . '" WHERE id ='; 

echo $updatecommand;

    mysqli_query($link, $updatecommand.$gametofind);

 ?>