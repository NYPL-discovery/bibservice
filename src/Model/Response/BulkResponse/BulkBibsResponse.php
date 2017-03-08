<?php
namespace NYPL\Services\Model\Response\BulkResponse;

use NYPL\Services\Model\DataModel\BaseBib\Bib;
use NYPL\Starter\Model\Response\BulkResponse;

/**
 * @SWG\Definition(title="BibsResponse", type="object")
 */
class BulkBibsResponse extends BulkResponse
{
    /**
     * @SWG\Property
     * @var Bib[]
     */
    public $data;
}
