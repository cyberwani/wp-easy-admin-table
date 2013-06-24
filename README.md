wp-easy-admin-table
===================

Simplified usage of tables in wordpress plugin admin views

example view:

```
<?php
include_once("easy-table.class.php");

$dogs = array(
	array("name"=>"Fido", "age"=>4, "color"=>"brown"),
	array("name"=>"Rex", "age"=>6, "color"=>"black"),
	array("name"=>"Snoopy", "age"=>2, "color"=>"white"),
	array("name"=>"Lassie", "age"=>5, "color"=>"golden"),
);

new EasyAdminTable($dogs);
```

will render like this:

![dogs.jpg](dogs.jpg)


A better example with user data: