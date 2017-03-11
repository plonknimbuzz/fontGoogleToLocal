<?php
class fontGoogleToLocal
{
	/*
		FontGoogleToLocal v1.0
		use with your own risk
		see documentation : http://github.com/plonknimbuzz/fontgoogletolocal
		contact: plonknimbuzz@gmail.com
	*/
	
	private $link;
	private $folderRoot="file";
	private $folderCss="css";
	private $folderFont="font";
	private $forceReplace=false;
	private $userAgent="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
	private $listFileCss = array();
	private $listFileFont = array();
	
	private function createFolder()
	{
		if(!is_dir($this->folderRoot)) mkdir($this->folderRoot);
		if(!is_dir($this->folderRoot."/".$this->folderCss)) mkdir($this->folderRoot."/".$this->folderCss);
		if(!is_dir($this->folderRoot."/".$this->folderFont)) mkdir($this->folderRoot."/".$this->folderFont);
	}
	
	private function fetchLink()
	{
		if(preg_match("/^http?s:\/\/fonts.googleapis.com\/css\?family=(.*)/",$this->link, $match))
		{
			$exp = explode('|', $match[1]);
			$result = array("cssName"=>array(), "link"=>array());
			foreach($exp as $font)
			{
				$result['link'][] = "http://fonts.googleapis.com/css?family=".$font;
				$result['cssName'][] = str_replace(array("+",",",":"),array("-","_","_"),$font);
			}
			return $result;
		}
		else
			die("you must supply valid google fonts link");
	}
	
	public function getCss()
	{
		$listLink = $this->fetchLink();
		for($e=0; $e < count($listLink['link']);$e++)
		{			
			$originCss = $this->download($listLink['link'][$e]);
			$data = $this->fetchCss($originCss);
			for($i=0; $i<count($data['url']);$i++)
			{
				$fontName = $this->setFileName($data['fontFamily'][$i], $data['fontStyle'][$i], $data['fontWeight'][$i], $data['charType'][$i], $data['url'][$i]);
				$this->saveFont($fontName, $this->download($data['url'][$i]));
				$this->listFileFont[] = $this->folderRoot."/".$this->folderFont."/".$fontName;
				$originCss = str_replace($data['url'][$i], "../".$this->folderFont."/".$fontName, $originCss);
			}
			$cssName = $listLink['cssName'][$e].".css";
			$this->saveCss($cssName, $originCss);
			$this->listFileCss[] = $this->folderRoot."/".$this->folderCss."/".$cssName;
		}
	}
	
	public function getListFile()
	{
		return array_merge($this->listFileCss,$this->listFileFont);
	}
	
	private function setFileName($fontFamily, $fontStyle, $fontWeight, $charType, $url)
	{
		/*
			fontFamily_fontStyle_fontWeight_charType.Extension
		*/
		$ext = explode('.', $url);
		return str_replace(" ", "-", $fontFamily)."_".$fontStyle."_".$fontWeight."_".$charType.".".end($ext);
	}
	
	private function saveFont($filename, $content)
	{
		if(!is_dir($this->folderFont)) $this->createFolder();
		if(!is_file($this->folderFont."/".$filename) || $this->forceReplace)
			file_put_contents($this->folderRoot."/".$this->folderFont."/".$filename, $content);
		else
			echo "skipped existing file: $fiename<br>";
	}

	private function saveCss($filename, $content)
	{
		if(!is_dir($this->folderCss)) $this->createFolder();
		if(!is_file($this->folderCss."/".$filename) || $this->forceReplace)
			file_put_contents($this->folderRoot."/".$this->folderCss."/".$filename, $content);
		else
			echo "skipped existing file: $fiename<br>";
	}
	
	
	private function fetchCss($css)
	{
		/*
			i fetch all of these for future release v2
		*/
		$result = array(
			"charType" => array(),
			"fontFamily" => array(),
			"fontStyle" => array(),
			"fontWeight" => array(),
			"url" => array(),
			"unicodeRange" => array(),
		);
		
		preg_match_all("/\/\* (.*) \*\//", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['charType'][] = $match;
			}
		}
		else
			die("char type not found");

		preg_match_all("/font-family: '(.*)';/", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['fontFamily'][] = $match;
			}
		}
		else
			die("font family not found");

		
		preg_match_all("/font-style: (.*);/", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['fontStyle'][] = $match;
			}
		}
		else
			die("font style not found");

		preg_match_all("/font-weight: (.*);/", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['fontWeight'][] = $match;
			}
		}
		else
			die("font weight not found");

		preg_match_all("/url\(([^)]+)\)/", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['url'][] = $match;
			}
		}
		else
			die("link fonts not found");

		preg_match_all("/unicode-range: (.*);/", $css, $matches);
		if(!empty($matches[1]) && count($matches[1]) >0)
		{
			foreach($matches[1] as $match)
			{
				$result['unicodeRange'][] = $match;
			}
		}
		else
			die("unicode range not found");
		
		return $result;
	}
	
	public function setLink($link)
	{
		$this->link = $link;
	}
	
	public function setFolderRoot($dir)
	{
		$this->folderRoot = $dir;
	}
	
	public function setFolderCss($dir)
	{
		$this->folderCss = $dir;
	}

	public function setFolderFont($dir)
	{
		$this->folderFont = $dir;
	}
	
	public function setForceReplace($forceReplace)
	{
		$this->forceReplace = $forceReplace;
	}

	public function setUserAgent($userAgent)
	{
		$this->userAgent = $userAgent;
	}
	
	private function download($link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
		$content = curl_exec ($ch);
		curl_close ($ch);
		return $content;
	}
	
}
?>
