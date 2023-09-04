<?php

require_once SHAREDPATH . 'template.php';
require_once SHAREDPATH . 'database.php';

session_start();

$enteredEmail = htmlspecialchars($_POST['address']);
$confirmEmail = htmlspecialchars($_POST['confirmAddress']);
$enteredUsername = htmlspecialchars($_POST['userData']);

$usenameOkay = preg_match("[A-Za-z0-9\-_\.]", $enteredUsername); //make sure only valid characters
if (strlen($enteredUsername) < 4 || strlen($enteredUsername) > 20) { //make sure length is within allowable range
    $usernameOkay = false;
}
$emailOkay = filter_var($enteredEmail, FILTER_VALIDATE_EMAIL); //make sure email is in correct format

if ($enteredEmail != $confirmEmail) {
    $emailOkay = false;
}

//https://www.informit.com/articles/article.aspx?p=30875&seqNum=5
$userNameAvailable = safe_sql_query("SELECT * FROM users, newaccounts WHERE users.username = ? OR newaccounts.username = ?", ['ss', $enteredUsername, $enteredUsername]);
$emailInUse = safe_sql_query("SELECT * FROM users, newaccounts WHERE users.email = ? OR newaccounts.email = ?", ['ss', $enteredEmail, $enteredEmail]);

begin_html_page('SLO Shogi Account Creation Attempt');

if (!$enteredUsername || !$emailOkay) { //if the username doesn't meet the criteria
    //give error message
    echo "入力に誤りがありました。もう一回入力してみてください。Invalid input. Please try again";
} else if (mysqli_num_rows($userNameAvailable) > 0) {
    //check to make sure username isn't already taken
    echo "ユーザー名は既に存在している｜The username is already in use";
} else if (mysqli_num_rows($emailInUse) > 0) {
    //check to see if email isn't already registered
    echo "メールアドレスは既に登録されている|The email is already registered";
} else {
    //add email and password to the database

    $OTP = random_int(100000, 999999); // generate 6-digit random int

    $newUser = safe_sql_query("INSERT INTO newaccounts (email, username, OTP) VALUES (?, ?, ?)", ['ssi', $enteredEmail, $enteredUsername, $OTP]);

    //send email with OTP
    $message = "アカウントはまだ確定されていません！
    \n24時間以内に下記のリンクよりメールアドレスを承認してください。
    \nYour account is not confirmed yet!
    \nPlease click the link below to confrim your email within 24 hours
    \nwww.sloshogi.com/account-setup?OTP=" . $OTP . "
    \nSLO将棋に興味を持って頂きたい誠にありがとうございます。
    \nThank you for your interest in SLO Shogi!";

    $message = wordwrap($message, 70);

    mail($enteredEmail, "SLO将棋アカウント承認　Verify SLO Shogi Account", $message);

    if ($newUser) {
        echo "Account information submitted. Please check your email within 1 hour to validate your account <br>
    アカウント情報は発信されました。1時間以内にメールをチェックしてアカウント有効化して下さい";
    }
}

?>

<a href="/">トップに戻る・Return to Homepage</a>

<?php
end_html_page();
