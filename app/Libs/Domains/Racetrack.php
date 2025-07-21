<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 競馬場ドメインクラス
 */
readonly class Racetrack
{
    public function __construct(
        public string $name,
        public string $region,
        public string $location,
        public bool $isMainTrack
    ) {
    }

    /**
     * 関東の競馬場かどうかを判定
     */
    public function isKanto(): bool
    {
        return $this->region === '関東';
    }

    /**
     * 関西の競馬場かどうかを判定
     */
    public function isKansai(): bool
    {
        return $this->region === '関西';
    }

    /**
     * ローカル競馬場かどうかを判定
     */
    public function isLocal(): bool
    {
        return !$this->isMainTrack;
    }

    /**
     * 中央競馬場かどうかを判定
     */
    public function isCentral(): bool
    {
        return $this->isMainTrack;
    }

    /**
     * 東京競馬場かどうかを判定
     */
    public function isTokyo(): bool
    {
        return $this->name === '東京';
    }

    /**
     * 中山競馬場かどうかを判定
     */
    public function isNakayama(): bool
    {
        return $this->name === '中山';
    }

    /**
     * 京都競馬場かどうかを判定
     */
    public function isKyoto(): bool
    {
        return $this->name === '京都';
    }

    /**
     * 阪神競馬場かどうかを判定
     */
    public function isHanshin(): bool
    {
        return $this->name === '阪神';
    }

    /**
     * 中京競馬場かどうかを判定
     */
    public function isChukyo(): bool
    {
        return $this->name === '中京';
    }

    /**
     * 新潟競馬場かどうかを判定
     */
    public function isNiigata(): bool
    {
        return $this->name === '新潟';
    }

    /**
     * 福島競馬場かどうかを判定
     */
    public function isFukushima(): bool
    {
        return $this->name === '福島';
    }

    /**
     * 小倉競馬場かどうかを判定
     */
    public function isKokura(): bool
    {
        return $this->name === '小倉';
    }

    /**
     * 主要4場（東京・中山・京都・阪神）かどうかを判定
     */
    public function isMajorTrack(): bool
    {
        return in_array($this->name, ['東京', '中山', '京都', '阪神'], true);
    }

    /**
     * ローカル開催かどうかを判定
     */
    public function isLocalMeeting(): bool
    {
        return in_array($this->name, ['新潟', '福島', '中京', '小倉'], true);
    }
}
