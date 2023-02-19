<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            $from = now();
        }
        
        $from_copy = new Carbon($from);
        $to = $from_copy->addDay(6);

        $schedules = Schedule::whereBetween('deadline', [$from, $to])
            ->orderBy('deadline')
            ->get()
            ->groupBy(function ($row) {
                return Carbon::parse($row->deadline)->format('Y-m-d');
            });

        return Inertia::render('Schedule/Index', [
            'schedules' => $schedules
        ]);
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
