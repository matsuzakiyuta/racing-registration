<?php

declare(strict_types=1);

namespace App\Libs\Domains;

/**
 * 重賞勝利value object
 */
readonly class GradeWin
{
    public function __construct(
        public Race $race,
        public Horse $horse
    ) {
    }

    /**
     * G1勝利かどうかを判定
     */
    public function isG1Win(): bool
    {
        return $this->race->grade->isG1();
    }

    /**
     * G2勝利かどうかを判定
     */
    public function isG2Win(): bool
    {
        return $this->race->grade->isG2();
    }

    /**
     * G3勝利かどうかを判定
     */
    public function isG3Win(): bool
    {
        return $this->race->grade->isG3();
    }

    /**
     * 重賞勝利かどうかを判定
     */
    public function isGradeWin(): bool
    {
        return $this->race->isGradeRace();
    }

    /**
     * 勝利年を取得
     */
    public function getWinYear(): int
    {
        return $this->race->date->getYear();
    }

    /**
     * 勝利時の馬の年齢を取得
     */
    public function getHorseAgeAtWin(): int
    {
        return $this->horse->calculateRaceAge();
    }

    /**
     * 勝利時の馬の性別を取得
     */
    public function getHorseGender(): Gender
    {
        return $this->horse->gender;
    }

    /**
     * 重賞勝利の価値を数値で評価
     */
    public function getValue(): int
    {
        return match (true) {
            $this->isG1Win() => 100,
            $this->isG2Win() => 80,
            $this->isG3Win() => 60,
            default => 20
        };
    }

    /**
     * 勝利の説明を取得
     */
    public function getDescription(): string
    {
        return sprintf(
            '%s %s（%s）',
            $this->race->name,
            $this->race->grade->value,
            $this->horse->name
        );
    }
}
