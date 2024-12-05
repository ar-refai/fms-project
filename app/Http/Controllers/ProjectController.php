<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        try {
            $projects = Project::with('client')->get();
            dd($projects);
            return view('clients.index', compact('projects'));
        } catch (\Exception $e) {
            Log::error('Error fetching projects: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to fetch projects. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        try {
            $clients = Client::all();
            return view('clients.create', compact('clients'));
        } catch (\Exception $e) {
            Log::error('Error fetching clients for project creation: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to load the project creation form.');
        }
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
{
    try {
        // Validate incoming request data (excluding project_id, since we'll generate it)
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'contracted_revenue' => 'nullable|numeric|min:0',
            'status' => 'required|in:Pending,In Progress,Completed',
            'project_validation_date' => 'required|date',
        ]);

        // Fetch the client's code
        $client = Client::findOrFail($validatedData['client_id']);
        $clientCode = $client->client_code;

        // Find the latest project for this client
        $lastProject = Project::where('client_id', $validatedData['client_id'])
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastProject && preg_match('/_P(\d+)$/', $lastProject->project_id, $matches)) {
            $lastProjectNumber = (int) $matches[1];
        } else {
            $lastProjectNumber = 0;
        }

        // Generate the next project code
        $nextProjectNumber = str_pad($lastProjectNumber + 1, 3, '0', STR_PAD_LEFT);
        $projectId = "{$clientCode}_P{$nextProjectNumber}";

        // Add project_id to validated data
        $validatedData['project_id'] = $projectId;

        // Create a new project
        Project::create($validatedData);

        return redirect()->route('clients.index')->with('success', 'Project created successfully.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Error creating project: ' . $e->getMessage());
        return redirect()->route('clients.index')->with('error', 'Failed to create project. Please try again later.');
    }
}


    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        try {
            return view('clients.show', compact('project'));
        } catch (\Exception $e) {
            Log::error('Error displaying project: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to load project details.');
        }
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        try {
            $project = Project::findOrFail($id);
            $clients = Client::all();
            return view('clients.edit', compact('project', 'clients'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('clients.index')->with('error', 'Project not found.');
        } catch (\Exception $e) {
            Log::error('Error loading project edit form: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to load the project edit form.');
        }
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $validatedData = $request->validate([
                'project_name' => 'required|string|max:255',
                'client_id' => 'required|exists:clients,id',
                'project_validation_date' => 'required|date',
                'contracted_revenue' => 'required|numeric|min:0',
                'status' => 'required|in:Pending,In Progress,Completed',
            ],[],[],'editProject');

            $project->update($validatedData);

            return redirect()->route('clients.index')->with('success', 'Project updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('clients.index')->with('error', 'Project not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to update project. Please try again later.');
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return redirect()->route('clients.index')->with('success', 'Project deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('clients.index')->with('error', 'Project not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Failed to delete project. Please try again later.');
        }
    }
}
