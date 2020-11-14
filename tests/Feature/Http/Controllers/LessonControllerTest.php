<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    /**
     * @param int $reservationCount
     * @param int $capacity
     * @param string $expectedVacancyLevelMark
     * @dataProvider dataShow
     */
    public function testShow(int $reservationCount, int $capacity, string $expectedVacancyLevelMark)
    {
        $lesson = factory(Lesson::class)->create(['name' => '楽しいヨガレッスン', 'capacity' => $capacity]);
        for ($i =0;$i<$reservationCount;$i++) {
            $user = factory(User::class)->create();
            $lesson->reservations()->save(factory(Reservation::class)->make(['user_id' => $user]));
        }
        $response = $this->get("/lessons/{$lesson->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSeeText($lesson->name);
        $response->assertSeeText('空き状況:{$expectedVacancyLevelMark}');
    }

    public function dataShow()
    {
        return [
            '空きなし' => [
                'reservationCount' => 10,
                'capacity' => 10,
                '$expectedVacancyLevelMark' => '×',
            ],
            '残りわずか' => [
                'reservationCount' => 6,
                'capacity' => 10,
                '$expectedVacancyLevelMark' => '△',
            ],
            '空き十分' => [
                'reservationCount' => 1,
                'capacity' => 10,
                '$expectedVacancyLevelMark' => '◎',
            ],
        ];
        
    }
}
