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

    public function __construct()
    {
        $this->authorizeResource(Schedule::class, 'schedule');
    }

    /**
     * 指定された日付から７日分のスケジュールを表示
     */
    public function index(Request $request): Response
    {
        $from = $request->query('from');

        if(!$this->isValidDate($from)) {
            $from = now()->format('Y-m-d');
        }

        $to = Carbon::parse($from)->copy()->addDay(7)->format('Y-m-d');

        $schedules = Auth::user()->schedules()->whereBetween('deadline', [$from, $to])
            ->orderBy('deadline')
            ->get()
            ->groupBy(function ($row) {
                return Carbon::parse($row->deadline)->format('Y-m-d');
            });

        $schedules2 = array();

        $date = Carbon::parse($from)->copy()->format('Y-m-d');
        for($i=0; $i<7; $i++) {
            if(!isset($schedules[$date])) {
                $schedules2[$date] = array();
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
        return Inertia::render('Schedule/Create', [
            'date' => $request->query('date')
        ]);
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

        return Redirect::route('schedule.index')
            ->with('flash', [
                'status' => 'success',
                'message' => '予定を追加しました。'
            ]);
    }

    /**
     * 予定編集画面を表示
     */
    public function edit(Schedule $schedule): Response
    {
        return Inertia::render('Schedule/Edit', [
            'schedule' => $schedule
        ]);
    }

    /**
     * 予定を更新
     */
    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $schedule->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'status' => $request->input('status'),
        ]);

        return Redirect::route('schedule.index')
            ->with('flash', [
                'status' => 'success',
                'message' => '予定を更新しました。'
            ]);
    }

    /**
     * 指定された予定を削除
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();
        return Redirect::route('schedule.index')
            ->with('flash', [
                'status' => 'error',
                'message' => '予定を削除しました。'
            ]);
    }

    // 日付が正しいか確認
    private function isValidDate($date) {
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
