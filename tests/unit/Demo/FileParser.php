<?php
namespace tests\unit\Demo;

use \mageekguy\atoum;
use Demo\FileParser as TestedClass;

class FileParser extends atoum\test
{

public function testParseFileReturnsAnIterator()
{
    $this->object($parser = new TestedClass($this->getEmptySplFileObject()));

    // Je veux pouvoir itérer sur ce que me renvoie parseFile.
    // => j'ai besoin que ce soit un Iterator.
    // Et je n'ai pas besoin que ce soit spécifiquement un Generator (qui extends Iterator)
    $this->object($iterator = $parser->parseFile())->isInstanceOf(\Iterator::class);
}

public function testParseFileIteratorIteratesOverRecords()
{
    $this->object($parser = new TestedClass($this->getSplFileObjectWithSeveralRecords()));
    $this->object($iterator = $parser->parseFile());

    // On a un premier enregistrement
    $this->object($iterator->current())
        ->isInstanceOf(\Demo\Record::class);

    // Puis un second
    $this->variable($iterator->next())
        ->object($iterator->current())
        ->isInstanceOf(\Demo\Record::class);
}

public function ParseFileIteratorIteratesUntilTheEndOfTheFile()
{
    $this->object($parser = new TestedClass($this->getSplFileObjectWithSeveralRecords()));
    $this->object($iterator = $parser->parseFile());

    // On boucle sur toutes les données de l'itérateur ; pas de Fatal, pas d'exception, pas de boucle infinie.
    // Et toutes les données de l'itérateur sont des Record
    foreach ($iterator as $record) {
        $this->object($record)->isInstanceOf(\Demo\Record::class);
    }
}


    private function getEmptySplFileObject()
    {
        return new \SplFileObject('php://memory', 'w+');
    }

    private function getSplFileObjectWithSeveralRecords()
    {
        $file = new \SplFileObject('php://memory', 'w+');

        // Enregistrement qui contient un seul livre
        $dataRecord1 = implode('', $originalData = [
            implode('', [
                'bookId' => "\xd5\x3f\x42\x32",
                'language' => "\x65\x6e",
                'authors' => "\x53\x63\x6f\x74\x74\x20\x43\x68\x61\x63\x6f\x6e\x00\x00",
                'mimeType' => "\x2e\x65\x70\x75\x62\x00",
                'categories' => "\x53\x6f\x66\x74\x77\x61\x72\x65\x20\x44\x65\x76\x65\x6c\x6f\x70\x6d\x65\x6e\x74\x00\x00",
                'filesize' => "\x00\x42\x51\x2e",
                'filename' => "\x70\x72\x6f\x67\x69\x74\x2e\x65\x70\x75\x62\x00",
                'title' => "\x50\x72\x6f\x20\x47\x69\x74\x00",
                'publisher' => "\x53\x70\x72\x69\x6e\x67\x65\x72\x00",
                'identifier' => "\x62\x66\x35\x30\x63\x36\x65\x31\x2d\x65\x62\x30\x61\x2d\x34\x61\x31\x63\x2d\x61\x32\x63\x64\x2d\x65\x61\x38\x38\x30\x39\x61\x65\x30\x38\x36\x61\x00",
            ]),
        ]);
        $file->fwrite(pack('n1', strlen($dataRecord1) + 2));  // Taille de l'enregistrement, en octets
        $file->fwrite(pack('n1', 1));  // Nombre de livres
        $file->fwrite($dataRecord1);

        // Enregistrement qui contient deux livres
        $dataRecord2 = implode('', $originalData = [
            implode('', [
                'bookId' => "\x04\x59\x52\x0d",
                'language' => "\x65\x6e",
                'authors' => "\x52\x6f\x6c\x61\x6e\x64\x20\x4d\x61\x73\x00\x00",
                'mimeType' => "\x2e\x65\x70\x75\x62\x00",
                'categories' => "\x00\x00",
                'filesize' => "\x00\x59\xc2\x67",
                'filename' => "\x64\x65\x62\x69\x61\x6e\x2d\x68\x61\x6e\x64\x62\x6f\x6f\x6b\x2e\x65\x70\x75\x62\x00",
                'title' => "\x4c\x65\x20\x63\x61\x68\x69\x65\x72\x20\x64\x65\x20\x6c\x27\x61\x64\x6d\x69\x6e\x69\x73\x74\x72\x61\x74\x65\x75\x72\x20\x44\x65\x62\x69\x61\x6e\x00",
                'publisher' => "\x00",
                'identifier' => "\x37\x5f\x69\x64\x70\x31\x30\x37\x36\x31\x36\x00",
            ]),
            implode('', [
                'bookId' => "\xa9\xb9\x0b\x16",
                'language' => "\x66\x72",
                'authors' => "\x50\x61\x73\x63\x61\x6c\x20\x4d\x41\x52\x54\x49\x4e\x00\x00",
                'mimeType' => "\x2e\x65\x70\x75\x62\x00",
                'categories' => "\x00\x00",
                'filesize' => "\x00\x26\x1d\x84",
                'filename' => "\x64\x65\x76\x65\x6c\x6f\x70\x70\x65\x72\x2d\x75\x6e\x65\x2d\x65\x78\x74\x65\x6e\x73\x69\x6f\x6e\x2d\x70\x68\x70\x2e\x65\x70\x75\x62\x00",
                'title' => "\x44\xc3\xa9\x76\x65\x6c\x6f\x70\x70\x65\x72\x20\x75\x6e\x65\x20\x45\x78\x74\x65\x6e\x73\x69\x6f\x6e\x20\x50\x48\x50\x00",
                'publisher' => "\x6c\x65\x61\x6e\x70\x75\x62\x2e\x63\x6f\x6d\x00",
                'identifier' => "\x68\x74\x74\x70\x73\x3a\x2f\x2f\x6c\x65\x61\x6e\x70\x75\x62\x2e\x63\x6f\x6d\x2f\x64\x65\x76\x65\x6c\x6f\x70\x70\x65\x72\x2d\x75\x6e\x65\x2d\x65\x78\x74\x65\x6e\x73\x69\x6f\x6e\x2d\x70\x68\x70\x00",
            ]),
        ]);
        $file->fwrite(pack('n1', strlen($dataRecord2) + 2));  // Taille de l'enregistrement, en octets
        $file->fwrite(pack('n1', 2));  // Nombre de livres
        $file->fwrite($dataRecord2);

        // On se positionne au début du fichier ;-)
        $file->rewind();

        return $file;

    }

}