<?php
/**
 * Created by PhpStorm.
 * User: itnrw
 * Date: 13.09.18
 * Time: 08:39
 */

namespace App\Service;


use App\Model\Customer;

class CustomerRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $db)
    {
        $this->pdo = $db;
    }

    public function getAll()
    {
        $query = "SELECT c.customer_id, c.first_name, c.last_name, c.email, "
            . "a.address, s.city FROM customer as c, address as a, city as s "
            . "WHERE c.address_id = a.address_id AND a.city_id = s.city_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $customers = [];
        while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $customers[] = Customer::createFromArray($row);
        }

        return $customers;
    }

    public function getById()
    {

    }

    public function create($firstName,  $lastName, $email, $street, $city)
    {

        $stmt = $this->pdo->prepare('INSERT INTO customer (store_id, first_name, last_name, email, address_id, active, create_date) VALUES (1, ?, ?, ?, 1, 1, NOW)');
        $stmt->execute([ $firstName, $lastName, $email]);
        $id = $this->pdo->lastInsertId();

        $customer = new Customer();
        $customer->setFirstName($firstName);
        $customer->setId($id);

        return $customer;
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}