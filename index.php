<?php
if (!file_exists("extra/config.php")) {
	header("Location: setup.php");
	exit;
}
require("extra/config.php");
require("lang/".$lang.".php");
if (isset($_GET['api'])) {
	if ($api == "yes") {
	try {
	$mysql = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
	} catch (PDOException $e) { echo misc_database_error;
	echo $e;
	}
	foreach ($mysql->query("SELECT * FROM keywords WHERE Locate(keyword,'%".$_GET['frage']."%')!=0") as $row) {
		echo "".$row['text']."<br>";
	}
  die();
} else {
	header("Location: index.php");
	exit;
}
}
?>
<html>
<head>
	<script>
		window.onload=function(){
			var textarea = document.getElementById('chat');
			textarea.scrollTop = textarea.scrollHeight;
		}
	</script>
	<link rel="stylesheet" href="extra/style.css">
	<title><?php if (!empty($title)) { echo $title; } else { echo "Supportchat"; } ?></title>
	<style>
		.button span {
		  cursor: pointer;
		  display: inline-block;
		  position: relative;
		  transition: 0.5s;
		}

		.button span:after {
		  content: '\00bb';
		  position: absolute;
		  opacity: 0;
		  top: 0;
		  right: -20px;
		  transition: 0.5s;
		}

		.button:hover span {
		  padding-right: 25px;
		}

		.button:hover span:after {
		  opacity: 1;
		  right: 0;
	}
	</style>
</head>
<body>
	<div class="flex">
		<div class="flex-item">
			<center>
<form action="index.php" onsubmit="savemsg()" method="post">
<textarea id="chat" rows="25" name="chat" readonly>
<?php
try {
$mysql = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
} catch (PDOException $e){
}
if (!empty($_POST['chat'])) {
	$chat = $_POST['chat'];
}
if (!empty($_POST['msg'])) {
	if ($_POST['msg'] === "/clear") {
		$chat = ">> ".command_action_chatcleared." <<";
		$_POST['msg'] = "";
	}
}

if (!empty($chat)) {
	echo "".$chat."\n";
	if (!empty($_POST['msg'])) {
		if ($_POST['msg'] === "/help") {
			$cmdhelp = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
			echo "[Du] » /help\n===========[".command_help_title."]===========\n+ /clear >> ".command_clear_description."\n+ /help >> ".command_help_description."\n+ /bot >> ".command_bot_description."\n";
			foreach ($cmdhelp->query("SELECT * FROM commands") as $helpcmd) {
				echo "+ /".$helpcmd['command']." >> ".$helpcmd['beschreibung']."\n";
			}
		$_POST['msg'] = "";
		echo "===========[".command_help_title."]===========";
	}
}
	if (!empty($_POST['msg'])) {
		if ($_POST['msg'] === "/bot") {
			echo "[Du] » /bot\n===========[".command_action_bot_title."]===========\n+ ".command_action_bot_software." >> SmarterBot\n+ ".command_action_bot_version." >> ".$version."\n+ ".command_action_bot_creator." >> StackNeverFlow\n+ ".command_action_bot_github." >> https://github.com/StackNeverFlow/SmarterBot\n===========[".command_action_bot_title."]===========";

			$_POST['msg'] = "";
		}
	}
		if (!empty($_POST['msg'])) {
			$cmd = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
			foreach ($cmd->query("SELECT * FROM commands") as $ccmd) {
			if ($_POST['msg'] === "/".$ccmd['command']."") {
				echo "[Du] » ".$ccmd['command']."\n".$ccmd['antwort']."";
				$_POST['msg'] = "";
			}
			}
		}
} else {
	echo "[".$botname."] » ".main_welcome."";
}
if (!empty($_POST['msg'])) {
	echo "[Du] » ".$_POST['msg']."\n";
	if (strpos($_POST['msg'], "/") === 0) {
		echo command_unknown;
	} else {
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbbase);
$result = $mysqli->query("SELECT * FROM keywords WHERE Locate(keyword,'%".$_POST['msg']."%')!=0");
if($result->num_rows > 0) {
foreach ($mysql->query("SELECT * FROM keywords WHERE Locate(keyword,'%".$_POST['msg']."%')!=0") as $row) {

	echo "[".$botname."] » ".$row['text']."";
}} else {

	echo "[".$botname."] » ".main_no_answer."";

}
}
}
?>
</textarea>
<input name="msg" id='msg' type="text" placeholder="<?php echo main_msg_placeholder ?>" required></input>
<button class="button" type="submit"><span><?php echo main_button_send ?></span></button>
</form>
</center>
</div>
</div>
</body>
<footer>
<p align="center"><font color="grey" size="5"><?php echo copyright_software ?> <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - <?php echo copyright_by ?> <a href="https://twitter.com/StackNeverFlow">StackNeverFlow</a></font></p>
</footer>
</html>
