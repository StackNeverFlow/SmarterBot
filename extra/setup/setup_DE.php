<?php
if (file_exists("../config.php")) {
	header("Location: done.php?lang=de");
}
?>
<html lang="de">
<head>
	<link rel="stylesheet" href="../style.css">
  <style>
  input, button, select {
    width: 100%;
  }
  </style>
	<title>Installation | SmarterBot</title>
</head>
<body>
	<div class="flex">
		<div class="flex-item">
<?php
function writeConfig() {
       try {
           $file = fopen('../config.php', 'w');
					 $adminpw = hash('SHA256', hash('SHA256', $_POST['adminpw']));
					 $version = "v1.2";
           fwrite(
               $file,
               '<?php'.PHP_EOL
               .'  /*'.PHP_EOL
               .'      Automatisch erstellte Config-Datei    '.PHP_EOL
               .'      Erstellt am '.date('d.m.Y  H:i:s').'    '.PHP_EOL
               .'  */'.PHP_EOL
               .'  $dbhost = "'.$_POST['dbhost'].'";'.PHP_EOL
               .'  $dbbase = "'.$_POST['dbbase'].'";'.PHP_EOL
               .'  $dbuser = "'.$_POST['dbuser'].'";'.PHP_EOL
               .'  $dbpass = "'.$_POST['dbpass'].'";'.PHP_EOL
               .'  $title = "'.$_POST['title'].'";'.PHP_EOL
               .'  $botname = "'.$_POST['botname'].'";'.PHP_EOL
               .'  $api = "'.$_POST['api'].'";'.PHP_EOL
							 .'  $password = "'.$adminpw.'";'.PHP_EOL
							 .'  $lang = "'.$_POST['lang'].'";'.PHP_EOL
               .'  $version = "'.$version.'";'.PHP_EOL
               .'  /*'.PHP_EOL
               .'      Software SmarterBot    '.PHP_EOL
               .'           Version '.$version.'    '.PHP_EOL
               .'  */'.PHP_EOL
               .'?>'
           );
           fclose($file);
           return true;
       } catch (Exception $e) {
           return false;
       }
   }
if (isset($_POST['submit'])) {
  $dbhost = $_POST['dbhost'];
  $dbbase = $_POST['dbbase'];
  $dbuser = $_POST['dbuser'];
  $dbpass = $_POST['dbpass'];
  if ($_POST['dbpass'] == $_POST['dbpassc']) {

  $worked = "ja";

  try {
    $mysql = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
	   $mysql->query("CREATE TABLE IF NOT EXISTS `keywords` (
       id int NOT NULL AUTO_INCREMENT,
       keyword varchar(255) NOT NULL,
       text varchar(4294967295),
       PRIMARY KEY (id)
      );");
			$mysql->query("CREATE TABLE IF NOT EXISTS `commands` (
        id int NOT NULL AUTO_INCREMENT,
        command varchar(255) NOT NULL,
        antwort varchar(4294967295),
				beschreibung varchar(4294967295),
        PRIMARY KEY (id)
       );");
    } catch (PDOException $e){
      echo "<div class='error'> Fehler bei der Datenbankverbindung: ".$e."</div>";
      $worked = "nein";
        }
	if ($_POST['adminpw'] == $_POST['adminpwc']) {
			$worked1 = "ja";
	} else {
		echo "<div class='error'>Die Adminpasswörter stimmen nicht überein!</div>";
		$worked1 = "nein";
	}
if ($worked == "ja") {
	if ($worked1 == "ja") {
writeConfig();
header("Location: done.php?lang=de");
}
}
} else {
  echo "<div class='error'>Die Datenbankpasswörter stimmen nicht überein.</div>";
}
}
?>
<form action="setup_DE.php" method="post">
<h1>Datenbank</h1>
<input type="text" name="dbhost" placeholder="Datenbank Host" <?php if (isset($_POST['dbhost'])) { echo "value='".$_POST['dbhost']."'"; } ?> required></input>
<input type="text" name="dbbase" placeholder="Datenbank" <?php if (isset($_POST['dbbase'])) { echo "value='".$_POST['dbbase']."'"; } ?> required></input>
<input type="text" name="dbuser" placeholder="Datenbank Benutzer" <?php if (isset($_POST['dbuser'])) { echo "value='".$_POST['dbuser']."'"; } ?> required></input>
<input type="password" name="dbpass" placeholder="Datenbank Passwort"></input>
<input type="password" name="dbpassc" placeholder="Datenbank Passwort bestätigen"></input>
<br><br>
<hr>
<br><br>
<h1>Seiten Einstellungen</h1>
<input type="text" name="title" placeholder="Seitentitel" <?php if (isset($_POST['title'])) { echo "value='".$_POST['title']."'"; } ?> required>
<input type="text" name="botname" placeholder="Name des Bots" <?php if (isset($_POST['botname'])) { echo "value='".$_POST['botname']."'"; } ?> required>
<br><br>
<hr>
<br><br>
<h1>API aktivieren</h1>
<select name="api">
  <option value="yes" <?php if(isset($_POST['api'])) { if ($_POST['api'] == "yes") { echo "selected"; }} ?>>Ja</option>
  <option value="no" <?php if(isset($_POST['api'])) { if ($_POST['api'] == "no") { echo "selected"; }} ?>>Nein</option>
</select>
<br><br>
<hr>
<br><br>
<h1>Adminpasswort</h1>
<input name="adminpw" type="password" minlength="8" placeholder="Passwort für den Adminbereich" required>
<input name="adminpwc" type="password" minlength="8" placeholder="Bestätigung des Passworts für den Adminbereich" required>
<br><br>
<hr>
<br><br>
<h1>Sprache</h1>
<input type="text" name="lang" required placeholder="Trage den Ländercode für die Sprache ein. Die Datei muss im Order /lang existieren!" value="de_DE">
<br><br><hr><br><br>
<input type="hidden" name="submit" value="true">
<button type="submit">Speichern</button>
</form>

</div>
</div>
</body>
<footer>
<p align="center"><font color="grey" size="5">Software: <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - von <a href="https://twitter.com/StackNeverFlow">StackNeverFlow</a></font></p>
</footer>
</html>
