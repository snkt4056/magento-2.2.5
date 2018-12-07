<?php

namespace Kblikruta\Stockstatus\Plugin\Ui\DataProvider\Product;

class ProductDataProvider
{
    /**
     * @param \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider $subject
     * @param \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection
     * @return mixed
     */
    public function afterGetCollection(
        \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider $subject,
        $collection
    ) {
        $columns = $collection->getSelect()->getPart(\Zend_Db_Select::COLUMNS);
        if (!$collection->isLoaded() && !$this->checkJoin($columns)) {
            $collection->joinTable(
                'cataloginventory_stock_status',
                'product_id=entity_id',
                ["stock_status" => "stock_status"],
                null ,
                'left'
            )->addAttributeToSelect('stock_status');
        }

        return $collection;
    }

    /**
     * @param array $columns
     * @return bool
     */
    private function checkJoin($columns)
    {
        foreach ($columns as $column) {
            if(is_array($column)) {
                if(in_array('stock_status', $column)) {
                    return true;
                }
            }
        }

        return false;
    }
}