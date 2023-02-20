<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    /**
     * 指定された日付から1週間分のスケジュールを表示
     */
    public function index(Request $request): Response
    {
        $from = $request->query('from');

        if(!$this->isDate($from)) {
            $from = now()->format('Y-m-d');
        }

        $to = Carbon::parse($from)->copy()->addDay(7)->format('Y-m-d');

        $schedules = Schedule::whereBetween('deadline', [$from, $to])
            ->orderBy('deadline')
            ->get()
            ->groupBy(function ($row) {
                return Carbon::parse($row->deadline)->format('Y-m-d');
            });

        $schedules2 = array();

        $date = Carbon::parse($from)->copy()->format('Y-m-d');
        for($i=0; $i<7; $i++) {
            if(!isset($schedules[$date])) {
                $schedules2[$date] = [];
            }else {
                $schedules2[$date] = $schedules[$date];
            }
            $date = Carbon::parse($date)->addDays(1)->format('Y-m-d');
        }

        return Inertia::render('Schedule/Index', [
            'schedules' => $schedules2,
            'prev' => Carbon::parse($from)->subDays(7)->format('Y-m-d'),
            'next' => Carbon::parse($from)->addDay(7)->format('Y-m-d')
        ]);
    }

    /**
     * 予定登録画面を表示
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Schedule/Create');
    }

    /**
     * 予定を保存
     */
    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        Schedule::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'status' => $request->input('status'),
        ]);

        return Redirect::route('schedule.index');
    }


    // 日付が正しいか確認
    private function isDate($date) {
        if(!preg_match('/^[1-9]{1}[0-9]{0,3}-[0-9]{1,2}-[0-9]{1,2}$/', $date)){
            return false;
        }
     
        list($y, $m, $d) = explode('-', $date);
        if(!checkdate($m, $d, $y)){
            return false;
        }

        return true;
    }
}
