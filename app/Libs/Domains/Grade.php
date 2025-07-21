<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * レース格付けenum
 */
enum Grade: string
{
    case G1 = 'G1';
    case G2 = 'G2';
    case G3 = 'G3';
    case LISTED = 'Listed';
    case OPEN = 'Open';
    case OTHER = 'Other';

    /**
     * G1かどうかを判定
     */
    public function isG1(): bool
    {
        return $this === self::G1;
    }

    /**
     * G2かどうかを判定
     */
    public function isG2(): bool
    {
        return $this === self::G2;
    }

    /**
     * G3かどうかを判定
     */
    public function isG3(): bool
    {
        return $this === self::G3;
    }

    /**
     * 重賞（G1-G3）かどうかを判定
     */
    public function isGradeRace(): bool
    {
        return in_array($this, [self::G1, self::G2, self::G3], true);
    }

    /**
     * リステッド競走かどうかを判定
     */
    public function isListed(): bool
    {
        return $this === self::LISTED;
    }

    /**
     * オープン特別かどうかを判定
     */
    public function isOpen(): bool
    {
        return $this === self::OPEN;
    }

    /**
     * 条件戦かどうかを判定
     */
    public function isOther(): bool
    {
        return $this === self::OTHER;
    }

    /**
     * 特別競走（重賞・リステッド・オープン）かどうかを判定
     */
    public function isSpecialRace(): bool
    {
        return $this->isGradeRace() || $this->isListed() || $this->isOpen();
    }

    /**
     * 格付けの数値を取得（G1=1, G2=2, G3=3, Listed=4, Open=5, Other=6）
     */
    public function getValue(): int
    {
        return match ($this) {
            self::G1 => 1,
            self::G2 => 2,
            self::G3 => 3,
            self::LISTED => 4,
            self::OPEN => 5,
            self::OTHER => 6,
        };
    }

    /**
     * より格が高いかどうかを判定
     */
    public function isHigherThan(Grade $other): bool
    {
        return $this->getValue() < $other->getValue();
    }

    /**
     * より格が低いかどうかを判定
     */
    public function isLowerThan(Grade $other): bool
    {
        return $this->getValue() > $other->getValue();
    }

    /**
     * 同格かどうかを判定
     */
    public function isSameAs(Grade $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    /**
     * 日本語表示名を取得
     */
    public function getDisplayName(): string
    {
        return match ($this) {
            self::G1 => 'G1',
            self::G2 => 'G2',
            self::G3 => 'G3',
            self::LISTED => '準重賞',
            self::OPEN => 'オープン',
            self::OTHER => '条件戦',
        };
    }

    /**
     * 賞金ランクを取得（1が最高）
     */
    public function getPrizeRank(): int
    {
        return $this->getValue();
    }
}
