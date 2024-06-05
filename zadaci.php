<?php
session_start();

if (!isset($_SESSION["korisnicko_ime"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"])) {
    $task = $_POST["task"];
    
    if (!empty($task)) {
        $xml = simplexml_load_file("zadaci.xml");
        
        $newTask = $xml->addChild('zadatak');
        $newTask->addChild('korisnicko_ime', $_SESSION["korisnicko_ime"]);
        $newTask->addChild('opis', $task);
        
        $xml->asXML('zadaci.xml');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_task"])) {
    $taskToDelete = $_POST["delete_task"];
    
    $xml = simplexml_load_file("zadaci.xml");
    
    foreach ($xml->zadatak as $zadatak) {
        if ($zadatak->korisnicko_ime == $_SESSION["korisnicko_ime"] && $zadatak->opis == $taskToDelete) {
            $dom = dom_import_simplexml($zadatak);
            $dom->parentNode->removeChild($dom);
            $xml->asXML('zadaci.xml');
            break;
        }
    }
}

$tasks = simplexml_load_file("zadaci.xml");

?>

<html>
<head>
<title>Zadaci</title>
</head>
<body>
<h2>Dobrodošao, <?php echo $_SESSION["korisnicko_ime"]; ?></h2>
<form action="" method="post">
<table>
<tr>
<td><label>Novi zadatak:</label></td>
<td><input id="task" name="task" type="text"></td>
<td><input name="submit" type="submit" value="Dodaj"></td>
</tr>
</table>
</form>

<h3>Vaši zadaci:</h3>
<ul>
<?php
foreach ($tasks->zadatak as $zadatak) {
    if ($zadatak->korisnicko_ime == $_SESSION["korisnicko_ime"]) {
        echo "<li>" . $zadatak->opis . " <form action='' method='post' style='display:inline;'><button type='submit' name='delete_task' value='" . $zadatak->opis . "'>Obriši</button></form></li>";
    }
}
?>
</ul>

<form action="logout.php" method="post">
<input name="submit" type="submit" value="Logout">
</form>

</body>
</html>
