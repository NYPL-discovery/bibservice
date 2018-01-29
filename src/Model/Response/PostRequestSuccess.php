<?php
namespace NYPL\Services\Model\Response;

use NYPL\Services\Model\DataModel\BasePostRequest\BibPostRequest;

/**
 * @SWG\Definition(title="PostRequestSuccess", type="object")
 */
class PostRequestSuccess
{
    /**
     * @SWG\Property(example="26823541")
     * @var string
     */
    public $lastId;

    /**
     * @SWG\Property(example="sierra-nypl")
     * @var string
     */
    public $nyplSource;

    /**
     * @param BibPostRequest $bibPostRequest
     */
    public function __construct(BibPostRequest $bibPostRequest = null)
    {
        if ($bibPostRequest) {
            $this->setLastId($bibPostRequest->getLastId());
            $this->setNyplSource($bibPostRequest->getNyplSource());
        }
    }

    /**
     * @return string
     */
    public function getLastId(): string
    {
        return $this->lastId;
    }

    /**
     * @param string $lastId
     */
    public function setLastId(string $lastId): void
    {
        $this->lastId = $lastId;
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
    public function setNyplSource(string $nyplSource): void
    {
        $this->nyplSource = $nyplSource;
    }
}
