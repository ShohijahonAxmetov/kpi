<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    const UNIVERSITIES = array(
        array('id' => 1, 'title' => 'O‘ZBEKISTON RESPUBLIKASI HARBIY XAVFSIZLIK VA MUDOFAA UNIVERSITETI', 'region_id' => 1)
    );

    const FACULTIES = array(
        array('id' => 1, 'title' => 'Chegara qo‘shinlari fakulteti', 'university_id' => 1, 'code' => 'CHQF'),
        array('id' => 2, 'title' => 'Umumqo‘shin fakulteti', 'university_id' => 1, 'code' => 'UF'),
    );

    const DIRECTIONS = array(
        array('id' => 1, 'title' => 'Направления #1', 'code' => '#1', 'university_id' => 1, 'faculty_id' => 1),
        array('id' => 2, 'title' => 'Направления #2', 'code' => '#2', 'university_id' => 1, 'faculty_id' => 1),
    );

    public function run(): void
    {
        // create university
        foreach(self::UNIVERSITIES as $university) {
            if (!\App\Models\University::find($university['id'])) {
                \App\Models\University::query()
                    ->create(['id' => $university['id'], 'title' => $university['title'], 'region_id' => $university['region_id']]);
            }
        }

        // create faculties
        foreach(self::FACULTIES as $faculty) {
            if (!\App\Models\Faculty::find($faculty['id'])) {
                \App\Models\Faculty::query()
                    ->create(['id' => $faculty['id'], 'title' => $faculty['title'], 'code' => $faculty['code'], 'university_id' => $faculty['university_id']]);
            }
        }

        // create directions
        foreach(self::DIRECTIONS as $direction) {
            if (!\App\Models\Direction::find($direction['id'])) {
                \App\Models\Direction::query()
                    ->create(['id' => $direction['id'], 'title' => $direction['title'], 'code' => $direction['code'], 'university_id' => $direction['university_id'], 'faculty_id' => $direction['faculty_id']]);
            }
        }
    }
}
