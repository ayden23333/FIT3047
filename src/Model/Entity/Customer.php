<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property string $Customer_Firstname
 * @property string $Customer_Lastname
 * @property int $Customer_ID
 * @property int $Customer_password
 * @property string $Customer_email
 * @property int $Cus_phone
 * @property string $Cus_Street
 * @property string $Cus_City
 * @property string $Cus_State
 * @property int $Cus_postcode
 */
class Customer extends Entity
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
        'Customer_Firstname' => true,
        'Customer_Lastname' => true,
        'Customer_password' => true,
        'Customer_email' => true,
        'Cus_phone' => true,
        'Cus_Street' => true,
        'Cus_City' => true,
        'Cus_State' => true,
        'Cus_postcode' => true,
    ];
}
