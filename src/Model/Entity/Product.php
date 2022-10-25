<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $Product_ID
 * @property string $Product_Name
 * @property float $Product_Price
 * @property string $Product_Image
 * @property string $Product_stock
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'Product_Name' => true,
        'Product_Price' => true,
        'Product_Image' => true,
        'Product_stock' => true,
    ];
}
