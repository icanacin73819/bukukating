<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{bookId}.{userOne}.{userTwo}', function ($user, $bookId, $userOne, $userTwo) {
    return in_array((int) $user->id, [(int) $userOne, (int) $userTwo]);
});