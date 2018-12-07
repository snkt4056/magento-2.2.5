<?php

namespace Ivory\Productslider\Controller\Index;

use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		return $this->_pageFactory->create();
	}
}

// use Magento\Framework\App\Action\Context;
// use Magento\Framework\View\Result\PageFactory;
 
// class Index extends \Magento\Framework\App\Action\Action
// {
    // protected $viewHelper;


    // protected $resultPageFactory;

    // public function __construct(
        // Context $context,
        // PageFactory $resultPageFactory
    // ) {
        // $this->resultPageFactory = $resultPageFactory;
        // parent::__construct($context);
    // }

    // public function execute()
    // {
		// $page = $this->resultPageFactory->create();
		// return $page;
        
    // }
// }