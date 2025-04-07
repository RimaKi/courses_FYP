<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;


class ActivityLogController extends Controller
{
    public function index()
    {
        $data = Activity::with(['subject', 'causer'])->get();
        return self::success($data);
    }
}
