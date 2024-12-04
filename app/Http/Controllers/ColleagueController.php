<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colleague;

class ColleagueController extends Controller
{
    // public function index()
    // {
    //     return view('colleagues.index');
    // }
    
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Colleague::query())
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm" onclick="editColleague(' . $row->id . ')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteColleague(' . $row->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('colleagues.index');
    }

    public function store(Request $request)
    {
        // \Log::info('Request data:', $request->all());
        \Log::info('Request data:', $request->input('colleagues'));
        // Validate the colleagues array
        $request->validate([
            'colleagues' => 'required|array',
            'colleagues.*.name' => 'required',
            'colleagues.*.email' => 'required|email',
            'colleagues.*.phone' => 'required',
            'colleagues.*.position' => 'required',
            'colleagues.*.pdf_file' => 'nullable|mimes:pdf|max:1024',
        ]);

        // $colleagues = $request->input('colleagues');
        // \Log::info('Request data:', $request->input('colleagues'));
        
        // Loop through each colleague and store their data
        foreach ($colleagues as $colleagueData) {
            $filePath = null;
            // if (isset($colleagueData['pdf_file'])) {
            //     $filePath = $colleagueData['pdf_file']->store('pdfs');
            // }

            // Create a new colleague entry in the database
            Colleague::create([
                'name' => $colleagueData['name'],
                'email' => $colleagueData['email'],
                'phone' => $colleagueData['phone'],
                'position' => $colleagueData['position'],
                'pdf_file_path' => $filePath,
            ]);
        }

        return view('colleagues.index');
    }
    

    // public function edit(Colleague $colleague)
    // {
    //     return view('colleagues.edit', compact('colleague'));
    // }

    // public function update(Request $request, Colleague $colleague)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'phone' => 'required',
    //         'position' => 'required',
    //         'pdf_file' => 'nullable|mimes:pdf|max:1024',
    //     ]);

    //     $filePath = $colleague->pdf_file_path;
    //     if ($request->hasFile('pdf_file')) {
    //         $filePath = $request->file('pdf_file')->store('pdfs');
    //     }

    //     $colleague->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'position' => $request->position,
    //         'pdf_file_path' => $filePath,
    //     ]);

    //     return redirect()->route('colleagues.index')->with('message', 'Colleague updated successfully!');
    // }
    

    public function destroy(Colleague $colleague)
    {
        $colleague->delete();
        return response()->json(['message' => 'Colleague deleted successfully!']);
    }

}
