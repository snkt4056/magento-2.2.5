<?php

namespace Kblikruta\Stockstatus\Ui\Component\Listing\Columns;

class StockStatus extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'column.stock_status';

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$fieldName])) {
                    $item[$fieldName] = $this->getStatus($item[$fieldName]);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $status
     * @return \Magento\Framework\Phrase
     */
    private function getStatus($status)
    {
        if($status == 1) {
            return __('In Stock');
        } else {
            return __('Out of Stock');
        }
    }
}