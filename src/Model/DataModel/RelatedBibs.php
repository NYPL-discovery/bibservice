<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Services\Model\DataModel\SimpleBib;
use NYPL\Starter\DB;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\CreateTrait;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

class RelatedBibs extends DataModel implements ReadInterface
{
    use TranslateTrait, CreateTrait;

    /**
     * @var BibOclc
     */
    public $bibOclc;

    /**
     * @var Bib[]
     */
    public $bibs = [];

    /**
     * @var SimpleBib[]
     */
    public $simpleBibs = [];

    public function getIdFields()
    {
    }

    public function create($useId = false)
    {
    }

    /**
     * @return string
     */
    protected function getStatement()
    {
        $orStatement = '';

        foreach ($this->getBibOclc()->workId as $workId) {
            $orStatement .= 'jsonb_contains(bib_oclc.work_id, ' . DB::getDatabase()->quote($workId) . ') OR ';
        }

        $orStatement = substr($orStatement, 0, -3);

        $statement = 'SELECT bib_oclc.*, bib.*
        FROM bib_oclc
        INNER JOIN bib ON bib.id = bib_oclc.id
        WHERE bib.id != ' . DB::getDatabase()->quote($this->getBibOclc()->getId()) . ' AND (' . $orStatement . ')';

        return $statement;
    }

    /**
     * @param SimpleBib $simpleBib
     * @param array $varFields
     */
    protected function extractVarFields(SimpleBib $simpleBib, $varFields = [])
    {
        /**
         * @var VarField $varField
         */
        foreach ($varFields as $varField) {
            if ($varField->getFieldTag() === 'b' && $varField->getMarcTag() === '710' && !$simpleBib->getPublisher()) {
                $simpleBib->setPublisher($varField->getSubfields()[0]->getContent());
            }

            if ($varField->getFieldTag() === 'i' && $varField->getMarcTag() === '020') {
                $simpleBib->addIsbn(strtok($varField->getSubfields()[0]->getContent(), ' '));
            }
        }
    }

    public function read($ignoreNoRecord = false)
    {
        $results = DB::getDatabase()->query($this->getStatement());

        foreach ($results->fetchAll() as $record) {
            $bib = new Bib($record);

            $simpleBib = new SimpleBib();

            $simpleBib->setId($bib->getId());
            $simpleBib->setTitle($bib->getTitle());
            $simpleBib->setAuthor($bib->getAuthor());
            $simpleBib->setMaterialType($bib->getMaterialType()->getValue());
            $simpleBib->setPublishYear($bib->getPublishYear());

            if ($bib->getLang()) {
                $simpleBib->setLanguage($bib->getLang()->getName());
            }

            $this->extractVarFields($simpleBib, $bib->getVarFields());

            $this->bibs[] = $bib;
            $this->simpleBibs[] = $simpleBib;
        }
    }


    /**
     * @return BibOclc
     */
    public function getBibOclc(): BibOclc
    {
        return $this->bibOclc;
    }

    /**
     * @param BibOclc $bibOclc
     */
    public function setBibOclc(BibOclc $bibOclc)
    {
        $this->bibOclc = $bibOclc;
    }

    /**
     * @return Bib[]
     */
    public function getBibs(): array
    {
        return $this->bibs;
    }

    /**
     * @param Bib[] $bibs
     */
    public function setBibs(array $bibs)
    {
        $this->bibs = $bibs;
    }

    /**
     * @return SimpleBib[]
     */
    public function getSimpleBibs(): array
    {
        return $this->simpleBibs;
    }

    /**
     * @param SimpleBib[] $simpleBibs
     */
    public function setSimpleBibs(array $simpleBibs)
    {
        $this->simpleBibs = $simpleBibs;
    }
}
