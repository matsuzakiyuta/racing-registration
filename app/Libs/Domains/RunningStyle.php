<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 脚質enum
 */
enum RunningStyle: string
{
    case FRONT_RUNNER = '逃げ';
    case STALKER = '先行';
    case CLOSER = '差し';
    case DEEP_CLOSER = '追込み';

    /**
     * 逃げ馬かどうかを判定
     */
    public function isFrontRunner(): bool
    {
        return $this === self::FRONT_RUNNER;
    }

    /**
     * 先行馬かどうかを判定
     */
    public function isStalker(): bool
    {
        return $this === self::STALKER;
    }

    /**
     * 差し馬かどうかを判定
     */
    public function isCloser(): bool
    {
        return $this === self::CLOSER;
    }

    /**
     * 追込み馬かどうかを判定
     */
    public function isDeepCloser(): bool
    {
        return $this === self::DEEP_CLOSER;
    }

    /**
     * 前につけるタイプかどうかを判定
     */
    public function isEarlySpeed(): bool
    {
        return $this === self::FRONT_RUNNER || $this === self::STALKER;
    }

    /**
     * 後方からのタイプかどうかを判定
     */
    public function isLateSpeed(): bool
    {
        return $this === self::CLOSER || $this === self::DEEP_CLOSER;
    }

    /**
     * 英語表記を取得
     */
    public function getEnglishName(): string
    {
        return match ($this) {
            self::FRONT_RUNNER => 'Front Runner',
            self::STALKER => 'Stalker',
            self::CLOSER => 'Closer',
            self::DEEP_CLOSER => 'Deep Closer',
        };
    }

    /**
     * 短縮表記を取得
     */
    public function getShortName(): string
    {
        return match ($this) {
            self::FRONT_RUNNER => '逃',
            self::STALKER => '先',
            self::CLOSER => '差',
            self::DEEP_CLOSER => '追',
        };
    }

    /**
     * 脚質の説明を取得
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::FRONT_RUNNER => 'スタートから先頭に立ち、そのまま押し切る戦法',
            self::STALKER => '前の方につけて、直線で抜け出す戦法',
            self::CLOSER => '中団から直線で差しきる戦法',
            self::DEEP_CLOSER => '後方から最後の直線で一気に追い込む戦法',
        };
    }

    /**
     * 適正距離傾向を取得
     */
    public function getDistanceTendency(): string
    {
        return match ($this) {
            self::FRONT_RUNNER => '短距離〜中距離',
            self::STALKER => 'オールラウンド',
            self::CLOSER => '中距離〜長距離',
            self::DEEP_CLOSER => '中距離〜長距離',
        };
    }
}
