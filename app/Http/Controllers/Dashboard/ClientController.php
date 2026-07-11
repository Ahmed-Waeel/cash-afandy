<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;
use Redot\Traits\CanUploadFile;

class ClientController extends Controller
{
    use CanUploadFile;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create', [
            'categories' => Category::query(),
            'countries' => Country::query(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:clients,slug',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'url' => 'required|url',
            'logo' => 'required|image',
            'active' => 'nullable|boolean',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
        ]);

        $validated['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->uploadFile($request->file('logo'), 'clients');
        }

        $client = Client::create($validated);
        $client->categories()->attach($validated['categories']);
        $client->countries()->attach($validated['countries']);

        return $this->created(__('Client'), 'dashboard.clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', [
            'client' => $client,
            'categories' => Category::query(),
            'countries' => Country::query(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:clients,slug,' . $client->id,
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'url' => 'required|url',
            'logo' => 'nullable|image',
            'active' => 'nullable|boolean',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
        ]);

        $validated['active'] = $request->boolean('active');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->uploadFile($request->file('logo'), 'clients');
        }

        $client->update($validated);
        $client->categories()->sync($validated['categories']);
        $client->countries()->sync($validated['countries']);

        return $this->updated(__('Client'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->deleted(__('Client'));
    }
}
