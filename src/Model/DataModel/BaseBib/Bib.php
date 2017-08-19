<?php
namespace NYPL\Services\Model\DataModel\BaseBib;

use NYPL\Services\Model\DataModel\BaseBib;
use NYPL\Starter\Config;
use NYPL\Starter\Model\ModelInterface\DeleteInterface;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\DBCreateTrait;
use NYPL\Starter\Model\ModelTrait\DBDeleteTrait;
use NYPL\Starter\Model\ModelTrait\DBReadTrait;
use NYPL\Starter\Model\ModelTrait\DBUpdateTrait;
use NYPL\Starter\SchemaClient;

/**
 * @SWG\Definition(title="Bib", type="object", required={"id"})
 */
class Bib extends BaseBib implements MessageInterface, ReadInterface, DeleteInterface
{
    use DBCreateTrait, DBReadTrait, DBDeleteTrait, DBUpdateTrait;

    public function getStreamName()
    {
        return Config::get('BIB_STREAM_NAME');
    }

    public function getSchema()
    {
        return SchemaClient::getSchema('Bib')->getSchema();
    }

    public function getIdFields()
    {
        return ["nyplSource", "id"];
    }

    public function getSequenceId()
    {
        return "";
    }
}
