<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure;

use FondOfSpryker\Zed\ContentfulPageSearch\Communication\Plugin\Search\BlogPostPageMapPlugin;
use Orm\Zed\Contentful\Persistence\FosContentful;

class BlogPostStructureValidator implements StructureValidatorInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return BlogPostPageMapPlugin::ENTRY_TYPE_ID_VALUE;
    }

    /**
     * @param string $jsonData
     * @return bool
     */
    public function validate(string $jsonData): bool
    {
        $entryData = json_decode($jsonData, true);
        return
            array_key_exists(BlogPostPageMapPlugin::FIELDS, $entryData)
            && array_key_exists(BlogPostPageMapPlugin::FIELD_CATEGORIES, $entryData[BlogPostPageMapPlugin::FIELDS])
            && array_key_exists(BlogPostPageMapPlugin::FIELD_TAGS, $entryData[BlogPostPageMapPlugin::FIELDS])
            && array_key_exists(BlogPostPageMapPlugin::FIELD_PUBLISH_AT, $entryData[BlogPostPageMapPlugin::FIELDS]);
    }

}
