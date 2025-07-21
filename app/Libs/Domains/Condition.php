<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 馬場状態enum
 */
enum Condition: string
{
    case FIRM = '良';
    case GOOD = '稍重';
    case YIELDING = '重';
    case SOFT = '不良';

    /**
     * 良馬場かどうかを判定
     */
    public function isFirm(): bool
    {
        return $this === self::FIRM;
    }

    /**
     * 稍重馬場かどうかを判定
     */
    public function isGood(): bool
    {
        return $this === self::GOOD;
    }

    /**
     * 重馬場かどうかを判定
     */
    public function isYielding(): bool
    {
        return $this === self::YIELDING;
    }

    /**
     * 不良馬場かどうかを判定
     */
    public function isSoft(): bool
    {
        return $this === self::SOFT;
    }

    /**
     * 重馬場以上（水分多い）かどうかを判定
     */
    public function isHeavyOrWorse(): bool
    {
        return $this === self::YIELDING || $this === self::SOFT;
    }

    /**
     * 水分を含んだ馬場かどうかを判定
     */
    public function isWet(): bool
    {
        return $this !== self::FIRM;
    }

    /**
     * 馬場状態の数値を取得（良=1, 稍重=2, 重=3, 不良=4）
     */
    public function getNumericValue(): int
    {
        return match ($this) {
            self::FIRM => 1,
            self::GOOD => 2,
            self::YIELDING => 3,
            self::SOFT => 4,
        };
    }

    /**
     * より重い馬場状態かどうかを判定
     */
    public function isHeavierThan(Condition $other): bool
    {
        return $this->getNumericValue() > $other->getNumericValue();
    }

    /**
     * より軽い馬場状態かどうかを判定
     */
    public function isLighterThan(Condition $other): bool
    {
        return $this->getNumericValue() < $other->getNumericValue();
    }

    /**
     * 同じ馬場状態かどうかを判定
     */
    public function isSameAs(Condition $other): bool
    {
        return $this->getNumericValue() === $other->getNumericValue();
    }

    /**
     * 理想的な馬場状態かどうかを判定（良・稍重）
     */
    public function isIdeal(): bool
    {
        return $this === self::FIRM || $this === self::GOOD;
    }

    /**
     * 厳しい馬場状態かどうかを判定（重・不良）
     */
    public function isTough(): bool
    {
        return $this === self::YIELDING || $this === self::SOFT;
    }
}
