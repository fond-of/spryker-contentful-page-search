<?php

namespace FondOfSpryker\Zed\ContentfulPageSearch\Business\Validator\Structure;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\ProductRelation\Persistence\SpyProductRelationType;
use Orm\Zed\ProductRelation\Persistence\SpyProductRelationTypeQuery;
use PDO;
use Pyz\Zed\ProductFixer\Business\Model\Saver\AbstractRelationSaverInterface;
use Pyz\Zed\ProductFixer\Business\Model\Saver\RelationSaverInterface;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

/**
 * Class AccessoryFixer
 *
 * @package Pyz\Zed\ProductFixer\Business\Model\Fixer
 */
abstract class AbstractStructureValidator implements ProductFixerInterface
{
    /**
     * @var
     */
    protected $roles;

    /**
     * @var
     */
    protected $key;

    /**
     * @var \Pyz\Zed\ProductFixer\Business\Model\Saver\RelationSaverInterface
     */
    protected $relationSaver;

    /**
     * @var \Pyz\Zed\ProductFixer\Business\Model\Saver\AbstractRelationSaverInterface
     */
    protected $abstractRelationSaver;

    /**
     * @var \Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface $queryContainer
     * @param \Pyz\Zed\ProductFixer\Business\Model\Saver\AbstractRelationSaverInterface $abstractRelationSaver
     * @param \Pyz\Zed\ProductFixer\Business\Model\Saver\RelationSaverInterface $relationSaver
     */
    public function __construct(
        QueryContainerInterface $queryContainer,
        AbstractRelationSaverInterface $abstractRelationSaver,
        RelationSaverInterface $relationSaver
    ) {
        $this->queryContainer = $queryContainer;
        $this->abstractRelationSaver = $abstractRelationSaver;
        $this->relationSaver = $relationSaver;
    }

    /**
     * Checks if a product needs fixing.
     *
     * @param int $idProductAbstract
     *
     * @return bool
     */
    public function isNecessary(int $idProductAbstract): bool
    {
        return true;
    }

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return void
     */
    public function fix(ProductAbstractTransfer $productAbstractTransfer): void
    {
        /** @var \Orm\Zed\ProductRelation\Persistence\SpyProductRelationType $productRelationTypeEntity */
        $productRelationTypeEntity = $this->ensureRelationTypeExists();
        $idProductAbstractMainProduct = $productAbstractTransfer->getIdProductAbstract();

        $mainAssetId = $this->getAssetIdByIdProductAbstract($idProductAbstractMainProduct);
        $wantedCenshareRelations = $this->findAssetRelationsByMainAssetId($mainAssetId);

        if (count($wantedCenshareRelations) > 0) {
            $productRelationEntity = $this->relationSaver->saveProductRelation(
                $idProductAbstractMainProduct,
                $productRelationTypeEntity->getIdProductRelationType(),
                $wantedCenshareRelations
            );

            $relatedAbstractProductIds = [];
            foreach ($wantedCenshareRelations as $wantedRelation) {
                $assetId = $wantedRelation['asset_id'];
                $idProductAbstractRelatedProduct = $this->findProductAbstractIdsByAssetId($assetId);
                if ($idProductAbstractRelatedProduct > 0) {
                    $relatedAbstractProductIds[] = $idProductAbstractRelatedProduct;
                }
            }

            $this->abstractRelationSaver
                ->saveRelatedAbstractProducts($relatedAbstractProductIds, $productRelationEntity->getIdProductRelation());
        }
    }

    /**
     * Fetches all Censhare assets, which are "Zubehör" for the main asset.
     *
     * @param int $mainAssetId
     *
     * @return array
     */
    protected function findAssetRelationsByMainAssetId(int $mainAssetId): array
    {
        $in_values = implode('\',\'', $this->roles);

        $stmt = $this->queryContainer->getConnection()->prepare(
            '
            SELECT * FROM censhare_asset_relation 
            WHERE role IN (\'' . $in_values . '\')
                AND main_asset_id = :p1
        '
        );
        $stmt->bindValue(':p1', $mainAssetId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC, 0);

        return $result;
    }

    /**
     * @param int $assetId
     *
     * @return int
     */
    protected function findProductAbstractIdsByAssetId(int $assetId): int
    {
        $stmt = $this->queryContainer->getConnection()->prepare(
            '
            SELECT * FROM spy_product_abstract
            WHERE asset_id = :p1
        '
        );
        $stmt->bindValue(':p1', $assetId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC, 0);

        return (int)$result['id_product_abstract'];
    }

    /**
     * @param int $idProductAbstract
     *
     * @return int
     */
    protected function getAssetIdByIdProductAbstract(int $idProductAbstract): int
    {
        $stmt = $this->queryContainer->getConnection()->prepare(
            '
            SELECT asset_id FROM spy_product_abstract
            WHERE id_product_abstract = :p1
        '
        );
        $stmt->bindValue(':p1', $idProductAbstract);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC, 0);

        return (int)$result['asset_id'];
    }

    /**
     * @param int $idProductAbstract
     *
     * @return array|bool
     */
    protected function checkProductRelationDbExists(int $idProductAbstract): bool
    {
        $fkProductRelationType = $this->getProductRelationTypeIdByKey();
        if ($fkProductRelationType) {
            return false;
        }

        $stmt = $this->queryContainer->getConnection()->prepare(
            '
            SELECT count(*) as anz FROM spy_product_relation
            WHERE fk_product_relation_type = :p1
            AND fk_product_abstract = :p2
        '
        );
        $stmt->bindValue(':p1', $fkProductRelationType);
        $stmt->bindValue(':p2', $idProductAbstract);
        $stmt->execute([]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC, 0);

        return (bool)$result['anz'];
    }

    /**
     * @return int
     */
    protected function getProductRelationTypeIdByKey(): int
    {
        $stmt = $this->queryContainer->getConnection()->prepare(
            '
            SELECT id_product_relation_type FROM spy_product_relation_type
            WHERE key = :p1
        '
        );
        $stmt->bindValue(':p1', $this->key);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC, 0);

        return (int)$result['id_product_relation_type'];
    }

    /**
     * Doppelter Check ist notwendig um doppelte Datenbankeinträge zu vermeiden.
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationType
     */
    protected function ensureRelationTypeExists(): SpyProductRelationType
    {
        $query = SpyProductRelationTypeQuery::create();
        $productRelationTypeEntity = $query
            ->filterByKey($this->key)
            ->findOne();

        if ($productRelationTypeEntity === null) {
            usleep(1);
            $productRelationTypeEntity = $query
                ->filterByKey($this->key)
                ->findOne();
            if ($productRelationTypeEntity === null) {
                $productRelationTypeEntity = new SpyProductRelationType();
                $productRelationTypeEntity->setKey($this->key);
                $productRelationTypeEntity->save();
            }
        }

        return $productRelationTypeEntity;
    }
}
