<?php
/**
 * Created by PhpStorm.
 * User: itnrw
 * Date: 13.09.18
 * Time: 15:27
 */

namespace App\Tests\Service;

use App\Model\Customer;
use App\Service\CustomerRepository;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryTest extends TestCase
{

    public function testGetAll()
    {

    }

    public function testGetById()
    {

    }

    public function testCreateCanHandleCustomerData()
    {
        // Arrange
        $first_name = 'f1';
        $last_name = 'l1';
        $email = 'mail@home';
        $street = 'dort';
        $city = 'da';

        // Test double für Mock
        $pdo = $this->createMock(\PDO::class);
        $mockStatement = $this->createMock(\PDOStatement::class);
        $mockStatement->method('execute')->with([$first_name,$last_name,$email]);
        $pdo->method('prepare')->willReturn($mockStatement);
        $pdo->method('lastInsertId')->willReturn(4711);

        $repo = new CustomerRepository($pdo);


        // Act
        $customer = $repo->create($first_name, $last_name, $email, $street, $city);

        // Assert
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($first_name, $customer->getFirstName());
        $this->assertSame(4711, $customer->getId());
    }
}
