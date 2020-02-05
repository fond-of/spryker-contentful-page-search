<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure;

interface StructureValidatorInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $jsonData
     *
     * @return bool
     */
    public function validate(string $jsonData): bool;
}
