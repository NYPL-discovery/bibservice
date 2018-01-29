<?php
namespace NYPL\Services\Model\DataModel;

/**
 * @SWG\Definition(title="SimpleBib", type="object", required={"id"})
 */
class SimpleBib
{
    /**
     * @SWG\Property(example="17746307")
     * @var string
     */
    public $id = '';

    /**
     * @SWG\Property(example="Harry Potter and the Chamber of Secrets")
     * @var string
     */
    public $title;

    /**
     * @SWG\Property(example="Rowling, J. K.")
     * @var string
     */
    public $author;

    /**
     * @SWG\Property(example="E-AUDIOBOOK")
     * @var string
     */
    public $materialType = '';

    /**
     * @SWG\Property(example=1999)
     * @var int
     */
    public $publishYear = 0;

    /**
     * @SWG\Property(example="OverDrive, Inc.")
     * @var string
     */
    public $publisher = '';

    /**
     * @SWG\Property(example="Korean")
     * @var string
     */
    public $language = '';

    /**
     * @SWG\Property
     * @var string[]
     */
    public $isbns = [];

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id = '')
    {
        $this->id = $id;
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
     */
    public function setTitle($title = '')
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author = '')
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getMaterialType()
    {
        return $this->materialType;
    }

    /**
     * @param string $materialType
     */
    public function setMaterialType($materialType = '')
    {
        $this->materialType = $materialType;
    }

    /**
     * @return int
     */
    public function getPublishYear()
    {
        return $this->publishYear;
    }

    /**
     * @param int $publishYear
     */
    public function setPublishYear($publishYear)
    {
        $this->publishYear = $publishYear;
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
     */
    public function setPublisher($publisher = '')
    {
        $this->publisher = $publisher;
    }

    /**
     * @return array
     */
    public function getIsbns(): array
    {
        return $this->isbns;
    }

    /**
     * @param array $isbns
     */
    public function setIsbns(array $isbns)
    {
        $this->isbns = $isbns;
    }

    /**
     * @param string $isbn
     */
    public function addIsbn($isbn = '')
    {
        $this->isbns[] = $isbn;
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
     */
    public function setLanguage($language = '')
    {
        $this->language = $language;
    }
}
