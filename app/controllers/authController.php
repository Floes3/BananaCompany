<?php require_once '../init.php';

if (isset($_GET['logout'])) {
    logout($messageBag);
    header('Location: ' .HTTP . 'public/views/auth/Login.php');
}

switch($_POST['type']){

    case 'login':

        if (login($db,$_POST['username'],$_POST['password'],$messageBag)){
           header('location:' . HTTP . 'public/index.php');
        } else {
            
            header('Location: ' . HTTP . 'public/views/auth/login.php');
        }
        break;

    case 'logout':
        if(logout($messageBag)){
            header('Location: ' .HTTP . 'public/views/auth/Login.php');
        }
        break;

    case 'register':
        if(register($db, $_POST['username'],$_POST['password'],$messageBag)){
            header('Location: ' .HTTP . 'public/views/auth/Login.php');
        } else {

            header('Location: ' .HTTP . 'public/views/auth/register.php');
        }
        break;
}



function login($db, $username, $password,$messageBag){



    if(empty($username) || empty($password)){
        $messageBag->Add('a',"One or more fields aren't filled in!");
        return false;
    }

    $sql = "SELECT * FROM users WHERE name = :username";
    $q = $db->prepare($sql);
    $q->bindparam(':username', $username);
    $q->execute();


    if ($q->rowCount() > 0) {

        $user = $q->fetch();

        if(password_verify($password, $user['password'])){

            $_SESSION['user']['username'] = $user['username'];
            $_SESSION['user']['id'] = $user['id'];
            $_SESSION['user']['userrole'] = $user['userrole'];
            $messageBag->Add('s','U bent succesvol ingelogt!');
            return true;

        }

    }
    $messageBag->Add('a','wrong username or password');
    return false;
}

function logout($messageBag){
    unset($_SESSION['user']);
    $messageBag->Add('s','U bent succesvol uitgelogt!');
    return true;
}

function register($db,$username,$password,$messageBag){

    if(empty($username) || empty($password)){
        $messageBag->Add('a','Een of meerdere verplichte velden zijn niet ingevuld!');
        return false;
    } else {

        $sql = 'SELECT * FROM users where username = :username';
        $q = $db->prepare($sql);
        $q->bindParam(':username', $username);
        $q->execute();

        if ($q->rowCount() > 0) {
            $messageBag->Add('a', 'Username bestaat al!');
            return false;

        } else {
            $hashed = password_hash($password,PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (username, password)  VALUES (:username,:hashed)';

            $q = $db->prepare($sql);
            $q->bindParam(':username', $username);
            $q->bindParam(':hashed', $hashed);
            $q->execute();
            $messageBag->Add('a','Succesvol geregistreerd!');
            return true;
        }
    }
}