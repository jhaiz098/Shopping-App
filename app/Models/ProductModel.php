<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}

?>