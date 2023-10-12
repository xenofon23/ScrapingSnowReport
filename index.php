<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require_once "../vendor/autoload.php";
require_once "Scraping.php";
$scraping=new Scraping();
$lifts=$scraping->getSnowReportPage('seli');
print_r($lifts);