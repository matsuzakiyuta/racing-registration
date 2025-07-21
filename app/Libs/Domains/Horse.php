<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 馬ドメインクラス
 */
readonly class Horse
{
    public function __construct(
        public string $name,
        public Gender $gender,
        public Birthday $birthday,
        public RunningStyle $runningStyle
    ) {
    }

    /**
     * 牡馬かどうかを判定
     */
    public function isMale(): bool
    {
        return $this->gender->isMale();
    }

    /**
     * 牝馬かどうかを判定
     */
    public function isFemale(): bool
    {
        return $this->gender->isFemale();
    }

    /**
     * せん馬かどうかを判定
     */
    public function isGelding(): bool
    {
        return $this->gender->isGelding();
    }

    /**
     * 年齢による競走馬カテゴリを取得
     */
    public function getAgeCategory(): string
    {
        return $this->birthday->getAgeCategory();
    }

    /**
     * 2歳馬かどうかを判定
     */
    public function isTwoYearOld(): bool
    {
        return $this->birthday->isTwoYearOld();
    }

    /**
     * 3歳馬かどうかを判定
     */
    public function isThreeYearOld(): bool
    {
        return $this->birthday->isThreeYearOld();
    }

    /**
     * 古馬かどうかを判定
     */
    public function isOlderHorse(): bool
    {
        return $this->birthday->isOlderHorse();
    }

    /**
     * 現在の年齢を計算
     */
    public function calculateCurrentAge(): int
    {
        return $this->birthday->calculateAge();
    }

    /**
     * 競走馬の年齢を計算（1月1日基準）
     */
    public function calculateRaceAge(): int
    {
        return $this->birthday->calculateRaceAge();
    }

    /**
     * 逃げ馬かどうかを判定
     */
    public function isFrontRunner(): bool
    {
        return $this->runningStyle->isFrontRunner();
    }

    /**
     * 先行馬かどうかを判定
     */
    public function isStalker(): bool
    {
        return $this->runningStyle->isStalker();
    }

    /**
     * 差し馬かどうかを判定
     */
    public function isCloser(): bool
    {
        return $this->runningStyle->isCloser();
    }

    /**
     * 追込み馬かどうかを判定
     */
    public function isDeepCloser(): bool
    {
        return $this->runningStyle->isDeepCloser();
    }

    /**
     * 前につけるタイプかどうかを判定
     */
    public function isEarlySpeed(): bool
    {
        return $this->runningStyle->isEarlySpeed();
    }

    /**
     * 後方からのタイプかどうかを判定
     */
    public function isLateSpeed(): bool
    {
        return $this->runningStyle->isLateSpeed();
    }

    /**
     * 馬名を取得
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 性別を取得
     */
    public function getGender(): Gender
    {
        return $this->gender;
    }

    /**
     * 誕生日を取得
     */
    public function getBirthday(): Birthday
    {
        return $this->birthday;
    }

    /**
     * 脚質を取得
     */
    public function getRunningStyle(): RunningStyle
    {
        return $this->runningStyle;
    }
}
