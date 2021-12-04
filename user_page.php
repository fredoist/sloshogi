<?php
session_start();

require 'connect.php';
$currentGameQuery = "SELECT id FROM gamerecord WHERE ( blackplayer = '".$_COOKIE['current_user_cookie'] ."' OR whiteplayer = '".$_COOKIE['current_user_cookie'] ."')
AND (status = 2 
OR (status = 4 AND winner != '".$_COOKIE['current_user_cookie']."' ) 
OR (status = 5 AND winner = '".$_COOKIE['current_user_cookie']."'))   
";

$getCurrentGameId = mysqli_query($link, $currentGameQuery );
$currentGameIdArray =  [];
while($row = mysqli_fetch_array($getCurrentGameId)){
    array_push($currentGameIdArray, $row['id']);//add each gameid related to the user to an array
}
$opponentNameArray = [];
for($i = 0; $i < sizeof($currentGameIdArray); $i++){
    $getOpponent = mysqli_query($link, "SELECT blackplayer, whiteplayer, turn FROM gamerecord WHERE id = '".$currentGameIdArray[$i]."'");
    $getOpponentArray = mysqli_fetch_array($getOpponent);
  
    if($getOpponentArray['blackplayer'] == $_COOKIE['current_user_cookie']){

        array_push($opponentNameArray, $getOpponentArray['whiteplayer']);

        if($getOpponentArray['turn'] %2 == 0){//see if it is even turn (white)
            array_push($opponentNameArray, 0);//add on a 0 for false, beause it is not the player's turn
        }else{
            array_push($opponentNameArray, 1);//add on a 1 for true becase it is the player's turn
        }

    }else{
        array_push($opponentNameArray, $getOpponentArray['blackplayer']);
        //for some reason, the next line isn't working when it's the first turn
        if($getOpponentArray['turn'] %2 != 0){//if it's the first turn or black's turn
            array_push($opponentNameArray, 0);//add on a 0 for false, beause it is not the player's turn
        }
        else{
            array_push($opponentNameArray, 1);//add on a 1 for true becase it is the player's turn
    }
}
}

$getNewChallenges = mysqli_query($link, "SELECT id FROM gamerecord WHERE status = 1 AND creator != '".$_COOKIE['current_user_cookie']."' AND
( blackplayer = '".$_COOKIE['current_user_cookie'] ."' OR whiteplayer = '".$_COOKIE['current_user_cookie'] ."')" );
//get challenges that the user didn't create themselves
$challengesIdArray =  [];
while($row = mysqli_fetch_array($getNewChallenges)){
    array_push($challengesIdArray, $row['id']);//add each gameid related to the user to an array
}
$challengingOpponentArray = [];
for($i = 0; $i < sizeof($challengesIdArray); $i++){
    $getOpponent = mysqli_query($link, "SELECT blackplayer, whiteplayer FROM gamerecord WHERE id = '".$challengesIdArray[$i]."'");
    $getOpponentArray = mysqli_fetch_array($getOpponent);
    if($getOpponentArray['blackplayer'] == $_COOKIE['current_user_cookie']){

        array_push($challengingOpponentArray, $getOpponentArray['whiteplayer']);
    }else{
        array_push($challengingOpponentArray, $getOpponentArray['blackplayer']);
    }
}


$getPastGameId = mysqli_query($link, "SELECT id FROM gamerecord WHERE (status = 3 
OR (status = 4 AND winner = '".$_COOKIE['current_user_cookie']."' ) 
OR (status = 5 AND winner != '".$_COOKIE['current_user_cookie']."') ) 
AND 
( blackplayer = '".$_COOKIE['current_user_cookie'] ."' OR whiteplayer = '".$_COOKIE['current_user_cookie'] ."')" );
$pastGameIdArray =  [];
while($row = mysqli_fetch_array($getPastGameId)){
    array_push($pastGameIdArray, $row['id']);//add each gameid related to the user to an array
}
$pastOpponentNameArray = [];
for($i = 0; $i < sizeof($pastGameIdArray); $i++){
    $getOpponent = mysqli_query($link, "SELECT blackplayer, whiteplayer FROM gamerecord WHERE id = '".$pastGameIdArray[$i]."'");
    $getOpponentArray = mysqli_fetch_array($getOpponent);
    if($getOpponentArray['blackplayer'] == $_COOKIE['current_user_cookie']){

        array_push($pastOpponentNameArray, $getOpponentArray['whiteplayer']);
    }else{
        array_push($pastOpponentNameArray, $getOpponentArray['blackplayer']);
    }
}

$getUserInfo = mysqli_query($link, "SELECT * FROM users WHERE username = '".$_COOKIE['current_user_cookie']."'");
$userInfoArray = mysqli_fetch_array($getUserInfo);
?>

<!DOCTYPE HTML>
<head>
    <script>
        let currentGameIdArray = <?php echo json_encode($currentGameIdArray) ; ?>;
        let currentGameOpponentArray = <?php echo json_encode($opponentNameArray) ; ?>;
        let newChallengesArray = <?php echo json_encode($challengesIdArray) ; ?>;
        let challengesOpponentArray = <?php echo json_encode($challengingOpponentArray) ; ?>;
        let pastGameIdArray = <?php echo json_encode($pastGameIdArray) ; ?>;
        let pastGameOpponentArray = <?php echo json_encode($pastOpponentNameArray) ; ?>;

    </script>

    <link href="CSS/all_pages.css" rel="stylesheet">
    <link href="CSS/user_page.css" rel="stylesheet">
 </head>
 <body>
<div id = "all">
    <div id = "nameIconRating">
    <h1 id = "userName"><?=$_COOKIE['current_user_cookie']?></h1>
    <h2 id = "rating">段級: ?</h2>
    <h2 id = "record"><?=$userInfoArray['record']?>&nbsp&nbsp </h2>
    <p id="hitokotoInput">"<?=$userInfoArray['hitokoto']?>"</p>
    <a href = "settings.php"id = "settings" >設定 Settings</a>
    <div id="iconBox">
    <img src= "images/icons/<?=$_COOKIE['icon']?>_icon.png" id = "userIcon">
    </div>
    </div>


<div class="user"> 
<h3>Current Games</h3>
<br>

<div id = "allGames"></div>
</div>

<h3><a href = "newGame.php">New Game</a></h3>
<h3><a href = "friends.php">Friends</a></h3>

<div class ="user">
    <h3>New Challenges</h3>
    <br>

<div id = "newChallenges"></div>
</div>


<div class="user">
<h3>Finished Games</h3>
<div id = "finishedGames"></div>
</div>
<br>
<h1><a href="feedback_form.php?src=user_page&id=na">バグ報告・Report a bug</a></h1>
<h1><a href = "slo_tsumeshogi.php">詰将棋（β版）</a></h1>
<h1><a href = "logout.php" id = "logoutButton">ログアウトLog Out</a></h1>

</div>
<script src = "scripts/get_games.js"></script>
    </body>
