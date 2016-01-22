<?php
namespace Demo;

class FileParser
{
    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @var RecordParser
     */
    private $recordParser;


    /**
     * FileParser constructor.
     * @param \SplFileObject $file
     */
    public function __construct(\SplFileObject $file)
    {
        $this->file = $file;
        $this->recordParser = new RecordParser();
    }


    /**
     * @return \Generator|void
     */
    public function parseFile()
    {
        while (true) {
            try {
                $record = new Record();
                $this->recordParser->parseRecord($record, $this->file);

                yield $record;
            } catch (\OutOfBoundsException $e) {
                // Utiliser une exception pour le contrôle de la boucle (pour la quitter en fin de fichier),
                // ce n'est pas très élégant...
                // Mais elle était levée (on vérifie, en lisant des données, qu'on n'est pas en fin du fichier)
                // et c'était pratique de la réutiliser pour ça (même si "peu élégant", le but est atteint)
                return;
            }
        }
    }

}
