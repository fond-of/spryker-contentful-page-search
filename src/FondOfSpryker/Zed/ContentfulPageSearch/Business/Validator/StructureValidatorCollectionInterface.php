<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator;

use FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface;
use FondOfSpryker\Zed\ContentfulPageSearch\Exception\StructureValidatorNotFoundException;

/**
 * Interface StructureValidatorCollectionInterface
 * @package FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator
 */
interface StructureValidatorCollectionInterface
{
    /**
     * @param \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface $validator
     *
     * @return $this
     */
    public function add(StructureValidatorInterface $validator);

    /**
     * @param string $ident
     *
     * @return bool
     */
    public function has(string $ident): bool;

    /**
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface[]
     */
    public function getValidator(): array;

    /**
     * @param string $ident
     *
     * @throws \FondOfSpryker\Zed\ContentfulPageSearch\Exception\StructureValidatorNotFoundException
     *
     * @return \FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure\StructureValidatorInterface
     */
    public function get(string $ident): StructureValidatorInterface;
}
