<?php

namespace App\Services;

use App\Contracts\UserProjectServiceInterface;
use App\Models\UserProject;
use Illuminate\Support\Facades\DB;

class UserProjectService implements UserProjectServiceInterface {
    public function createUserProject(array $data):array {
        DB::beginTransaction();
        try {
            $exists = UserProject::where('user_id', $data['user_id'])
                ->where('project_id', $data['project_id'])
                ->exists();

            if ($exists) {
                DB::rollBack();
                return ['error' => 'User already assigned to this project.'];
            }

            UserProject::create([
                'user_id' => $data['user_id'],
                'project_id' => $data['project_id'],
            ]);

            DB::commit();
            return ['success' => 'Project successfully assigned to user.'];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Rethrow the exception to be caught by the caller.
        }
    }
    // Implement other methods defined in the interface
}
