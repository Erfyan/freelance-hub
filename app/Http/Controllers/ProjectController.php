<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('client');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(12);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category'        => 'required|in:client,personal',
            'client_id'       => 'nullable|required_if:category,client|exists:clients,id',
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:joki,aplikasi',
            'status'          => 'nullable|in:todo,in_progress,on_hold,done,cancelled',
            'deadline'        => 'nullable|date',
            'estimated_hours' => 'nullable|integer|min:0',
            'budget'          => 'nullable|numeric|min:0',
        ]);

        if ($data['category'] === 'personal') {
            $data['client_id'] = null;
        }

        Project::create($data);
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'transactions', 'files', 'timeLogs']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = Client::orderBy('name')->get();
        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'category'        => 'in:client,personal',
            'client_id'       => 'nullable|required_if:category,client|exists:clients,id',
            'title'           => 'string|max:255',
            'type'            => 'in:joki,aplikasi',
            'status'          => 'in:todo,in_progress,on_hold,done,cancelled',
            'deadline'        => 'nullable|date',
            'estimated_hours' => 'nullable|integer|min:0',
            'budget'          => 'nullable|numeric|min:0',
        ]);

        if (($data['category'] ?? $project->category) === 'personal') {
            $data['client_id'] = null;
        }

        $project->update($data);
        return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus!');
    }
}
