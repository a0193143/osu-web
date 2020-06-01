<?php

// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

namespace App\Jobs\Notifications;

use App\Exceptions\InvalidNotificationException;
use App\Models\Follow;
use App\Models\User;

class CommentNew extends BroadcastNotificationBase
{
    public function __construct($object, User $source)
    {
        parent::__construct($object, $source);

        if ($this->object->commentable === null) {
            throw new InvalidNotificationException("comment_new: comment #{$this->object->getKey()} missing commentable");
        }
    }

    public function getDetails(): array
    {
        return [
            'comment_id' => $this->object->getKey(),
            'title' => $this->object->commentable->commentableTitle(),
            'content' => truncate($this->object->message, static::CONTENT_TRUNCATE),
            'cover_url' => $this->object->commentable->notificationCover(),
        ];
    }

    public function getListentingUserIds(): array
    {
        return Follow::whereNotifiable($this->object->commentable)
            ->where(['subtype' => 'comment'])
            ->pluck('user_id')
            ->all();
    }

    public function getNotifiable()
    {
        return $this->object->commentable;
    }
}
