<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\RunningStyle;
use PHPUnit\Framework\TestCase;

class RunningStyleTest extends TestCase
{
    public function test逃げ馬の判定(): void
    {
        $style = RunningStyle::FRONT_RUNNER;
        
        $this->assertTrue($style->isFrontRunner());
        $this->assertFalse($style->isStalker());
        $this->assertFalse($style->isCloser());
        $this->assertFalse($style->isDeepCloser());
    }

    public function test先行馬の判定(): void
    {
        $style = RunningStyle::STALKER;
        
        $this->assertFalse($style->isFrontRunner());
        $this->assertTrue($style->isStalker());
        $this->assertFalse($style->isCloser());
        $this->assertFalse($style->isDeepCloser());
    }

    public function test差し馬の判定(): void
    {
        $style = RunningStyle::CLOSER;
        
        $this->assertFalse($style->isFrontRunner());
        $this->assertFalse($style->isStalker());
        $this->assertTrue($style->isCloser());
        $this->assertFalse($style->isDeepCloser());
    }

    public function test追込み馬の判定(): void
    {
        $style = RunningStyle::DEEP_CLOSER;
        
        $this->assertFalse($style->isFrontRunner());
        $this->assertFalse($style->isStalker());
        $this->assertFalse($style->isCloser());
        $this->assertTrue($style->isDeepCloser());
    }

    public function test前につけるタイプの判定(): void
    {
        $this->assertTrue(RunningStyle::FRONT_RUNNER->isEarlySpeed());
        $this->assertTrue(RunningStyle::STALKER->isEarlySpeed());
        $this->assertFalse(RunningStyle::CLOSER->isEarlySpeed());
        $this->assertFalse(RunningStyle::DEEP_CLOSER->isEarlySpeed());
    }

    public function test後方からのタイプの判定(): void
    {
        $this->assertFalse(RunningStyle::FRONT_RUNNER->isLateSpeed());
        $this->assertFalse(RunningStyle::STALKER->isLateSpeed());
        $this->assertTrue(RunningStyle::CLOSER->isLateSpeed());
        $this->assertTrue(RunningStyle::DEEP_CLOSER->isLateSpeed());
    }

    public function test英語表記の取得(): void
    {
        $this->assertEquals('Front Runner', RunningStyle::FRONT_RUNNER->getEnglishName());
        $this->assertEquals('Stalker', RunningStyle::STALKER->getEnglishName());
        $this->assertEquals('Closer', RunningStyle::CLOSER->getEnglishName());
        $this->assertEquals('Deep Closer', RunningStyle::DEEP_CLOSER->getEnglishName());
    }

    public function test短縮表記の取得(): void
    {
        $this->assertEquals('逃', RunningStyle::FRONT_RUNNER->getShortName());
        $this->assertEquals('先', RunningStyle::STALKER->getShortName());
        $this->assertEquals('差', RunningStyle::CLOSER->getShortName());
        $this->assertEquals('追', RunningStyle::DEEP_CLOSER->getShortName());
    }

    public function test説明の取得(): void
    {
        $this->assertEquals(
            'スタートから先頭に立ち、そのまま押し切る戦法',
            RunningStyle::FRONT_RUNNER->getDescription()
        );
        $this->assertEquals(
            '前の方につけて、直線で抜け出す戦法',
            RunningStyle::STALKER->getDescription()
        );
        $this->assertEquals(
            '中団から直線で差しきる戦法',
            RunningStyle::CLOSER->getDescription()
        );
        $this->assertEquals(
            '後方から最後の直線で一気に追い込む戦法',
            RunningStyle::DEEP_CLOSER->getDescription()
        );
    }

    public function test適正距離傾向の取得(): void
    {
        $this->assertEquals('短距離〜中距離', RunningStyle::FRONT_RUNNER->getDistanceTendency());
        $this->assertEquals('オールラウンド', RunningStyle::STALKER->getDistanceTendency());
        $this->assertEquals('中距離〜長距離', RunningStyle::CLOSER->getDistanceTendency());
        $this->assertEquals('中距離〜長距離', RunningStyle::DEEP_CLOSER->getDistanceTendency());
    }

    public function test脚質の値(): void
    {
        $this->assertEquals('逃げ', RunningStyle::FRONT_RUNNER->value);
        $this->assertEquals('先行', RunningStyle::STALKER->value);
        $this->assertEquals('差し', RunningStyle::CLOSER->value);
        $this->assertEquals('追込み', RunningStyle::DEEP_CLOSER->value);
    }
}
