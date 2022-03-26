<?php

session_start();

require 'functions.php';

// cek cookie
if( isset($_COOKIE["lock"]) && isset($_COOKIE["key"]) ) {
    $lock = $_COOKIE['lock'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $hasil = mysqli_query($conn, "SELECT username FROM user WHERE id=$id");
    $row = mysqli_fetch_assoc($hasil);

    // cek cookie dan username 
    if($key === hash('sha100', $row['username'])) {
        $_SESSION['login'] = true;
    }
}




if(isset($_POST["login"])) {

$username = $_POST["username"];
$password = $_POST["password"];

$hasil = mysqli_query( $conn, "SELECT * FROM user WHERE username='$username' " );

// cek username
if( mysqli_num_rows($hasil) === 1 ) {

    // cek password
    $row = mysqli_fetch_assoc($hasil);
    if(password_verify($password, $row["password"])) {

        // set session
        $_SESSION["login"] = true;

        // cek remember me
        if( isset($_POST["remember"]) ) {
            // buat cookie
            setcookie('lock', $row['id'], time() + 40);
            setcookie('key', hash('sha100', $row['username']), time() + 40);
        }

        header("Location: index2.php");
        exit;
    }
}
$error = true;
}

?>

<html>
    <head>
        <script type="text/javascript" src="aset/bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="aset/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="aset/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="aset/font-awesome/css/font-awesome.min.css">
        <title>Login Database</title>
    </head>
    <body>

        <div align="center">
            <br>
            <div align="center" style="width:320px;margin-top:5%;">
                <form name="login_form" method="post" class="well well-lg" action="" style="-webkit-box-shadow: 0px 0px 20px #888888;">
                    <i class="fa fa-book fa-4x"></i>
                    <h4>DATABASE MAHASISWA</h4>
                    <br>
                    <?php if(isset($error)) : ?>
        <div class="alert alert-danger">
            <strong>Log In Gagal!</strong> Username atau Password Salah.
        </div>
    <?php endif; ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input require name="username" id="username" class="form-control" type="text" placeholder="username" autocomplete="off" />
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input require name="password" id="password" class="form-control" type="password" placeholder="password" autocomplete="off" />
                    </div>
                    <br />

            <div class="mb-1 mt-1">
            <button class="btn btn-primary" type="submit" name="login">Login</button>
            <a href="registrasi.php">
                <button type="button" class="btn btn-success">Buat Akun Baru</button>
            </a>
            </div>
                </form>
            </div>
        </div>
        <br>

        <footer align="center">
            Created By <a href="#" title="Universitas Baturaja"><i class="fa fa-copyright" aria-hidden="true">Universitas Baturaja</i></a>
        </footer>
    </body>

    <!--<script type="text/javascript">
    function validasi() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;       
        if (username != "" && password!="") {
            return true;
        }else{
            alert('Username dan Password harus di isi !');
            return false;
        }
    }
    </script>-->

</html>