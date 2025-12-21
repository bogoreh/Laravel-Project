<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $openIssues = Issue::whereIn('status', ['open', 'in_progress'])->count();
        $resolvedIssues = Issue::whereIn('status', ['resolved', 'closed'])->count();
        $myAssignedIssues = Issue::where('assigned_to', Auth::id())->count();
        
        $recentIssues = Issue::with(['project', 'assignee', 'reporter'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $activeProjects = Project::withCount(['issues', 'openIssues'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'totalProjects',
            'openIssues',
            'resolvedIssues',
            'myAssignedIssues',
            'recentIssues',
            'activeProjects'
        ));
    }
}