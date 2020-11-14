<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    public function testShow()
    {
        $response = $this->get('/lesson/1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText('楽しいヨガレッスン');
        $response->assertSeeText('×');
    }
}
