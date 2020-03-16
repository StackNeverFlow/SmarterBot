<?php
if (!file_exists("../config.php")) {
	echo "[ERROR] Use the setupsystem";
	exit;
}
require("../config.php");
if (!isset($_GET['lang'])) {
  echo "[ERROR] Use the setupsystem";
  exit;
}
if (empty($_GET['lang'])) {
  echo "[ERROR] Use the setupsystem";
  exit;
}
?>
<html lang="<?php echo $_GET['lang'] ?>">
<head>
	<link rel="stylesheet" href="../style.css">
  <style>
  input, button, select {
    width: 100%;
  }
  </style>
<?php
  if ($_GET['lang'] == "de") {
    echo "<title>Abgeschlossen | SmarterBot</title>";
  }
  if ($_GET['lang'] == "en") {
    echo "<title>Done | SmarterBot</title>";
  }
  if ($_GET['lang'] == "fr") {
    echo "<title>Terminé | SmarterBot</title>";
  }

?>
</head>
<body>
	<div class="flex">
		<div class="flex-item">
      <h1>
<?php
if ($_GET['lang'] == "de") {
  echo "Die Installation ist abgeschlossen - du kannst diese Seite nun schließen.";
}
if ($_GET['lang'] == "en") {
  echo "The installation is completed - you can close this page now.";
}
if ($_GET['lang'] == "fr") {
  echo "L'installation est terminée - vous pouvez maintenant fermer cette page.";
}
?>
</h1>
    </div>
  </div>
</body>
<footer>
<?php
  if ($_GET['lang'] == "de") {
    echo '<p align="center"><font color="grey" size="5">Software: <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - von <a href="https://twitter.com/Kuschel_Swein">Kuschel_Swein</a></font></p>';
  }
  if ($_GET['lang'] == "en") {
    echo '<p align="center"><font color="grey" size="5">Software: <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - from <a href="https://twitter.com/Kuschel_Swein">Kuschel_Swein</a></font></p>';
  }
  if ($_GET['lang'] == "fr") {
    echo '<p align="center"><font color="grey" size="5">Logiciels: <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - à côté de <a href="https://twitter.com/Kuschel_Swein">Kuschel_Swein</a></font></p>';
  }
?>
</footer>
</html>
