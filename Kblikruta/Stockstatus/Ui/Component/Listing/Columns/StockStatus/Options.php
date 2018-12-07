<?php

namespace Kblikruta\Stockstatus\Ui\Component\Listing\Columns\StockStatus;

use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options = [
            [
                'label' => __('In Stock'),
                'value' => 1
            ],
            [
                'label' => __('Out of Stock'),
                'value' => 0
            ]
        ];

        return $this->options;
    }
}