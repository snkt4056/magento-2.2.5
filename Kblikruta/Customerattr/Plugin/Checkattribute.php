<?php

namespace Kblikruta\Customerattr\Plugin;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\RequestInterface;

class Checkattribute
{

	public function __construct(
        ResultFactory $Redirect, 
		ManagerInterface $messageManager,	
		RequestInterface $request
    )
    {
        $this->resultFactory = $Redirect;
		$this->_messageManager = $messageManager;
		$this->getRequest = $request;
    }
	
	public function beforeExecute(\Magento\Customer\Controller\Account\CreatePost $subject)
	{
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerObj = $objectManager->create('Magento\Customer\Model\ResourceModel\Customer\Collection');
		$collection = $customerObj->addAttributeToSelect('*')
				  ->addAttributeToFilter('sponsor_name',$this->getRequest->getParam('sponsor_name'))
				  ->load();
		$customerdata=$collection->getData();
		if(!empty($customerdata))
		{
			$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
			$this->_messageManager->addError('The value of "Sponsor Name" already exist.');
			$resultRedirect->setPath('customer/account/');
			$this->getRequest->setParam('form_key','');
			return $resultRedirect;
		}
		else
		{
			return true;
		}

	}

}