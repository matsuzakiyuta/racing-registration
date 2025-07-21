<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 馬場種別enum
 */
enum Surface: string
{
    case TURF = '芝';
    case DIRT = 'ダート';
    case OBSTACLE = '障害';

    /**
     * 芝かどうかを判定
     */
    public function isTurf(): bool
    {
        return $this === self::TURF;
    }

    /**
     * ダートかどうかを判定
     */
    public function isDirt(): bool
    {
        return $this === self::DIRT;
    }

    /**
     * 障害かどうかを判定
     */
    public function isObstacle(): bool
    {
        return $this === self::OBSTACLE;
    }

    /**
     * 平地競走かどうかを判定
     */
    public function isFlat(): bool
    {
        return $this === self::TURF || $this === self::DIRT;
    }
}
