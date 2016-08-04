# magento-2-api-made-easy
## Synopsis
A litttle PHP Class who can help using the Magento 2 REST API. Easy to understand, easy to use !

## API Reference
### Connection to your MAGENTO 2 REST API
```php
<?php
include("magento_rest.php");

$api = new maRest("www.mywebsite.com");   
$api->connect("myuser","mypassword");
```
### GET one thing
U can use this method to retrieve all things that only need one get parameter
```php
$retour = $api->get("products/MYSKU");
//or
$retour = $api->get("cmsPage/myPageId");
```
### GET with search
In magento 2 rest api, u need to use search criteria if u want to retrieve multiple results with a GET, like all customers by example.

first, u need to create an array with your search criteria.
```php
$search = array(
    array ("entity_id", "eq", "2047"),
);
```
First argurment is the field you search, Second argument is the condition, Thrisd argument is the value you search.

Possibles conditions (from http://devdocs.magento.com/guides/v2.1/howdoi/webapi/search-criteria.html)

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

U can use multiples conditions :
```php
$search = array(
    array ("entity_id", "eq", "2047"),
    array ("sku", "like", "%MP10%"),
);
```


