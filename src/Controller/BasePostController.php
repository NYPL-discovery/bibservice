<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\DataModel\BasePostRequest;
use NYPL\Services\Model\Response\PostRequestSuccess;
use NYPL\Starter\APIException;
use NYPL\Starter\BulkModels;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Starter\Model;
use NYPL\Starter\ModelSet;

abstract class BasePostController extends Controller
{
    /**
     * @return Model
     */
    abstract protected function getBaseRecord();

    /**
     * @return BasePostRequest
     */
    abstract protected function getPostRequest();

    /**
     * @param string $lastId
     * @param string $nyplSource
     * @param int $limit
     *
     * @return ModelSet
     */
    protected function getRecords($lastId = '', $nyplSource = '', $limit = 0)
    {
        $records = new ModelSet($this->getBaseRecord());

        $records->addFilter(
            new Filter\QueryFilter('id', $lastId, false, '>')
        );
        if ($nyplSource) {
            $records->addFilter(new Filter\QueryFilter('nypl-source', $nyplSource));
        }
        $records->setOrderBy('id');
        $records->setLimit($limit);

        $records->read();

        return $records;
    }

    /**
     * @param ModelSet $modelSet
     *
     * @return string
     */
    protected function getLastId(ModelSet $modelSet)
    {
        /**
         * @var Bib $lastRecord
         */
        $lastRecord = $modelSet->getData()[count($modelSet->getData()) - 1];

        return $lastRecord->getId();
    }

    /**
     * @return \Slim\Http\Response
     * @throws APIException|\RuntimeException
     */
    public function createPostRequest()
    {
        $postRequest = $this->getPostRequest();

        $postRequest->translate($this->getRequest()->getParsedBody());

        if ($postRequest->getLastId() === null) {
            throw new APIException('lastId was not specified', null, 0, null, 400);
        }

        if (!$postRequest->getLimit()) {
            throw new APIException('limit was not specified', null, 0, null, 400);
        }

        $bibs = $this->getRecords($postRequest->getLastId(), $postRequest->getNyplSource(), $postRequest->getLimit());

        $postRequest->setLastId($this->getLastId($bibs));

        $bulkModels = new BulkModels();
        $bulkModels->setSuccessModels($bibs->getData());
        $bulkModels->publish();

        return $this->getResponse()->withJson(
            new PostRequestSuccess($postRequest)
        );
    }
}