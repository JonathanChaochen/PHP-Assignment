<?php


if( isset($_SESSION['lang']) ){
  $locale = $_SESSION['lang'];
} else {
  $locale = 'en';
}

// echo $_SESSION['lang'];

$lang = new LanguageParser($locale);


