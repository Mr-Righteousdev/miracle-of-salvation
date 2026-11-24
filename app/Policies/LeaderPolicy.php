<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Leader;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LeaderPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Leader');
    }

    public function view(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('View:Leader');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Leader');
    }

    public function update(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('Update:Leader');
    }

    public function delete(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('Delete:Leader');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Leader');
    }

    public function restore(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('Restore:Leader');
    }

    public function forceDelete(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('ForceDelete:Leader');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Leader');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Leader');
    }

    public function replicate(AuthUser $authUser, Leader $leader): bool
    {
        return $authUser->can('Replicate:Leader');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Leader');
    }
}
