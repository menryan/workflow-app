<?php

namespace App\Enums;

enum TaskStatus: string
{
    case DRAFT = 'draft';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::DRAFT => $next === self::IN_PROGRESS,
            self::IN_PROGRESS => $next === self::COMPLETED,
            self::COMPLETED => false,
        };
    }
}
