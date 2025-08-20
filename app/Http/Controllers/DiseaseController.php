<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class DiseaseController extends Controller
{
    protected $database;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
    }

    public function index()
    {
        $ref = $this->database->getReference('disease');
        $diseases = $ref->getValue() ?? [];
        return view('admin.disease', compact('diseases'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'cause' => 'required|string',
            'des' => 'required|string',
            'prev' => 'required|string',
            'rem' => 'required|string',
            'creditURL' => 'nullable|url',
        ]);

        $this->database->getReference('disease/' . $data['name'])->set([
            'cause' => $data['cause'],
            'des' => $data['des'],
            'prev' => $data['prev'],
            'rem' => $data['rem'],
            'creditURL' => $data['creditURL'] ?? '',
        ]);

        return redirect()->route('disease.index')->with('success', 'Disease added successfully!');
    }

    public function update(Request $request, $name)
    {
        $data = $request->validate([
            'des' => 'required|string',
            'cause' => 'required|string',
            'prev' => 'required|string',
            'rem' => 'required|string',
            'creditURL' => 'nullable|url',
        ]);

        $this->database->getReference('disease/' . $name)->update([
            'des' => $data['des'],
            'cause' => $data['cause'],
            'prev' => $data['prev'],
            'rem' => $data['rem'],
            'creditURL' => $data['creditURL'] ?? '',
        ]);

        return redirect()->route('disease.index')->with('success', 'Disease updated successfully!');
    }

    public function destroy($name)
    {
        $this->database->getReference('disease/' . $name)->remove();

        return redirect()->route('disease.index')->with('success', 'Disease deleted successfully!');
    }
}
