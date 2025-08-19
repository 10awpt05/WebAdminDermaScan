<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;


class DailyTipsController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function adminView()
    {
        $tips = $this->firebase->getDailyTips();
        return view('daily.index', ['tips' => $tips]);
    }

    public function addTip(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'image' => 'required|image'
        ]);

        $imageBase64 = base64_encode(file_get_contents($request->file('image')));

        $data = [
            'text' => $request->input('text'),
            'image_base64' => $imageBase64,
        ];

        $this->firebase->pushTip($data);

        return redirect()->route('admin.daily_tips')->with('success', 'Tip added successfully.');
    }

    public function editTip(Request $request, $key)
    {
        $data = ['text' => $request->input('text')];

        if ($request->hasFile('image')) {
            $data['image_base64'] = base64_encode(file_get_contents($request->file('image')));
        }

        $this->firebase->updateFullTip($key, $data);

        return redirect()->route('admin.daily_tips')->with('success', 'Tip updated successfully.');
    }

    public function deleteTip($key)
    {
        $this->firebase->deleteTip($key);

        return redirect()->route('admin.daily_tips')->with('success', 'Tip deleted successfully.');
    }
}
