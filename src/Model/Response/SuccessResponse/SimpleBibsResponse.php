<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\SimpleBib;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="BibsResponse", type="object")
 */
class SimpleBibsResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var SimpleBib[]
     */
    public $data;
}
