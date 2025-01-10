<?php

namespace Modules\Codes\Policies;

use Modules\Users\App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Codes\models\Code;

class CodesApiPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Code $Code): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Code $Code): bool
    {
        return false;
    }

    public function delete(User $user, Code $Code): bool
    {
        return false;
    }
}
