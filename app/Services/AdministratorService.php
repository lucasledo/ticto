<?php

namespace App\Services;

use App\Models\User;
use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdministratorService
{
       protected $userPersonService;

    public function __construct(UserPersonService $userPersonService)
    {
        $this->userPersonService = $userPersonService;
    }

    public function create(array $data, User $user): Administrator
    {
        $person = $this->userPersonService->create($data, Role::where('role', 'Administrator')->first());

        return DB::transaction(function() use ($data, $user, $person) {
            return Administrator::create([
                'person_id'         => $person->id,
            ]);
        });
    }

    public function update(Administrator $administrator, array $data): Administrator
    {
        return $this->userPersonService->update($administrator, $data);
    }

    public function delete(Administrator $administrator)
    {
        $this->userPersonService->delete($administrator);

        return DB::transaction(function() use ($administrator) {
            return $administrator->delete();
        });
    }
}
