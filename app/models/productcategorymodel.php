<?php

namespace PHPMVC\Models;

class ProductCategoryModel extends abstractModel
{

    public $CategoryId;
    public $Name;
    public $Image;

    protected static $tableName = 'app_products_categories';
    
    protected static $tableSchema = array(
        'CategoryId'   => self::DATA_TYPE_INT,
        'Name'          => self::DATA_TYPE_STR,
        'Image'         => self::DATA_TYPE_STR
    );

    protected static $primaryKey = 'CategoryId';
}