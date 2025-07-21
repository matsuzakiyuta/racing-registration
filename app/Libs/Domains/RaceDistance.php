<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 距離ドメインクラス
 */
readonly class RaceDistance
{
    public function __construct(
        public int $meters,
        public string $displayName
    ) {
    }

    /**
     * 短距離レースかどうかを判定（1400m以下）
     */
    public function isSprint(): bool
    {
        return $this->meters <= 1400;
    }

    /**
     * マイルレースかどうかを判定（1401m-1800m）
     */
    public function isMile(): bool
    {
        return $this->meters >= 1401 && $this->meters <= 1800;
    }

    /**
     * 中距離レースかどうかを判定（1801m-2400m）
     */
    public function isMiddleDistance(): bool
    {
        return $this->meters >= 1801 && $this->meters <= 2400;
    }

    /**
     * 長距離レースかどうかを判定（2401m以上）
     */
    public function isLongDistance(): bool
    {
        return $this->meters >= 2401;
    }

    /**
     * 障害レース距離かどうかを判定（3000m以上）
     */
    public function isObstacleDistance(): bool
    {
        return $this->meters >= 3000;
    }

    /**
     * 1200mかどうかを判定
     */
    public function is1200m(): bool
    {
        return $this->meters === 1200;
    }

    /**
     * 1400mかどうかを判定
     */
    public function is1400m(): bool
    {
        return $this->meters === 1400;
    }

    /**
     * 1600mかどうかを判定
     */
    public function is1600m(): bool
    {
        return $this->meters === 1600;
    }

    /**
     * 1800mかどうかを判定
     */
    public function is1800m(): bool
    {
        return $this->meters === 1800;
    }

    /**
     * 2000mかどうかを判定
     */
    public function is2000m(): bool
    {
        return $this->meters === 2000;
    }

    /**
     * 2400mかどうかを判定
     */
    public function is2400m(): bool
    {
        return $this->meters === 2400;
    }

    /**
     * 3000mかどうかを判定
     */
    public function is3000m(): bool
    {
        return $this->meters === 3000;
    }

    /**
     * 距離カテゴリを取得
     */
    public function getCategory(): string
    {
        return match (true) {
            $this->isSprint() => '短距離',
            $this->isMile() => 'マイル',
            $this->isMiddleDistance() => '中距離',
            $this->isLongDistance() => '長距離',
            default => 'その他'
        };
    }

    /**
     * 距離を比較
     */
    public function isLongerThan(RaceDistance $other): bool
    {
        return $this->meters > $other->meters;
    }

    /**
     * 距離を比較
     */
    public function isShorterThan(RaceDistance $other): bool
    {
        return $this->meters < $other->meters;
    }

    /**
     * 距離が同じかどうかを判定
     */
    public function isSameAs(RaceDistance $other): bool
    {
        return $this->meters === $other->meters;
    }
}
