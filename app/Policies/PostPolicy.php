<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return  $user->id == $post->user_id || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return  $user->id == $post->user_id || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete Multi model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore Multi model.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete Multi model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    public function publish(User $user, Post $post): bool
    {
        return  $user->id == $post->user_id || $user->id == 1;
    }


}
