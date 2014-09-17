<?php

include dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use RecipeFinder\Finder;
use RecipeFinder\CsvFileIterator;

$options = getopt("f:j:h::");

if (isset($options['h'])) {
    echo <<<_END_
Options
    -f filepath   (e.g. /home/user/fridge.csv)
    -j json 
_END_;
    exit;
}

if (!isset($options['f']) || !file_exists($options['f']) || filesize($options['f']) == 0)  {
    exit("Please provide a valid csv file of fridge items \n");
}

if (!isset($options['j']) || !file_exists($options['j']) || !$json = file_get_contents($options['j'])) {
    exit("Please provide a valid json file of the recipes \n");
}

$fridgeItems = new CsvFileIterator($options['f']);
$recipes     = json_decode($json, true);

$recipeFinder = new Finder($recipes, $fridgeItems);

$dinner = $recipeFinder->findRecipe();

echo <<<_END_
    For Dinner best choise is:
        {$dinner}
    Enjoy!!
_END_;
