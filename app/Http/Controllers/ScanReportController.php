<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;

class ScanReportController extends Controller
{
    protected $database;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
    }

    public function index()
    {
        $scanReports = $this->database->getReference('scanReports')->getValue();
        return view('admin.scan-reports', compact('scanReports'));
    }
}
