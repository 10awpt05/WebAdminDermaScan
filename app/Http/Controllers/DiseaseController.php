<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory; // ✅ You were missing this import
use Kreait\Firebase\Database;
use Illuminate\Support\Str;




class DiseaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('dermascanai-2d7a1-firebase-adminsdk-fbsvc-be9d626095.json'))
            ->withDatabaseUri('https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
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
            'creditURL' => $data['creditURL'],
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
