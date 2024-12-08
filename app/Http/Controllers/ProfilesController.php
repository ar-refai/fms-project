<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Display a listing of client profiles.
     */
    public function index()
    {
        try {
            $clients = Client::all();
            // dd($clients);
            return view('profiles', compact('clients'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load profiles. Please try again.');
        }
    }

    /**
     * Show the profile of a specific client.
     */
    public function show($id)
    {
        try {
            $client = Client::with(['projects', 'expenses'])->findOrFail($id);
            // dd($client);
            return view('profiles.show', compact('client'));
        } catch (\Exception $e) {
            return redirect()->route('profiles.index')->with('error', 'Failed to load client profile.');
        }
    }
}
