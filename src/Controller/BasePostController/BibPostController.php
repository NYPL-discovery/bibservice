<?php
namespace NYPL\Services\Controller\BasePostController;

use NYPL\Services\Controller\BasePostController;
use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Services\Model\DataModel\BasePostRequest\BibPostRequest;
use NYPL\Starter\APIException;
use NYPL\Starter\Config;

final class BibPostController extends BasePostController
{
    protected function getBaseRecord()
    {
        return new Bib();
    }

    protected function getPostRequest()
    {
        return new BibPostRequest();
    }

    /**
     * @SWG\Post(
     *     path="/v0.1/bib-post-requests",
     *     summary="Create a new Bib Post Request",
     *     description="Request up to 500 records be re-posted to the BibBulk stream starting from the record after lastId.",
     *     tags={"bibs"},
     *     operationId="createBibPostRequest",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="BibPostRequest",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/BibPostRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/PostRequestSuccess")
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid", "read:bib"}
     *         }
     *     }
     * )
     * @throws APIException|\RuntimeException
     */
    public function createBibPostRequest()
    {
        return $this->createPostRequest(Config::get('BIB_BULK_STREAM_NAME'));
    }
}
