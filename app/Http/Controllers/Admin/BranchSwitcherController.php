<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchSwitcherController extends Controller
{
    /**
     * Switch the active branch for a Super Admin.
     */
    public function switch(Request $request)
    {
        $request->validate([
            'branch_id' => 'required',
        ]);

        if (auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            session(['selected_branch_id' => $request->branch_id]);
        }

        return back()->with('success', 'Branch switched successfully.');
    }
}
