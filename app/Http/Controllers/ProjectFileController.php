<?php

namespace App\Http\Controllers;

use App\Models\ProjectFile;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:link,upload',
            'file' => 'required_if:type,upload|file|max:10240', // 10MB limit
            'path' => 'required_if:type,link|url',
        ]);

        if ($data['type'] === 'upload') {
            $uploadedFile = $request->file('file');
            $data['path'] = $uploadedFile->store('project_files', 'public');
            $data['mime_type'] = $uploadedFile->getClientMimeType();
            $data['size_bytes'] = $uploadedFile->getSize();
        } else {
            $data['path'] = $request->input('path');
            $data['mime_type'] = null;
            $data['size_bytes'] = null;
        }

        $data['project_id'] = $project->id;
        ProjectFile::create($data);

        return redirect()->route('projects.show', $project)->with('success', 'File/Aset berhasil ditambahkan!');
    }

    public function destroy(ProjectFile $file)
    {
        $project = $file->project;
        if ($file->type === 'upload') {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();
        return redirect()->route('projects.show', $project)->with('success', 'File/Aset berhasil dihapus!');
    }
}