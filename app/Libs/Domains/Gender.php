<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 性別enum
 */
enum Gender: string
{
    case MALE = '牡';
    case FEMALE = '牝';
    case GELDING = 'せん';

    /**
     * 牡馬かどうかを判定
     */
    public function isMale(): bool
    {
        return $this === self::MALE;
    }

    /**
     * 牝馬かどうかを判定
     */
    public function isFemale(): bool
    {
        return $this === self::FEMALE;
    }

    /**
     * せん馬かどうかを判定
     */
    public function isGelding(): bool
    {
        return $this === self::GELDING;
    }

    /**
     * 繁殖に適しているかどうかを判定
     */
    public function canBreed(): bool
    {
        return $this === self::MALE || $this === self::FEMALE;
    }

    /**
     * 英語表記を取得
     */
    public function getEnglishName(): string
    {
        return match ($this) {
            self::MALE => 'Colt/Horse',
            self::FEMALE => 'Filly/Mare',
            self::GELDING => 'Gelding',
        };
    }

    /**
     * 短縮表記を取得
     */
    public function getShortName(): string
    {
        return match ($this) {
            self::MALE => 'M',
            self::FEMALE => 'F',
            self::GELDING => 'G',
        };
    }
}
