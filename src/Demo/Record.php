<?php
namespace Demo;

/**
 * @Entity
 * @Table(
 *      name="record"
 * )
 */
class Record
{
    /**
     * @var int
     * @Column(type="integer", nullable=false, options={"unsigned":true})
     */
    protected $size;

    /**
     * @var int
     * @Column(type="integer", nullable=false, options={"unsigned":true})
     */
    private $numberOfBooks;

    /**
     * @var RecordBook[]
     *
     * @OneToMany(targetEntity="RecordBook", mappedBy="record", cascade={"persist"})
     */
    private $books;

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return Record
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfBooks()
    {
        return $this->numberOfBooks;
    }

    /**
     * @param int $numberOfBooks
     *
     * @return Record
     */
    public function setNumberOfBooks($numberOfBooks)
    {
        $this->numberOfBooks = $numberOfBooks;

        return $this;
    }

    /**
     * @return RecordBook[]
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param RecordBook[] $books
     *
     * @return Record
     */
    public function setBooks($books)
    {
        $this->books = $books;

        return $this;
    }

}