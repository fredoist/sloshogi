<?php

function load_route(string $route)
{
    $routes = array(
        // Home
        '/' => ABSPATH . 'Home/Home.php',
        '/privacy-policy' => ABSPATH . 'Home/PrivacyPolicy.php',
        '/terms-of-service' => ABSPATH . 'Home/TermsOfService.php',
        '/what-is-slo-shogi' => ABSPATH . 'Home/WhatIsSloShogi.php',
        // Auth
        '/login' => ABSPATH . 'Auth/Login.php',
        '/verify-login' => ABSPATH . 'Auth/VerifyLogin.php',
        '/forgot-password' => ABSPATH . 'Auth/ForgotPassword.php',
        '/email-temp-password' => ABSPATH . 'Auth/EmailTempPassword.php',
        '/new-account' => ABSPATH . 'Auth/NewAccount.php',
        '/verify-creation' => ABSPATH . 'Auth/VerifyCreation.php',
        '/account-setup' => ABSPATH . 'Auth/AccountSetup.php',
        '/finalize-account' => ABSPATH . 'Auth/FinalizeAccount.php',
        '/logout' => ABSPATH . 'Auth/Logout.php',
        '/user-page' => ABSPATH . 'User/UserPage.php',
        // Settings
        '/settings' => ABSPATH . 'Settings/Settings.php',
        '/settings/update-icon' => ABSPATH . 'Settings/UpdateIcon.php',
        '/settings/change-koma-set' => ABSPATH . 'Settings/ChangeKomaSet.php',
        // Gameboard
        '/gameboard' => ABSPATH . 'Gameboard/Gameboard.php',
        '/gameboard/move-reservation' => ABSPATH . 'Gameboard/MoveReservation.php',
        '/gameboard/kifu/write-kifu' => ABSPATH . 'Gameboard/WriteKifu.php',
        // New Game
        '/new-game' => ABSPATH . 'NewGame/NewGame.php',
        '/new-game/new-challenge' => ABSPATH . 'NewGame/NewChallenge.php',
        '/new-game/create-open-game' => ABSPATH . 'NewGame/CreateOpenGame.php',
        '/new-game/join-game' => ABSPATH . 'NewGame/JoinGame.php',
        // Friends
        '/friends' => ABSPATH . 'Friends/Friends.php',
        '/friends/add-friend' => ABSPATH . 'Friends/AddFriend.php',
        '/friends/invite-email' => ABSPATH . 'Friends/InviteEmail.php',
        '/friends/view-friend' => ABSPATH . 'Friends/ViewFriend.php',
        // Forum
        '/forum' => ABSPATH . 'Forum/Forum.php',
        '/forum/forum-top' => ABSPATH . 'Forum/ForumTop.php',
        '/forum/create-topic' => ABSPATH . 'Forum/CreateTopic.php',
        '/forum/category' => ABSPATH . 'Forum/Category.php',
        '/forum/topic' => ABSPATH . 'Forum/Topic.php',
        // SloTsumeshogi
        '/slotsumeshogi' => ABSPATH . 'SloTsumeshogi/SloTsumeshogi.php',
        '/slotsumeshogi/all-tsume' => ABSPATH . 'SloTsumeshogi/AllTsume.php',
        '/slotsumeshogi/all-tsume/tsume' => ABSPATH . 'SloTsumeshogi/Tsume.php',
        '/slotsumeshogi/pro-tsume' => ABSPATH . 'SloTsumeshogi/ProTsume.php',
        '/slotsumeshogi/my-tsume' => ABSPATH . 'SloTsumeshogi/MyTsume.php',
        '/slotsumeshogi/initialize-tsume' => ABSPATH . 'SloTsumeshogi/InitializeTsume.php',
        // Feedback
        '/feedback-form' => ABSPATH . 'Feedback/FeedbackForm.php',
        '/send-feedback' => ABSPATH . 'Feedback/SendFeedback.php',
    );

    if (file_exists($routes[$route])) {
        require_once $routes[$route];
    }
}
