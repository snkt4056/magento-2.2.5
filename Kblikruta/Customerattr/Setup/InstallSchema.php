<?php 
namespace Kblikruta\Customerattr\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    private $eavSetupFactory;
    
    private $eavConfig;
    
    private $attributeResource;
    
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(Customer::ENTITY, 'sponsor_name', [
            // Attribute parameters

			"type"     => "varchar",
            "backend"  => "",
            "label"    => "Sponsor Name",
            "input"    => "text",
            "source"   => "",
			'system' => 0,
			'global' => '',
			'sort_order' => '200',
            "visible"  => true,
            "required" => true,
            "default" => "",
            "unique"     => true,
            "frontend" => "",
            "note"       => "Sponsor Name",
			'is_user_defined' => 1,
			'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
			'filterable' => false,
            'comparable' => false
        ]);
        
        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'sponsor_name');
        $attribute->setData('used_in_forms', ['adminhtml_customer','checkout_register','customer_account_create','customer_account_edit','adminhtml_checkout']);
        $this->attributeResource->save($attribute);
    }
}	