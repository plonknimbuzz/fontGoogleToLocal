# fontGoogleToLocal
fontGoogleToLocal is a PHP library to save fonts and css from given google fonts link. This is usefull for develper that need save google font locally for offline purpose. This library is simple and easy to use.

### History
I likely to writing script anytime and anywhere even from android. And i like google font cdn very much, But sometimes, i need them to be locally because i often wrote code in offline condition. So i think it's maybe usefull to create library for download them for my development purpose. 

### Features
  - Save CSS (only support 1 font link per use, see exception) 
  - Save all fonts from writen CSS

### Exception
this version only support single font link. ex:
- "http://fonts.googleapis.com/css?family=Oswald" or
- "https://fonts.googleapis.com/css?family=Roboto:400,700"

You can not use multiple font link. ex: 
- "http://fonts.googleapis.com/css?family=Oswald|Roboto" or	
- "https://fonts.googleapis.com/css?family=Roboto:400,700|Oswald|Lato:700"	

This version will replace same font css if you use setForceReplace(true). If you use setForceReplace(false) you cant save them 
	
future release will get rid those problem. 

### Requirement
  - PHP
  - Curl PHP ext

### How to use
```
<?php
    require_once("fontGoogleToLocal.php");
	$Obj = new fontGoogleToLocal;
	$Obj->setLink("https://fonts.googleapis.com/css?family=Roboto:400,700");
	$Obj->getCss();
?>
```
See Example for demo


### Method
| Method | Type | Description |
| ------ | ------ | ------ |
| setLink($link) | string | [REQUIRED] set link google font. ex: https://fonts.googleapis.com/css?family=Roboto:400,700 |
| getCss() | None | Start download CSS and Font |
| setFolderRoot($dir) | string | Set root folder for save CSS directory and Font directory. Default: "file" |
| setFolderCss($dir) | string | Set folder for save css file. Default: "css" |
| setFolderFont($str) | string | Set folder for save font file. Default: "font" |
| setForceReplace($boolean) | boolean | if set true, will force replace if file existing. Default: false |
| setUserAgent($userAgent) | string | set user agent. Default: "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36" |

### Changelog
2017-03-09 v1  initial release

