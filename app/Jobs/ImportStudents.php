<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Faculty;
use App\Models\Direction;
use App\Traits\Integrations\HemisTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 900;
    protected string $baseUrl;
    protected int $tuitId;
    protected string $endOfUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->tuitId = 1;
        $this->endOfUrl = '/v1/data/student-list';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = $this->baseUrl.$this->endOfUrl.'?limit=200';
        $res = Http::withToken(config('hemis.key'))
            ->get($url);

        $pageCount = $this->getPageCount($res->json());

        for ($i=40; $i <= $pageCount; $i++) {
            $url = $this->baseUrl.$this->endOfUrl.'?limit=200&_education_type=11&page='.$i;
            $res = Http::withToken(config('hemis.key'))
                ->get($url);

            foreach ($res->json()['data']['items'] as $item) {
                if ($item['department']['code'] == '380-111') continue;
                if (!Direction::where('code', $item['specialty']['code'])->first() || !Faculty::where('code', $item['department']['code'])->first()) dd($item);
                Student::updateOrCreate([
                    'passport_number' => $item['student_id_number'],
                ],[
                    'name' => $item['first_name'],
                    'surname' => $item['second_name'],
                    'father_name' => $item['third_name'],

                    'passport_number' => $item['student_id_number'],
                    'student_passport_number' => $item['student_id_number'],

                    'university_id' => $this->tuitId,
                    'faculty_id' => Faculty::where('code', $item['department']['code'])->first()->id,
                    'direction_id' => Direction::where('code', $item['specialty']['code'])->first()->id,

                    'password' => Hash::make($item['student_id_number']),
                ]);   
            }
        }
    }

    public function getPageCount($data): int
    {
        return $data['data']['pagination']['pageCount'];
    }
}
