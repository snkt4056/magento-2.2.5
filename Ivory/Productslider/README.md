# Add Product slider to any place of your Magento 2 store

## Usage

Declare:

<block class="Ivory\Productslider\Block\Index" name="Productslider" template="Ivory_Productslider::productslider_grid.phtml" >
	<arguments>
		<argument name="key" xsi:type="string">key</argument>
		<argument name="title" xsi:type="string">title</argument>
	</arguments>
</block>

in your layout xml 

<?php echo $this->getLayout()->createBlock("Ivory\Productslider\Block\Index")->setData('key', 'key')->setTemplate("Ivory_Productslider::productslider_grid.phtml")->toHtml(); ?> 

in your template file

List of arguments:

1 > key : new / category / bestseller / most_viewed
	
	new 		-> display new uploaded product collection
	category 	-> display product collection by category id
	bestseller 	-> display best/more selling product from your store
	most_viewed -> display most viewed product by user

2 > title -> Display heading title above the product slider.

3 > count -> Number of product you want to display.

4 > category_id -> use with only key(category).

5 > desktop_count -> No. of product show in desktop view. Default : 5

6 > tablet_count -> No. of product show in tablet view. Default : 3

7 > mobile_count -> No. of product show in mobile view. Default : 1