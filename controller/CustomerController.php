<?php

namespace controller;

use interfaces\RepositoryInterface;

class CustomerController
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function processRequest($method, $id = null)
    {
        if ($id == null) {

            // check method
            if($method == "GET") {
                echo json_encode($this->repository->getAll());
            } elseif ($method == "POST") {

                $data = (array) json_decode(file_get_contents("php://input"));

                $id = $this->repository->save($data);

                echo json_encode($id);
            }

        } else {

            $customer = $this->repository->getById($id);

            switch ($method) {

                case "GET":
                    echo json_encode($customer);
                    break;

                case "PATCH":
                    $data = (array) json_decode(file_get_contents("php://input"));
                    $data['id'] = $id;
                    $result = $this->repository->save($data);
                    echo json_encode($result);

                    break;

                case "DELETE":
                    $rows = $this->repository->delete($id);
                    echo json_encode(["message" => "Task deleted", "rows" => $rows]);
                    break;

                default:
                    throw new \Exception('not supported method');
            }
        }
    }
}