<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Feestype;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeestypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_feestype');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Feestype $feestype): bool
    {
        return $user->can('view_feestype');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_feestype');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Feestype $feestype): bool
    {
        return $user->can('update_feestype');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Feestype $feestype): bool
    {
        return $user->can('delete_feestype');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_feestype');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Feestype $feestype): bool
    {
        return $user->can('force_delete_feestype');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_feestype');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Feestype $feestype): bool
    {
        return $user->can('restore_feestype');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_feestype');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Feestype $feestype): bool
    {
        return $user->can('replicate_feestype');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_feestype');
    }
}
