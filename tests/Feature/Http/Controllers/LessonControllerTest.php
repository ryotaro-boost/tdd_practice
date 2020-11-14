<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    public function testShow()
    {
        $lesson = factory(Lesson::class)->create(['name' => '楽しいヨガレッスン']);

        $response = $this->get("/lessons/{$lesson->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText($lesson->name);
        $response->assertSeeText('空き状況:×');
    }
}
