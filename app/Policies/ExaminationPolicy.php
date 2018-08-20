<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Examination;

class ExaminationPolicy extends Policy
{
    public function update(User $user, Examination $examination)
    {
        // return $examination->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Examination $examination)
    {
        return true;
    }
}
