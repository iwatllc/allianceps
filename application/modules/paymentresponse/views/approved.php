<?php

session_start();

if (!strlen($_SERVER['QUERY_STRING']))
{
    exit ();
}

$string_out = base64_decode($_SERVER['QUERY_STRING']);

parse_str($string_out, $_SESSION);

//print ($string_out);

$card = $_SESSION['card'];
//GET CARD TYPE
switch ($card){
    case "VS":
        $card = '<img src="'.base_url('assets/img/cards/visa.jpg').'">';
        break;
    case "AX":
        $card = '<img src="'.base_url('assets/img/cards/amex.jpg').'">';
        break;
    case "MC":
        $card = '<img src="'.base_url('assets/img/cards/mastercard.jpg').'">';
        break;
    case "DS":
        $card = '<img src="'.base_url('assets/img/cards/discover.jpg').'">';
        break;
    case "DC":
        $card = '<img src="'.base_url('assets/img/cards/dinersclub.jpg').'">';
        break;
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt Page</title>
</head>

<body>

<div align="center" style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
    <?php
    print "<br>";
    print "<br>";
    print "<strong style=\"color:#FF6600\">" . $_SESSION['responseText'] . "</strong><br>";
    print "<br>";
    print "Account Holder: " . $_SESSION['name'] . "<br>";
    print "<br>";
    print $card . "<br>";
    print $_SESSION['expandedCardNum'] . "<br>Expires: " . $_SESSION['expDate'] . "<br>";
    print "<br>";
    print "Amount Charged: <span style=\"color:#B20000\">$" . $_SESSION['amount'] . "</span><br>";
    print "<br>";
    print "Transaction ID: " . $_SESSION['transId'] . "<br>";
    print "Order#: " . $_SESSION['order_number'] . "<br>";
    print "<br>";
    print "<span style=\"font-size:8px\">Customer ID: " . $_SESSION['cid'] . "</span><br>";
    print "<br>";
    print "<span style=\"font-size:8px\">TransToken ID: " . $_SESSION['jpToId'] . "</span><br>";
    print "<br>";
    print "<h5><a href=\"dataform.php\">click here to run another</a></h5>";
    ?>
</div>


</body>

<?php

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

?>
</html>