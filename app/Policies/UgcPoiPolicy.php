<?php

namespace App\Policies;

use App\Models\UgcPoi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UgcPoiPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UgcPoi  $ugcPoi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UgcPoi $ugcPoi)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UgcPoi  $ugcPoi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UgcPoi $ugcPoi)
    {
        if ($user->hasRole('Administrator') || ($ugcPoi->user_id === $user->id && $ugcPoi->validated === 'not_validated')) {
            return true;
        }

        $permission = $ugcPoi->form_id === 'water' ? 'source surveys' : str_replace('_', ' ', $ugcPoi->form_id);
        $permission = 'validate ' . $permission;
        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UgcPoi  $ugcPoi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UgcPoi $ugcPoi)
    {
        return $user->is_administrator || ($user->id === $ugcPoi->user_id && $ugcPoi->validated !== 'valid');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UgcPoi  $ugcPoi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UgcPoi $ugcPoi)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UgcPoi  $ugcPoi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UgcPoi $ugcPoi)
    {
        return true;
    }
}