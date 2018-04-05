<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('discussion.{discussion}', function ($user, \App\Models\Discussion $discussion) {

    if (!$discussion) return false;
    if ($user->id != $discussion->seller->id && $user->id != $discussion->buyer->id) return false;

    return $discussion->status >= \App\Models\Discussion::ACCEPTED;
});

Broadcast::channel('App.User.{userId}', function ($user, $userId) {
    return $userId == $user->id;
});
