<?php

declare(strict_types=1);

namespace Tests\Unit\Libs\Domains;

use App\Libs\Domains\Gender;
use PHPUnit\Framework\TestCase;

class GenderTest extends TestCase
{
    public function test牡馬の判定(): void
    {
        $gender = Gender::MALE;
        
        $this->assertTrue($gender->isMale());
        $this->assertFalse($gender->isFemale());
        $this->assertFalse($gender->isGelding());
    }

    public function test牝馬の判定(): void
    {
        $gender = Gender::FEMALE;
        
        $this->assertFalse($gender->isMale());
        $this->assertTrue($gender->isFemale());
        $this->assertFalse($gender->isGelding());
    }

    public function testせん馬の判定(): void
    {
        $gender = Gender::GELDING;
        
        $this->assertFalse($gender->isMale());
        $this->assertFalse($gender->isFemale());
        $this->assertTrue($gender->isGelding());
    }

    public function test繁殖可能性の判定(): void
    {
        $this->assertTrue(Gender::MALE->canBreed());
        $this->assertTrue(Gender::FEMALE->canBreed());
        $this->assertFalse(Gender::GELDING->canBreed());
    }

    public function test英語表記の取得(): void
    {
        $this->assertEquals('Colt/Horse', Gender::MALE->getEnglishName());
        $this->assertEquals('Filly/Mare', Gender::FEMALE->getEnglishName());
        $this->assertEquals('Gelding', Gender::GELDING->getEnglishName());
    }

    public function test短縮表記の取得(): void
    {
        $this->assertEquals('M', Gender::MALE->getShortName());
        $this->assertEquals('F', Gender::FEMALE->getShortName());
        $this->assertEquals('G', Gender::GELDING->getShortName());
    }

    public function test性別の値(): void
    {
        $this->assertEquals('牡', Gender::MALE->value);
        $this->assertEquals('牝', Gender::FEMALE->value);
        $this->assertEquals('せん', Gender::GELDING->value);
    }
}
