<?php
namespace NYPL\Services\Model\DataModel\BaseBib;

use NYPL\Services\Model\DataModel\BaseBib;
use NYPL\Starter\Model\ModelInterface\DeleteInterface;
use NYPL\Starter\Model\ModelInterface\MessageInterface;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\DBCreateTrait;
use NYPL\Starter\Model\ModelTrait\DBDeleteTrait;
use NYPL\Starter\Model\ModelTrait\DBReadTrait;
use NYPL\Starter\Model\ModelTrait\DBUpdateTrait;

/**
 * @SWG\Definition(title="Bib", type="object", required={"id"})
 */
class Bib extends BaseBib implements MessageInterface, ReadInterface, DeleteInterface
{
    use DBCreateTrait, DBReadTrait, DBDeleteTrait, DBUpdateTrait;

    public function getSchema()
    {
        return
            [
                "name" => "Bib",
                "type" => "record",
                "fields" => [
                    ["name" => "id", "type" => "string"],
                    ["name" => "nyplSource", "type" => ["string", "null"]],
                    ["name" => "nyplType", "type" => ["string", "null"]],
                    ["name" => "updatedDate", "type" => ["string", "null"]],
                    ["name" => "createdDate", "type" => ["string", "null"]],
                    ["name" => "deletedDate", "type" => ["string", "null"]],
                    ["name" => "deleted", "type" => "boolean"],
                    ["name" => "locations" , "type" => [
                        "null",
                        ["type" => "array", "items" => [
                            ["name" => "locations", "type" => "record", "fields" => [
                                ["name" => "code", "type" => ["string", "null"]],
                                ["name" => "name", "type" => ["string", "null"]],
                            ]]
                        ]],
                    ]],
                    ["name" => "suppressed", "type" => ["boolean", "null"]],
                    ["name" => "lang" , "type" => [
                        "null",
                        ["name" => "lang", "type" => "record", "fields" => [
                            ["name" => "code", "type" => "string"],
                            ["name" => "name", "type" => ["string", "null"]],
                        ]],
                    ]],
                    ["name" => "title", "type" => ["string", "null"]],
                    ["name" => "author", "type" => ["string", "null"]],
                    ["name" => "materialType" , "type" => [
                        "null",
                        ["name" => "materialType", "type" => "record", "fields" => [
                            ["name" => "code", "type" => "string"],
                            ["name" => "value", "type" => "string"],
                        ]],
                    ]],
                    ["name" => "bibLevel" , "type" => [
                        "null",
                        ["name" => "bibLevel", "type" => "record", "fields" => [
                            ["name" => "code", "type" => "string"],
                            ["name" => "value", "type" => "string"],
                        ]],
                    ]],
                    ["name" => "publishYear", "type" => ["int", "null"]],
                    ["name" => "catalogDate", "type" => ["string", "null"]],
                    ["name" => "country" , "type" => [
                        "null",
                        ["name" => "country", "type" => "record", "fields" => [
                            ["name" => "code", "type" => "string"],
                            ["name" => "name", "type" => "string"],
                        ]],
                    ]],
                    ["name" => "normTitle", "type" => ["string", "null"]],
                    ["name" => "normAuthor", "type" => ["string", "null"]],
                    ["name" => "fixedFields" , "type" => [
                        "null",
                        ["type" => "map", "values" => [
                            ["name" => "fixedField", "type" => "record", "fields" => [
                                ["name" => "label", "type" => ["string", "null"]],
                                ["name" => "value", "type" => ["string", "null"]],
                                ["name" => "display", "type" => ["string", "null"]],
                            ]]
                        ]],
                    ]],
                    ["name" => "varFields" , "type" => [
                        "null",
                        ["type" => "array", "items" => [
                            ["name" => "varField", "type" => "record", "fields" => [
                                ["name" => "fieldTag", "type" => ["string", "null"]],
                                ["name" => "marcTag", "type" => ["string", "null"]],
                                ["name" => "ind1", "type" => ["string", "null"]],
                                ["name" => "ind2", "type" => ["string", "null"]],
                                ["name" => "content", "type" => ["string", "null"]],
                                ["name" => "subFields" , "type" => [
                                    "null",
                                    ["type" => "array", "items" => [
                                        ["name" => "subField", "type" => "record", "fields" => [
                                            ["name" => "tag", "type" => ["string", "null"]],
                                            ["name" => "content", "type" => ["string", "null"]],
                                        ]]
                                    ]],
                                ]],
                            ]]
                        ]],
                    ]],
                ]
            ];
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
