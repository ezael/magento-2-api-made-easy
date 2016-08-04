# magento-2-api-made-easy
## Synopsis
A litttle PHP Class who can help using the Magento 2 REST API. Easy to understand, easy to use !

## API Reference

### Connect to your MAGENTO 2 REST API
```php
<?php
include("magento_rest.php");

$api = new maRest("www.mywebsite.com");   
$api->connect("myuser","mypassword");
```

### GET one thing
U can use this method to retrieve all things that only need one get parameter.
See the http://devdocs.magento.com/guides/v2.0/rest/list.html to know wath u can get with this call.
```php
$retour = $api->get("products/MYSKU");
//or
$retour = $api->get("cmsPage/myPageId");
```

### GET with search
In magento 2 rest api, u need to use search criteria if u want to retrieve multiple results with a GET, like all customers by example.

first, u need to create an array with your search criteria before calling the method.
```php
$search = array(
    array ("entity_id", "eq", "2047"),
);

$retour = $api->get("products", $search);
```
First argurment is the field you search, Second argument is the condition, Third argument is the value you search.

Possible conditions (from http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html)

| Condition |	Notes |
| --- | --- |
| eq |	Equals. |
| finset | A value within a set of values |
| from | The beginning of a range. Must be used with to |
| gt | Greater than |
| gteq | Greater than or equal |
| in | In |
| like | Like. The value can contain the SQL wildcard characters when like is specified. |
| lt | Less than |
| lteq | Less than or equal |
| moreq | More or equal |
| neq | Not equal |
| nin | Not in |
| notnull | Not null |
| null |Null |
| to | The end of a range. Must be used with from |

U can use multiples conditions in one call :
```php
$search = array(
    array ("entity_id", "eq", "2047"),
    array ("sku", "like", "%MP10%"),
);

$retour = $api->get("products", $search);
```

### DELETE ONE THING
```php
$retour = $api->delete("products/mySku");
```
See the http://devdocs.magento.com/guides/v2.0/rest/list.html to know wath u can delete with this call.

### INSERT A NEW RECORD
First, u need to create an array with the data u want to insert. U can only insert ONE record at a time (one product, by example).
```php
$data = array(
    "product" => array(
        "sku"               => "TEST PRODUCTX3 " . uniqid(),
        'name'              => 'Simple Product ' . uniqid(),
        'visibility'        => 4, /*'catalog',*/
        'type_id'           => 'simple',
        'price'             => 99.95,
        'status'            => 1,
        'attribute_set_id'  => 4,
        'weight'            => 1,
        'custom_attributes' => array(
            array( 'attribute_code' => 'category_ids',      'value' => ["11"] ),
            array( 'attribute_code' => 'description',       'value' => 'Simple Description' ),
            array( 'attribute_code' => 'short_description', 'value' => 'Simple  Short Description' ),
        ),
    )
);

$retour = $api->post("products", $data);
```

### UPDATE A RECORD
U need to create an array with the values u want to modify before calling the method.
```php
$data = array(
    "product" => array(
        'price'             => 9000000,
    )
);

$retour = $api->put("products/mySku", $data);
```
