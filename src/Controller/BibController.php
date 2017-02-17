<?php
namespace NYPL\Services\Controller;

use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Services\Model\DataModel\BaseItem\Item;
use NYPL\Services\Model\Response\SuccessResponse\BibsResponse;
use NYPL\Services\Model\Response\SuccessResponse\BibResponse;
use NYPL\Services\Model\Response\SuccessResponse\ItemResponse;
use NYPL\Starter\ModelSet;

final class BibController extends Controller
{
    /**
     * @SWG\Post(
     *     path="/v0.1/bibs",
     *     summary="Create a new Bib",
     *     tags={"bibs"},
     *     operationId="createBib",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="NewBib",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewBib"),
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
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function createBib()
    {
        $bib = new Bib($this->getRequest()->getParsedBody());

        $bib->create(true);

        return $this->getResponse()->withJson(
            new BibResponse($bib)
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

    /**
     * @SWG\Post(
     *     path="/v0.1/bibs/{nyplSource}/{id}/items",
     *     summary="Create a new Item for a Bib",
     *     tags={"bibs"},
     *     operationId="createBibItem",
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
     *     @SWG\Parameter(
     *         name="NewBibItem",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewBibItem"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(ref="#/definitions/ItemResponse")
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
    public function createBibItem($nyplSource = '', $id = '')
    {
        $data = $this->getRequest()->getParsedBody();

        $data['nyplSource'] = $nyplSource;
        $data['bibIds'] = [$id];

        $item = new Item($data);
        $item->create(true);

        return $this->getResponse()->withJson(
            new ItemResponse($item)
        );
    }
}
