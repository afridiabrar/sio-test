<?php

namespace App\Contracts;

interface ProjectServiceInterface {
    public function createProject(array $data);
    public function getAllProjects();
    // Define other methods that you need
}
