<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Exception\StructureValidatorNotFoundException;

/**
 * Class StructureValidatorCollection
 */
class StructureValidatorCollection implements StructureValidatorCollectionInterface
{
    /**
     * @var array
     */
    private $validator = [];

    /**
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface $validator
     *
     * @return $this
     */
    public function add(StructureValidatorInterface $validator)
    {
        $this->validator[$validator->getName()] = $validator;

        return $this;
    }

    /**
     * @param string $ident
     *
     * @return bool
     */
    public function has(string $ident): bool
    {
        return isset($this->validator[$ident]);
    }

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface[]
     */
    public function getValidator(): array
    {
        return $this->validator;
    }

    /**
     * @param string $ident
     *
     * @throws \FondOfSpryker\Zed\ContentfulPageSearch\Exception\StructureValidatorNotFoundException
     *
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface
     */
    public function get(string $ident): StructureValidatorInterface
    {
        if (empty($this->validator[$ident])) {
            throw new StructureValidatorNotFoundException($ident);
        }

        return $this->validator[$ident];
    }
}
