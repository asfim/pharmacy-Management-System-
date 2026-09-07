<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['customer', 'doctor'])->latest()->paginate(20);
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['customer', 'doctor']);
        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription deleted successfully.');
    }
}
