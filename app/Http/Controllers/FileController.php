<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function store(Request $request){

        $request->validate([
            'fileable_type' => 'required|string',
            'fileable_id' => 'required|integer',
            'name' => 'required|string',
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        $model = $request->fileable_type::findOrFail($request->fileable_id);

        $model->files()->create([
            'name' => $request->name,
            'description' => $request->description,
            'document_type' => $request->document_type,
            'path' => $path,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully');
    }

    

}
