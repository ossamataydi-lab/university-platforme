<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| conversation.{id1}.{id2} — private channel for the two users in a chat.
| Only participants can subscribe. id1 < id2 (sorted).
|
*/

Broadcast::channel('conversation.{id1}.{id2}', function ($user, $id1, $id2) {
    $id1 = (int) $id1;
    $id2 = (int) $id2;
    return $user->id === $id1 || $user->id === $id2;
});
