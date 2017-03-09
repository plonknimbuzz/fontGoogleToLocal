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
		
	private function createFolder()
	{
		if(!is_dir($this->folderRoot)) mkdir($this->folderRoot);
		if(!is_dir($this->folderRoot."/".$this->folderCss)) mkdir($this->folderRoot."/".$this->folderCss);
		if(!is_dir($this->folderRoot."/".$this->folderFont)) mkdir($this->folderRoot."/".$this->folderFont);
	}
	
	public function getCss()
	{
		$originCss = $this->download($this->link);
		$data = $this->fetchCss($originCss);
		for($i=0; $i<count($data['url']);$i++)
		{
			$filename = $this->setFileName($data['fontFamily'][$i], $data['fontStyle'][$i], $data['fontWeight'][$i], $data['charType'][$i], $data['url'][$i]);
			$this->saveFont($filename, $this->download($data['url'][$i]));
			$originCss = str_replace($data['url'][$i], "../".$this->folderFont."/".$filename, $originCss);
		}		
		$this->saveCss($data['fontFamily'][0].".css", $originCss);
	}
	
	private function setFileName($fontFamily, $fontStyle, $fontWeight, $charType, $url)
	{
		/*
			fontFamily_fontStyle_fontWeight_charType.Extension
		*/
		$ext = explode('.', $url);
		return $fontFamily."_".$fontStyle."_".$fontWeight."_".$charType.".".end($ext);
	}
	
	private function saveFont($filename, $content)
	{
		if(!is_dir($this->folderFont)) $this->createFolder();
		if(!is_file($this->folderFont."/".$filename) || $this->forceReplace)
			file_put_contents($this->folderRoot."/".$this->folderFont."/".$filename, $content);
		else
			die("error: file exists. Use setForceReplace to force replace existing file.");
	}

	private function saveCss($filename, $content)
	{
		if(!is_dir($this->folderCss)) $this->createFolder();
		if(!is_file($this->folderCss."/".$filename) || $this->forceReplace)
			file_put_contents($this->folderRoot."/".$this->folderCss."/".$filename, $content);
		else
			die("error: file exists. Use setForceReplace to force replace existing file.");
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
