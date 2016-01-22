<?php
namespace Demo;

/**
 * @Entity
 * @Table(
 *      name="record_book",
 *      indexes={
 *          @Index(name="idx_book", columns={"book_id"})
 *      }
 * )
 */
class RecordBook
{

    /**
     * @var string
     * @Column(type="binary", length=4, nullable=false, options={"fixed":true})
     */
    private $bookId;

    /**
     * @var string
     * @Column(type="string", length=2, nullable=true, options={"fixed":true})
     */
    private $language;

    /**
     * @var string[]
     * @Column(type="json_array")
     */
    private $authors;

    /**
     * @var string
     * @Column(type="string", length=32)
     */
    private $mimeType;

    /**
     * @var string[]
     * @Column(type="json_array")
     */
    private $categories;

    /**
     * @var int
     * @Column(type="integer", nullable=false, options={"unsigned":true})
     */
    private $filesize;

    /**
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    private $filename;

    /**
     * @var string
     * @Column(type="string", length=256, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Column(type="string", length=256, nullable=true)
     */
    private $publisher;

    /**
     * @var string
     * @Column(type="string", length=256, nullable=true)
     */
    private $identifier;

    /**
     * @return string
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param string $bookId
     *
     * @return RecordBook
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return RecordBook
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param \string[] $authors
     *
     * @return RecordBook
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return RecordBook
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \string[] $categories
     *
     * @return RecordBook
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return int
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param int $filesize
     *
     * @return RecordBook
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return RecordBook
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return RecordBook
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     *
     * @return RecordBook
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return RecordBook
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

}