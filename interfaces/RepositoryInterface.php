<?php

namespace interfaces;

interface RepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function save($data);
    public function delete($id);
}