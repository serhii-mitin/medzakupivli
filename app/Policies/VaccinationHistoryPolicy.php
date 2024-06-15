<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VaccinationHistory;
use App\Utils\Enums\VaccinationHistory\VaccinationHistoryStatusEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class VaccinationHistoryPolicy
{
    use HandlesAuthorization;

    public function cancel(User $user, VaccinationHistory $history, User $patient): bool
    {
        return
            $patient->id == $history->user_id &&
            $history->status == VaccinationHistoryStatusEnum::SELECTED &&
            $history->selected_time > now();
    }
}
