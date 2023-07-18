<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ced\Fruugo\Ui\DataProvider\CategoriesEdit;

use Ced\Fruugo\Model\ResourceModel\Categories\Collection;
use Ced\Fruugo\Model\Categories;
use Magento\Framework\App\RequestInterface;

/**
 * Class ProductDataProvider
 */
class CategoriesEdit extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Product collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $collection;
    /*
     * @var
     */
    protected $request;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    /*
     * @var Ced\Fruugo\Model\ResourceModel\Categories
     */
    public $categoryModel;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RequestInterface $request,
        Collection $collectionFactory,
        Categories $categoryModel,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory;
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->request = $request;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $items=array();
        if(!empty($this->request->getParam('id'))){
            $id=$this->request->getParam('id');
            $items = $this->categoryModel->load($id);
            $collection[$id]['box']=$items->getData();
        }
        else{

            if (!$this->getCollection()->isLoaded()) {
                $this->getCollection()->load();
            }
            $collection = $this->getCollection()->load()->toArray();
        }
        return $collection;
    }

    /**
     * Add field to select
     *
     * @param string|array $field
     * @param string|null $alias
     * @return void
     */
    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
        } else {
            parent::addField($field, $alias);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }
}
