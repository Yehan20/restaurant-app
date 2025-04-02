<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ConcessionController extends Controller
{


    public function __construct(protected ConcessionRepositoryInterface $concessionRepository)
    {
     
    }

    public function index()
    {
        $concessions = $this->concessionRepository->getConcussionsPaginated();
        return view('concessions.index', compact('concessions'));
    }

    public function create()
    {
        return view('concessions.create');
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required|string|unique:concessions,name|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('concessions', 'public');

        $this->concessionRepository->create([
            'name' =>  $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'price' => $validated['price'],
        ]);

        return redirect()->route('concessions.index')->with('success', 'Concession added successfully.');
    }

    public function edit($id)
    {
        $concession = $this->concessionRepository->find($id);
        return view('concessions.edit', compact('concession'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255',Rule::unique('concessions','name')->ignore($id)],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $data = [
            'name' => $validated["name"],
            'description' => $validated["description"],
            'price' => $validated["price"],
        ];

        // Handle optional image update
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('concessions', 'public');
            $data['image'] = $imagePath;
        }

        $this->concessionRepository->update($id, $data);

        return redirect()->route('concessions.index')->with('success', 'Concession updated successfully.');
    }

    public function destroy(Concession $concession)
    {
        $this->concessionRepository->delete($concession);
        return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully.');
    }
}
