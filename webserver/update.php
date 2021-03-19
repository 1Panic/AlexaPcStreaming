<?php

$config = include 'config.php';

$ip = $_GET['ip'];
$update = $_GET['update'];
$ClientIP = $_SERVER['REMOTE_ADDR'];

echo "Last IP: " . $config['streamIP'] . "<br><br>";

if ($update == true)
{
$config['streamIP'] = $ip;
file_put_contents('config.php', '<?php return ' . var_export($config, true) . ';');
echo "Update ip to: " . $ip ."<br>";
}

?>

<html>
<body>
<br>
<form action="update.php" method="get">
New Target IP: <input type="text" name="ip" value="<?php echo $ClientIP; ?>" /><br />
<input type="hidden" id="update" name="update" value="true">
<br>
<input type="Submit" value="Update IP" style="height:100px; width:100%" />
</form>
</body>
</html> 