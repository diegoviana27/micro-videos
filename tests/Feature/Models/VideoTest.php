<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{

    use DatabaseMigrations;

    public function testList()
    {
        factory(Video::class, 1)->create();
        $videos = Video::all();
        $this->assertCount(1, $videos);
        $videoKey = array_keys($videos->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [   'id',
                'title',
                'description',
                'year_launched',
                'opened',
                'rating',
                'duration',
                'deleted_at',
                'created_at',
                'updated_at'
            ], $videoKey
        );
    }

    public function testCreate(){

        $video = Video::create([
            'title' => 'test1',
            'description' => 'xxxxxx',
            'year_launched' => 2010,
            'rating' => Video::RATING_LIST[0],
            'duration' => 90
        ]);

        $video->refresh();
        $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $this->assertRegExp($UUIDv4 ,$video->id);
        $this->assertEquals('test1', $video->title);
        $this->assertEquals('xxxxxx', $video->description);
        $this->assertFalse($video->opened);


        $video = Video::create([
            'title' => 'test1',
            'description' => 'xxxxxx',
            'year_launched' => 2010,
            'rating' => Video::RATING_LIST[0],
            'duration' => 90,
            'opened' => true
        ]);
        $this->assertTrue($video->opened);
    }

    public function  testUpdate(){

        $video = Video::create([
            'title' => 'test1',
            'description' => 'xxxxxx',
            'year_launched' => 2010,
            'rating' => Video::RATING_LIST[0],
            'duration' => 90
        ]);

        $data = [
            'title' => 'title updated',
            'description' => 'description updated',
            'opened' => true
        ];

        $video->update($data);

        foreach ($data as $key => $value){
            $this->assertEquals($value, $video->{$key});
        }
    }

    public function  testDelete(){

        $video = factory(Video::class)->create([
            'opened' => false
        ])->first();
        $video->delete();
        $videoRecoverd = Video::find($video->id);
        $this->assertEmpty($videoRecoverd);
    }

}
