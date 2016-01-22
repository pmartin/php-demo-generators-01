<?php
namespace Demo;

class RecordParser
{
    const SIZEOF_LANGUAGE = 2;
    const SIZEOF_BOOK_ID = 4;

    /**
     * @param Record $record
     * @param \SplFileObject $file
     */
    public function parseRecord(Record $record, \SplFileObject $file)
    {
        // Le header d'un enregistrement fait 2 octets (la taille du record est un enier sur 2 octets).
        // => Le charger en mémoire "en entier" est tout à fait acceptable
        $dataHeader = new DataContainer($file->fread(2));
        $record->setSize($dataHeader->readShort());

        // Les données d'un enregistrement font au maximum 64KB
        // (puisque leur taille est stockée sur 2 octets)
        // => les charger intégralement en mémoire est acceptable
        // (tant que c'est pour 1 record ; et pas pour tous ceux que peut contenir un fichier)
        $data = new DataContainer($file->fread($record->getSize()));

        $record->setNumberOfBooks($data->readShort());

        /* @var RecordBook[] $books */
        $books = [];
        for ($iBook = 0; $iBook < $record->getNumberOfBooks(); $iBook++) {
            $book = new RecordBook();

            $book->setBookId($data->readBytes(self::SIZEOF_BOOK_ID));

            $language = trim($data->readBytes(self::SIZEOF_LANGUAGE));
            $book->setLanguage(empty($language) ? null : $language);

            $book->setAuthors($data->readArrayOfCStrings());
            $book->setMimeType($data->readCString());
            $book->setCategories($data->readArrayOfCStrings());
            $book->setFilesize($data->readLong());

            $rawBookInfo = $data->readFixedSizeArrayOfCStrings(4, false);
            $book->setFilename($rawBookInfo[0]);
            $book->setTitle($rawBookInfo[1]);
            $book->setPublisher($rawBookInfo[2]);
            $book->setIdentifier($rawBookInfo[3]);

            $books[] = $book;
        }
        $record->setBooks($books);
    }

}