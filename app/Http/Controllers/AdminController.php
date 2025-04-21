<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function pendingRecruiters()
    {
        $recruiters = User::where('role', 'recruiter')
            ->where('is_approved', false)
            ->with('companyProfile')
            ->get();

        return view('admin.recruiters.pending', compact('recruiters'));
    }

    public function approveRecruiter(Request $request, User $user)
    {
        $this->authorize('approve', $user);

        $user->update(['is_approved' => true]);

        return redirect()->route('admin.recruiters.pending')->with('success', 'Recruiter approved successfully!');
    }
}