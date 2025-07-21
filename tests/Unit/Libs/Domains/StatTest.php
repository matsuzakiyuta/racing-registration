<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\Stat;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StatTest extends TestCase
{
    public function test正常な成績の作成(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(100, $stat->totalRides);
        $this->assertEquals(20, $stat->wins);
        $this->assertEquals(15, $stat->place);
        $this->assertEquals(10, $stat->shows);
        $this->assertEquals(45, $stat->top3Finishes);
        $this->assertEquals(2023, $stat->year);
    }

    public function test負の総出走数でエラー(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('総出走数は0以上である必要があります');
        
        new Stat(
            totalRides: -1,
            wins: 0,
            place: 0,
            shows: 0,
            top3Finishes: 0,
            year: 2023
        );
    }

    public function test勝利数が総出走数を超えるとエラー(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('勝利数は0以上、総出走数以下である必要があります');
        
        new Stat(
            totalRides: 10,
            wins: 11,
            place: 0,
            shows: 0,
            top3Finishes: 0,
            year: 2023
        );
    }

    public function test年が範囲外でエラー(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('年は1900年から2100年の範囲である必要があります');
        
        new Stat(
            totalRides: 10,
            wins: 5,
            place: 2,
            shows: 1,
            top3Finishes: 8,
            year: 1899
        );
    }

    public function test勝率の計算(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(20.0, $stat->getWinRate());
    }

    public function test連対率の計算(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(35.0, $stat->getPlaceRate());
    }

    public function test複勝率の計算(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(45.0, $stat->getShowRate());
    }

    public function test着外数の計算(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(55, $stat->getUnplacedCount());
    }

    public function test着外率の計算(): void
    {
        $stat = new Stat(
            totalRides: 100,
            wins: 20,
            place: 15,
            shows: 10,
            top3Finishes: 45,
            year: 2023
        );
        
        $this->assertEquals(55.0, $stat->getUnplacedRate());
    }

    public function test総出走数が0の場合の勝率(): void
    {
        $stat = new Stat(
            totalRides: 0,
            wins: 0,
            place: 0,
            shows: 0,
            top3Finishes: 0,
            year: 2023
        );
        
        $this->assertEquals(0.0, $stat->getWinRate());
        $this->assertEquals(0.0, $stat->getPlaceRate());
        $this->assertEquals(0.0, $stat->getShowRate());
        $this->assertEquals(0.0, $stat->getUnplacedRate());
    }

    public function test成績評価の判定(): void
    {
        $excellentStat = new Stat(100, 25, 15, 10, 50, 2023);
        $this->assertTrue($excellentStat->isExcellent());
        $this->assertTrue($excellentStat->isGood());
        
        $goodStat = new Stat(100, 15, 15, 10, 40, 2023);
        $this->assertFalse($goodStat->isExcellent());
        $this->assertTrue($goodStat->isGood());
        
        $poorStat = new Stat(100, 5, 15, 10, 30, 2023);
        $this->assertFalse($poorStat->isExcellent());
        $this->assertFalse($poorStat->isGood());
    }

    public function testデータ存在の判定(): void
    {
        $statWithData = new Stat(100, 20, 15, 10, 45, 2023);
        $this->assertTrue($statWithData->hasData());
        
        $statWithoutData = new Stat(0, 0, 0, 0, 0, 2023);
        $this->assertFalse($statWithoutData->hasData());
    }

    public function test年カテゴリの取得(): void
    {
        $currentYear = (int)date('Y');
        
        $thisYearStat = new Stat(100, 20, 15, 10, 45, $currentYear);
        $this->assertEquals('今年', $thisYearStat->getYearCategory());
        
        $lastYearStat = new Stat(100, 20, 15, 10, 45, $currentYear - 1);
        $this->assertEquals('昨年', $lastYearStat->getYearCategory());
        
        $recentStat = new Stat(100, 20, 15, 10, 45, $currentYear - 2);
        $this->assertEquals('近年', $recentStat->getYearCategory());
        
        $pastStat = new Stat(100, 20, 15, 10, 45, $currentYear - 5);
        $this->assertEquals('過去', $pastStat->getYearCategory());
    }

    public function test成績サマリーの取得(): void
    {
        $stat = new Stat(100, 20, 15, 10, 45, 2023);
        
        $expected = '100戦20勝15着10着（勝率20.0%）';
        $this->assertEquals($expected, $stat->getSummary());
    }
}
