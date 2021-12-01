<?php
// Страница регистрации нового пользователя

// Соединямся с БД
$link=mysqli_connect("localhost", "root", "root", "autorization");

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин танҳо рақам ва ҳарфҳои англисиро қабул мекунад.";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин набояд, ки аз 3 символ кам ва аз 30 символ зиёд бошад!";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Чунин логин мавҷуд аст!";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $name = $_POST['name']." ".$_POST['surname']." ".$_POST['lastname'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        // $unvon = $_POST['unvon'];
        $unvod_id = 0;
        // if($unvon=="Администратор"){
        //     $unvod_id = 1;
        // }
        // else
        // {
        //     $unvod_id = 0;
        // }

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."', user_name='".$name."', id_type='".$unvod_id."'");
        header("Location: http://yak.tj/"); exit();
    }
    else
    {
        print "<b>Ҳангоми регистратсия чунин хатогиҳо рӯй доданд:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>
<h2>Регистратсия</h2>
<form method="POST">
<p>Логин <input name="login" type="text" required></p>
<p>Рамз <input name="password" type="password" required></p>
<p>Насаб <input name="name" type="text" required></p>
<p>Ном <input name="surname" type="text" required></p>
<p>Номи падар <input name="lastname" type="text" required></p>
<!-- <p>Унвон <select name="unvon">
    <option value="Администратор">Администратор</option>
    <option value="Истифодабаранда">Истифодабаранда</option>
    </select>
</p> -->
<p><input name="submit" type="submit" value="Давом додан"></p>
</form>
