<?php

namespace Ivory\Productslider\Block;

CONST DEFAULT_PRODUCTS_COUNT = 10;

class Index extends \Magento\Framework\View\Element\Template {
	
	
	
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Catalog\Model\CategoryFactory $categoryFactory,
		\Magento\Catalog\Block\Product\ImageBuilder $_imageBuilder,	
		\Magento\Catalog\Block\Product\AbstractProduct $_abstractProductBlock,
		\Magento\Catalog\Block\Product\ListProduct $listProductBlock,
		\Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
		\Magento\Catalog\Model\Product\Visibility $productVisibility,
		\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,		
		\Magento\Reports\Model\ResourceModel\Product\CollectionFactory $mostViewedCollectionFactory,
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;    
		$this->_categoryFactory = $categoryFactory;
		$this->_imageBuilder=$_imageBuilder;
		$this->_priceBuilder=$_abstractProductBlock;
		$this->listProductBlock = $listProductBlock;
		$this->productStatus = $productStatus;
		$this->productVisibility = $productVisibility;
		$this->_resourceFactory = $resourceFactory;
		$this->mostViewedCollection = $mostViewedCollectionFactory->create();
        parent::__construct($context, $data);
    }


    public function getProductCollection()
    {
		switch ($this->getKey()) {
			case 'new':
				$data = $this->getNewProductCollection();
				break;
			case 'category':
				$data = $this->getProductByCategoryId($this->getCategoryId());
				break;
			case 'bestseller':
				$data = $this->getBestsellerProduct();
				break;
			case 'most_viewed':
				$data = $this->getMostRecentlyViewed();
				break;
			default:
				$data = $this->getNewProductCollection();
		}
        return $data;
    }
	
	public function getNewProductCollection()
    {
		$collection = $this->_productCollectionFactory->create();
		$collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
		$collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $collection->addAttributeToSelect('*');
		$collection->setOrder('entity_id','DESC');		
		if(count($collection->getData()) > 0) {
			if($this->getCount() != '' && $this->getCount() != '0') 
			{
				$collection->setPageSize($this->getCount());
			}
			else
			{
				$collection->setPageSize(DEFAULT_PRODUCTS_COUNT);
			}
		}
        return $collection;
	}
	
	public function getBestsellerProduct()
    {
		$collection = $this->_resourceFactory->create('Magento\Reports\Block\Product\Viewed');
		// $resourceCollection = $this->_resourceFactory->create('Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection');
		//$collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
		//$collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
		//$collection->addAttributeToSelect('*');
		if(count($collection->getData()) > 0) {
			if($this->getCount() != '' && $this->getCount() != '0') 
			{
				$collection->setPageSize($this->getCount());
			}
			else
			{
				$collection->setPageSize(DEFAULT_PRODUCTS_COUNT);
			}
		}
        return $collection;
	}
	
	public function getProductByCategoryId($categoryId)
    {
		$category = $this->_categoryFactory->create()->load($categoryId);
		$collection = $this->_productCollectionFactory->create();
		$collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
		$collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $collection->addAttributeToSelect('*');
		$collection->addCategoryFilter($category);
		if(count($collection->getData()) > 0) {
			if($this->getCount() != '' && $this->getCount() != '0') 
			{
				$collection->setPageSize($this->getCount());
			}
			else
			{
				$collection->setPageSize(DEFAULT_PRODUCTS_COUNT);
			}
		}
        return $collection;
	}
	
	public function getMostRecentlyViewed()
    {
		$storeId = $this->_storeManager->getStore()->getId();
        $collection = $this->mostViewedCollection->addAttributeToSelect(
            '*'
        )->addViewsCount()->setStoreId(
            $storeId
        )->addStoreFilter(
            $storeId
        );
		if(count($collection->getData()) > 0) {
			if($this->getCount() != '' && $this->getCount() != '0') 
			{
				$collection->setPageSize($this->getCount());
			}
			else
			{
				$collection->setPageSize(DEFAULT_PRODUCTS_COUNT);
			}
		}
        return $collection;
	}
	
	public function getProductPrice($product)
    {
        return $this->_priceBuilder->getProductPrice($product);
    }
	
	public function getAddToCartPostParams($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }
	
	public function getImage($product, $imageId, $attributes = [])
    {
        return $this->_imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

}