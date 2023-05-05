<?php

namespace repository;

use interfaces\ConnectionInterface;
use interfaces\RepositoryInterface;
use PDO;

class PDORepository implements RepositoryInterface
{
    private $db;

    public function __construct(ConnectionInterface $connection)
    {
        $this->db = $connection->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM customers";

        $stmt = $this->db->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getById($id)
    {

        $sql = "SELECT * FROM customers where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data)
    {
        if (isset($data['id'])) {
            $sql = "UPDATE 
                        customers 
                    SET name=:name, address=:address, customer_code=:customer_code, contract_date=:contract_date 
                    WHERE id=:id LIMIT 1";

            $stmt = $this->db->prepare($sql);

            foreach ($data as $k => $v) {
                $stmt->bindValue(':'.$k, $v);
            }

            $stmt->execute();

            return $data;

        } else {
            $sql = "INSERT INTO
                        customers (name, address, customer_code, contract_date)
                    VALUES (:name, :address, :customer_code, :contract_date)";

            $stmt = $this->db->prepare($sql);


            foreach ($data as $k => $v) {
                $stmt->bindValue(':'.$k, $v);
            }

            $stmt->execute();

            return $this->db->lastInsertId();

        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM customers WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id',$id);
        $stmt->execute();
        return $id;
    }
}