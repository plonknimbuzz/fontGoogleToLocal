<form method="post">
Inpput google fonts url here :
<input type="text" name="url" value="https://fonts.googleapis.com/css?family=Roboto:400,700|Oswald|Lato:700"/> <input type="submit" value="download"/>
</form>

<?php 
if(!empty($_POST['url']))
{
	set_time_limit(120);
	require_once("fontGoogleToLocal.php");
	$Obj = new fontGoogleToLocal;
	$Obj->setForceReplace(true); //optional
	$Obj->setLink($_POST['url']);
	$Obj->getCss();
	
	
	$folder = array("css","font");
	foreach($folder as $dir)
	{
		$dir = "file/$dir";
		if($handle = opendir($dir))
		{		
			echo "List directory $dir<br><ul>";
			while(false !== $entry = readdir($handle))
			{
				if($entry != "." && $entry != "..") echo "<li><a href=\"$dir/$entry\" target=\"blank\">$entry</a></li>";
			}
			echo "</ul>";
			closedir($handle);
		}
		else echo "cant open folder: $dir";
	}
}

?>
