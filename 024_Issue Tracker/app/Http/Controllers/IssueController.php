<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with(['project', 'assignee', 'reporter'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('issues.index', compact('issues'));
    }

    public function create()
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        
        return view('issues.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'type' => 'required|in:bug,feature,task,improvement',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date'
        ]);

        Issue::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'type' => $request->type,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'reported_by' => Auth::id(),
            'due_date' => $request->due_date,
            'status' => 'open'
        ]);

        return redirect()->route('issues.index')
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load(['project', 'assignee', 'reporter', 'comments.user']);
        
        return view('issues.show', compact('issue'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        
        return view('issues.edit', compact('issue', 'projects', 'users'));
    }

    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'type' => 'required|in:bug,feature,task,improvement',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date'
        ]);

        $issue->update($request->all());

        return redirect()->route('issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }
}