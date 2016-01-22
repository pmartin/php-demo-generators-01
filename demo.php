<?php
require_once __DIR__ . '/vendor/autoload.php';

//$file = new SplFileObject('data/one-book.dat', 'r');
$file = new SplFileObject('data/several-books.dat', 'r');
$recordParser = new Demo\FileParser($file);

foreach ($recordParser->parseFile() as $record) {
    var_dump($record);
}

