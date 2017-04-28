<?php
namespace NYPL\Services\Controller;

use NYPL\Services\Model\Response\BulkResponse\BulkBibsResponse;
use NYPL\Starter\BulkModels;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Services\Model\Response\SuccessResponse\BibsResponse;
use NYPL\Services\Model\Response\SuccessResponse\BibResponse;
use NYPL\Starter\ModelSet;

final class BibController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/v0.1/bibs",
     *     summary="Create new Bibs",
     *     tags={"bibs"},
     *     operationId="createBib",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="NewBib",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/NewBib")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/BulkBibsResponse")
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function createBib()
    {
        $bulkModels = new BulkModels();

        foreach ($this->getRequest()->getParsedBody() as $bibData) {
            if (!isset($bibData['nyplSource'])) {
                $bibData['nyplSource'] = 'sierra-nypl';
            }

            if (!isset($bibData['nyplType'])) {
                $bibData['nyplType'] = 'bib';
            }

            $bulkModels->addModel(new Bib($bibData));
        }

        $bulkModels->create(true);

        return $this->getResponse()->withJson(
            new BulkBibsResponse(
                $bulkModels->getModels(),
                $bulkModels->getBulkErrors()
            )
        );
    }

    /**
     * @SWG\Get(
     *     path="/v0.1/bibs",
     *     summary="Get a list of Bibs",
     *     tags={"bibs"},
     *     operationId="getBibs",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         type="string",
     *         description="Separate multiple IDs with a comma"
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="nyplSource",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/BibsResponse")
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function getBibs()
    {
        return $this->getDefaultReadResponse(
            new ModelSet(new Bib()),
            new BibsResponse(),
            null,
            ['barcode', 'nyplSource', 'id']
        );
    }

    /**
     * @SWG\Get(
     *     path="/v0.1/bibs/{nyplSource}/{id}",
     *     summary="Get a Bib",
     *     tags={"bibs"},
     *     operationId="getBib",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         in="path",
     *         name="nyplSource",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/BibResponse")
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
     *             "api_auth": {"openid api"}
     *         }
     *     }
     * )
     */
    public function getBib($nyplSource = '', $id = '')
    {
        $bib = new Bib();

        $bib->addFilter(new Filter('id', $id));
        $bib->addFilter(new Filter('nyplSource', $nyplSource));

        return $this->getDefaultReadResponse(
            $bib,
            new BibResponse()
        );
    }
}
