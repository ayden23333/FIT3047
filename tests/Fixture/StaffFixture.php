<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StaffFixture
 */
class StaffFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'staff';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'Staff_ID' => 1,
                'Staff_Fname' => 'Lorem ipsum dolor sit amet',
                'Staff_Lname' => 'Lorem ipsum dolor sit amet',
                'Staff_email' => 'Lorem ipsum dolor sit amet',
                'Staff_phone' => 1,
            ],
        ];
        parent::init();
    }
}
