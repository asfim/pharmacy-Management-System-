<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->paginate(20);
        return view('admin.attendances.index', compact('attendances'));
    }

    public function daily()
    {
        $attendances = Attendance::with('employee')->whereDate('date', today())->get();
        return view('admin.attendances.index', compact('attendances'));
    }
}
