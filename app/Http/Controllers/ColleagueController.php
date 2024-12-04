<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColleagueController extends Controller
{
    public function index()
    {
        return view('colleagues.index');
    }
    // public function index()
    // {
    //     if (request()->ajax()) {
    //         return datatables()->of(Colleague::query())
    //             ->addColumn('actions', function ($row) {
    //                 return '
    //                     <button onclick="editColleague(' . $row->id . ')">Edit</button>
    //                     <button onclick="deleteColleague(' . $row->id . ')">Delete</button>
    //                 ';
    //             })
    //             ->rawColumns(['actions'])
    //             ->make(true);
    //     }

    //     return view('colleagues.index');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'position' => 'required',
            'pdf_file' => 'nullable|mimes:pdf|max:1024',
        ]);

        $filePath = null;
        if ($request->hasFile('pdf_file')) {
            $filePath = $request->file('pdf_file')->store('pdfs');
        }

        Colleague::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'pdf_file_path' => $filePath,
        ]);

        return response()->json(['message' => 'Colleague added successfully!']);
    }

    public function edit(Colleague $colleague)
    {
        return view('colleagues.edit', compact('colleague'));
    }

    public function update(Request $request, Colleague $colleague)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'position' => 'required',
            'pdf_file' => 'nullable|mimes:pdf|max:1024',
        ]);

        $filePath = $colleague->pdf_file_path;
        if ($request->hasFile('pdf_file')) {
            $filePath = $request->file('pdf_file')->store('pdfs');
        }

        $colleague->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'pdf_file_path' => $filePath,
        ]);

        return redirect()->route('colleagues.index')->with('message', 'Colleague updated successfully!');
    }

    public function destroy(Colleague $colleague)
    {
        $colleague->delete();
        return response()->json(['message' => 'Colleague deleted successfully!']);
    }

}
