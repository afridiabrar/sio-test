<?php

namespace App\Services;

use App\Contracts\ProjectServiceInterface;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectService implements ProjectServiceInterface {
    public function createProject(array $data):array {
        DB::beginTransaction();
        try {
            $project = Project::create([
                'title' => htmlentities($data['title']),
                'description' => htmlentities($data['description']),
            ]);
            DB::commit(); // Commit the transaction if no errors
            return $project;
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction on error
            throw $e; // Rethrow the exception to be handled by the caller
        }
    }

    public function getAllProjects():object {
        return Project::get();
    }

    // Implement other methods defined in the interface
}
