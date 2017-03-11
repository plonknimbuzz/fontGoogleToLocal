# fontGoogleToLocal
fontGoogleToLocal is a PHP library to save fonts and css from given google fonts link. This is usefull for develper that need save google font locally for offline purpose. This library is simple and easy to use.

### History
I likely to writing script anytime and anywhere even from android. And i like google font cdn very much, But sometimes, i need them to be locally because i often wrote code in offline condition. So i think it's maybe usefull to create library for download them for my development purpose. 

### Features
  - Save single or multiple CSS font 
  - Save all fonts from writen CSS

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
See **Example** for demo


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
| getListFile() | none | get list all file (css and fonts) |

### Changelog

**2017-03-11 : v1.3**
- add function to return list file css and font. example: for delete all file, or for zip creation

**2017-03-10 : v1.2**
- support multiple fonts, ex: "https://fonts.googleapis.com/css?family=Roboto:400,700|Oswald|Lato:700"
- not replace same font with different font weight/style. ex: Roboto:400,700 css will not replaced by Roboto:400,600i,700,800

**2017-03-09 : v1.0** 
- initial release
