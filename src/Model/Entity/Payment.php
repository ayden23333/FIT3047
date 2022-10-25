<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $Order_ID
 * @property int $Customer_ID
 * @property string $Payment_method
 * @property float $Price
 * @property int $Payment_ID
 */
class Payment extends Entity
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
        'Order_ID' => true,
        'Customer_ID' => true,
        'Payment_method' => true,
        'Price' => true,
    ];
}
