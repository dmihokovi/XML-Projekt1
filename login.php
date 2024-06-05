<?php

$username="";
$password="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ans=$_POST;

    if (empty($ans["korisnicko_ime"]))  {
        echo "Korisničko ime nije uneseno.";
        
    } else if (empty($ans["lozinka"]))  {
        echo "Lozinka nije unesena.";
        
    } else {
        $username= $ans["korisnicko_ime"];
        $password= $ans["lozinka"];
    
        provjera($username, $password);
    }
}

function provjera($username, $password) {
    $xml=simplexml_load_file("korisnici.xml");
    
    foreach ($xml->korisnik as $korisnik) {
        if($korisnik->korisnicko_ime == $username && $korisnik->lozinka == $password) {
            session_start();
            $_SESSION["korisnicko_ime"] = $username;
            header("Location: zadaci.php");
            exit();
        }
    }
    
    echo "Netocni podaci.";
}
?>

<html>
<head>
<title>Login</title>
</head>
<body>
<form action="" method="post">
<table>
<tr>
<td><label>Korisničko ime :</label></td>
<td><input id="name" name="korisnicko_ime" type="text"></td>
</tr>
<tr>
<td><label>Lozinka :</label></td>
<td><input id="password" name="lozinka" placeholder="**********" type="password"></td>
</tr>
<tr>
<td><input name="submit" type="submit" value="Login"></td>
</tr>
</table>
</form>
</body>
</html>
