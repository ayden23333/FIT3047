<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $Order_ID
 * @property int $Product_ID
 * @property int $User_ID
 * @property int $Cart_ID
 * @property string $Order_address
 */
class Order extends Entity
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
        'Product_ID' => true,
        'User_ID' => true,
        'Product_Count' => true,
        'Order_address' => true,
    ];
}
