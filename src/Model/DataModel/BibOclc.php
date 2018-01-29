<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\DB;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\CreateTrait;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;
use Slim\PDO\Statement\SelectStatement;

class BibOclc extends DataModel implements ReadInterface
{
    use TranslateTrait, CreateTrait;

    public $id = '';

    public $nyplSource = '';

    public $workId = [];

    public $oclcId = [];

    public $createdDate = '';

    public function getIdFields()
    {
    }

    public function create($useId = false)
    {
    }

    /**
     * @return SelectStatement
     */
    protected function getSingleSelect()
    {
        $selectStatement = DB::getDatabase()->select()
            ->from($this->getTableName())
            ->join('bib', 'bib.id', '=', 'bib_oclc.id');

        $this->applyFilters($this->getFilters(), $selectStatement);

        return $selectStatement;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $workId
     *
     * @return array
     */
    public function translateWorkId($workId = '')
    {
        return json_decode($workId, true);
    }

    /**
     * @return array
     */
    public function getWorkId(): array
    {
        return $this->workId;
    }

    /**
     * @param array $workId
     */
    public function setWorkId(array $workId)
    {
        $this->workId = $workId;
    }

    /**
     * @param string $oclcId
     *
     * @return array
     */
    public function translateOclcId($oclcId = '')
    {
        return json_decode($oclcId, true);
    }

    /**
     * @return array
     */
    public function getOclcId(): array
    {
        return $this->oclcId;
    }

    /**
     * @param array $oclcId
     */
    public function setOclcId(array $oclcId)
    {
        $this->oclcId = $oclcId;
    }

    /**
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    /**
     * @param string $createdDate
     */
    public function setCreatedDate(string $createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return string
     */
    public function getNyplSource(): string
    {
        return $this->nyplSource;
    }

    /**
     * @param string $nyplSource
     */
    public function setNyplSource(string $nyplSource)
    {
        $this->nyplSource = $nyplSource;
    }
}
