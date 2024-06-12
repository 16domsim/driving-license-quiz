<?php

const IDS_LOGIN_NOT_NECESSARY = [
    "0",
    "2"
];
$id = $_GET["id"];
if (isset($_GET["id"])) {
    if ($id == 101) {
        session_destroy();
        header("Location:index.php");
        exit();
    } else {
        if (array_search($id, IDS_LOGIN_NOT_NECESSARY, true) === false && ! isset($_SESSION["loginUsername"])) {
            if (! isset($_SESSION["request_id"])) {
                foreach ($_GET as $key => $value)
                    $_SESSION["request_" . $key] = $value;
                header("Location:login.php");
            } else {
                $username = filter_input(INPUT_POST, "loginUsername", FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, "loginPassword", FILTER_SANITIZE_STRING);
                if (! authUser($username, $password)) {
                    $_SESSION["login_error"] = true;      
                    header("Location:login.php");
                } else {
                    $_SESSION["loginUsername"] = $username;
                    unset($_SESSION["login_error"]);
                    if ($_SESSION["request_id"] == "100")
                        unset($_SESSION["request_id"]);
                    $params = "";
                    foreach ($_SESSION as $key => $value) {
                        if (strpos($key, "request_") === 0) {
                            if (! empty($params))
                                $params = $params . "&";
                            else
                                $params = "?";
                            $params = $params . substr($key, 10) . "=" . $value;
                            unset($_SESSION[$key]);
                        }
                        header("Location:index.php" . $params);
                    }
                }
            }
            exit();
        }
    }
}

function authUser($username, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);

    $ret = false;
    $id = - 1;
    $con = new mysqli("localhost", "root", "masterkey", "users");
    if ($con->connect_errno) {} else {
        $query = "SELECT uid
                        FROM users
                        WHERE uusername = ? AND upassword = ?";
        $stmp = $con->prepare($query);
        if ($con->errno) {
            trigger_error($con->error, E_USER_WARNING);
        } else {
            $stmp->bind_param("ss", $username, $password);
            $stmp->execute();
            $stmp->store_result();
            $stmp->bind_result($id);
            if ($stmp->fetch())
                $ret = $id;
            if (isset($ret) && is_int($ret))
                $ret = true;
            else
                $ret = false;
            $stmp->close();
        }
        $con->close();
    }
    return $ret;
}

?>