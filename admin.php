<?php
if (!file_exists("extra/config.php")) {
	header("Location: setup.php");
	exit;
}
require("extra/config.php");
require("lang/".$lang.".php");
?>
<html>
<head>
	<link rel="stylesheet" href="extra/style.css">
	<title><?php if (!empty($title)) { echo "".title_acp." | ".$title.""; } else { echo "".title_acp." | KuschelSupportbot"; } ?></title>
  <style>
  input, button, select {
    width: 100%;
  }
  </style>
</head>
<body>
	<div class="flex">
<?php
session_start();
  if(!isset($_SESSION['loggedin'])) {
    echo "<div class='flex-item login'>";
    if(isset($_POST['passwortlogin'])) {
      if (hash('sha256',hash('sha256',$_POST['passwortlogin'])) == $password) {
        $_SESSION['loggedin'] = "true";
      } else {
        echo "<div class='error'>".acp_login_password_wrong."</div>";
      }
    }
    echo "<h1>".acp_login_login_title."</h1><hr><br><form action='admin.php' method='post'><input type='password' name='passwortlogin' placeholder='".acp_login_password."' required><br>
          <button type='submit'>".acp_login_login_action."</button></form></div></div></body>
          <footer>
          <p align='center'><font color='grey' size='5'>".copyright_software." <a href='https://github.com/Kuschel-Swein/KuschelSupportbot'>KuschelSupportbot</a> - ".copyright_by." <a href='https://twitter.com/Kuschel_Swein'>Kuschel_Swein</a></font></p>
          </footer></html>";
    exit;
  }
if(isset($_GET['delete'])) {
  if (!empty($_GET['id'])) {
      if(isset($_GET['confirm'])) {
        try {
        $mysqlkill = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
        $mysqlkill->query("DELETE FROM keywords WHERE id = '".$_GET['id']."'");
	      header("Location: admin.php");
        } catch (PDOException $e){ echo "<div class='error'>Es konnte keine Datenbankverbindung hergestellt werden.</div>";
        }
      }
    echo "<div class='flex-item login'><h1>".acp_keywords_list_delete_sure_1." ".$_GET['id']." ".acp_keywords_list_delete_sure_2."</h1><hr><br><form action='admin.php?delete&id=".$_GET['id']."&confirm' method='post'><br>
          <button type='submit'>".acp_keywords_list_delete."</button></form></div></div></body>
          <footer>
          <p align='center'><font color='grey' size='5'>".copyright_software." <a href='https://github.com/Kuschel-Swein/KuschelSupportbot'>KuschelSupportbot</a> - ".copyright_by." <a href='https://twitter.com/Kuschel_Swein'>Kuschel_Swein</a></font></p>
          </footer></html>";
    exit;
  }
}
if (isset($_GET['addkey'])) {
  if (isset($_POST['keyword'])) {
    if (isset($_POST['textout'])) {
      $mysqladd = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
      $mysqladd->query("INSERT INTO keywords (`keyword`,`text`) VALUES ('".$_POST['keyword']."','".$_POST['textout']."')");
      header("Location: admin.php");
    }
  }
}
if (isset($_GET['command'])) {
  if (isset($_GET['add'])) {
    $mysqladdcmd = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
    $mysqladdcmd->query("INSERT INTO commands (`command`,`antwort`,`beschreibung`) VALUES ('".$_POST['cmd']."','".$_POST['antwortcmd']."','".$_POST['besch']."')");
    header("Location: admin.php");
  }
  if (isset($_GET['remove'])) {
    $mysqlremcmd = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
    $mysqlremcmd->query("DELETE FROM commands WHERE id = '".$_POST['selcmd']."'");
    header("Location: admin.php");
  }
  if (isset($_POST['aktion'])) {
    if ($_POST['aktion'] == "add") {
      echo "<div class='flex-item login'><h1>".acp_commands_add_command_title."</h1><hr><br><form action='admin.php?command&add' method='post'><br>
            <input type='text' name='cmd' placeholder='".acp_commands_add_instert_command_without_slash."' required>
            <input type='text' name='antwortcmd' placeholder='".acp_commands_add_answer."' required>
            <input type='text' name='besch' placeholder='".acp_commands_add_description."' required>
            <button type='submit'>".acp_commands_add_add_title."</button><br><h4>".acp_commands_add_hint."</h4></form></div></div></body>
            <footer>
            <p align='center'><font color='grey' size='5'>".copyright_software." <a href='https://github.com/StackNeverFlow/SmarterBot'>SmarterBot</a> - ".copyright_by." <a href='https://twitter.com/StackNeverFlow'>StackNeverFlow</a></font></p>
            </footer></html>";
            exit;
    }
    if ($_POST['aktion'] == "remove") {
      echo "<div class='flex-item login'><h1>".acp_commands_remove_command_title."</h1><hr><br><form action='admin.php?command&remove' method='post'><br>
            <select name='selcmd'>";
      $mysqlcmdlist = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
        foreach ($mysqlcmdlist->query("SELECT * FROM commands") as $cmdrow) {
          echo "<option value='".$cmdrow['id']."'>".$cmdrow['command']."</option>";
        }
      echo "</select><button type='submit'>".acp_commands_remove_delete_command."</button></form></div></div></body>
            <footer>
            <p align='center'><font color='grey' size='5'>".copyright_software." <a href='https://github.com/StackNeverFlow/SmarterBot'>SmarterBot</a> - ".copyright_by." <a href='https://twitter.com/StackNeverFlow'>StackNeverFlow</a></font></p>
            </footer></html>";
            exit;
    }
  }
}
?>
<div class="flex-item">
  <h1><?php echo acp_keywords_add_title ?></h1>
  <hr><br>
<form action="admin.php?addkey" method="post">
<input type="text" name="keyword" placeholder="<?php echo acp_keywords_enter_keyword ?>" required>
<input type="text" name="textout" placeholder="<?php echo acp_keywords_enter_answer ?>" required>
<button type="submit"><?php echo acp_keywords_add ?></button>
</form>
</div>
<div class="flex-item side">
<h1><?php echo acp_commands_title ?></h1>
<hr><br>
<form action="admin.php?command" method="post">
<h4><?php echo acp_commands_select_action ?></h4>
<select name="aktion">
  <option value="add"><?php echo acp_commands_select_action_add ?></option>
  <option value="remove"><?php echo acp_commands_select_action_remove ?></option>
</select>
<button type="submit"><?php echo acp_commands_select_action_go_on ?></button>
</form>
</div>
</div>
<div class="flex">
  <div class="flex-item side">
<h1><?php echo acp_lang_info_title ?></h1><hr>
<i><?php echo acp_lang_info_lang ?></i> <div class="flag flag-<?php echo $settings['langcode']; ?>"></div><br>
<i><?php echo acp_lang_info_langversion ?></i> <?php echo $settings['version']; ?><br>
<i><?php echo acp_lang_info_translator ?></i> <?php echo $settings['translator']; ?><br>
<i><?php echo acp_lang_info_webpage_of_translator ?></i> <a target="_blank" href="<?php echo $settings['webpage']; ?>"><?php echo $settings['webpage']; ?></a>
</div>
  <div class="flex-item">
    <h1><?php echo acp_keywords_list_title ?></h1>
    <hr><br>
<?php
try {
$mysql = new PDO("mysql:host=$dbhost:3306;dbname=$dbbase", $dbuser, $dbpass);
echo "<table><tbody><tr><th>".acp_keywords_list_id."</th><th>".acp_keywords_list_keyword."</th><th>".acp_keywords_list_result."</th><th>".acp_keywords_list_action."</th></tr></tbody>";
foreach ($mysql->query("SELECT * FROM keywords") as $row) {
  echo "<tr><td>".$row['id']."</td><td>".$row['keyword']."</td><td>".$row['text']."</td><td><a href='admin.php?delete&id=".$row['id']."'><i>".acp_keywords_list_delete_table."</i></td></tr>";
}
echo "</table>";
} catch (PDOException $e){ echo "<div class='error'>Es konnte keine Datenbankverbindung hergestellt werden.</div>";
}

?>
  </div>

</div>
</body>
<footer>
  <p align="center"><font color="grey" size="5"><?php echo copyright_software ?> <a href="https://github.com/StackNeverFlow/SmarterBot">SmarterBot</a> - <?php echo copyright_by ?> <a href="https://twitter.com/StackNeverFlow">StackNeverFlow</a></font></p>
<br>
</footer>
</html>
