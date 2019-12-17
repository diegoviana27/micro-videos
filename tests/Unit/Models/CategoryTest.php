<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

# Classe específica                 - vendor/bin/phpunit tests/Unit/CategoryTest.php
# Classe específico em um arquivo   - vendor/bin/phpunit --filter testIfUseTraits tests/Unit/CategoryTest.php
# Método específico em uma classe   - vendor/bin/phpunit --filter CategoryTest::testIfUseTraits

class CategoryTest extends TestCase
{

    private $category;

    protected  function  setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->category = new Category();
    }

    public function testFillableAttribute()
    {
        $filllable = ['name', 'description', 'is_active'];
        $this->assertEquals($filllable,
            $this->category->getFillable());
    }

    public function testDatesAttribute(){
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->category->getDates());
        }
        $this->assertCount(count($dates), $this->category->getDates());
    }

    public function testIfUseTraits(){
        $traits = [
          SoftDeletes::class , Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits );
    }

    public function testCasts()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $this->assertEquals($casts,  $this->category->getCasts());
    }

    public function testIncrementing()
    {
        $casts = ['id' => 'string'];
        $this->assertFalse($this->category->incrementing);
    }
}