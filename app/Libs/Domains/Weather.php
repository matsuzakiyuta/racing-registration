<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 天候enum
 */
enum Weather: string
{
    case CLEAR = '晴';
    case CLOUDY = '曇';
    case RAINY = '雨';
    case LIGHT_RAIN = '小雨';
    case HEAVY_RAIN = '大雨';
    case SNOW = '雪';

    /**
     * 晴れかどうかを判定
     */
    public function isClear(): bool
    {
        return $this === self::CLEAR;
    }

    /**
     * 曇りかどうかを判定
     */
    public function isCloudy(): bool
    {
        return $this === self::CLOUDY;
    }

    /**
     * 雨かどうかを判定
     */
    public function isRainy(): bool
    {
        return in_array($this, [self::RAINY, self::LIGHT_RAIN, self::HEAVY_RAIN], true);
    }

    /**
     * 小雨かどうかを判定
     */
    public function isLightRain(): bool
    {
        return $this === self::LIGHT_RAIN;
    }

    /**
     * 大雨かどうかを判定
     */
    public function isHeavyRain(): bool
    {
        return $this === self::HEAVY_RAIN;
    }

    /**
     * 雪かどうかを判定
     */
    public function isSnow(): bool
    {
        return $this === self::SNOW;
    }

    /**
     * 悪天候かどうかを判定
     */
    public function isBadWeather(): bool
    {
        return $this->isRainy() || $this->isSnow();
    }

    /**
     * 好天候かどうかを判定
     */
    public function isGoodWeather(): bool
    {
        return $this === self::CLEAR || $this === self::CLOUDY;
    }
}
