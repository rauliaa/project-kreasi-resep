<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    // Menampilkan semua tips (index)
    public function index()
    {
        $tips = Tip::all();
        return view('tips.index', compact('tips'));
    }

    // Menampilkan halaman detail tips (show)
    public function show($id)
    {
        $tip = Tip::findOrFail($id);  // Jika data tidak ditemukan, akan muncul 404 error
        return view('tips.show', compact('tip'));
    }

    // Menampilkan form untuk membuat tips baru (create)
    public function create()
    {
        return view('tips.create');
    }

    // Menampilkan form untuk mengedit tips yang sudah ada
    public function edit($id)
    {
        $tip = Tip::find($id);
        return view('tips.edit', compact('tip'));
    }

    // Menyimpan perubahan yang diupdate ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'steps' => 'required|string',
            'image_url' => 'required|url',
        ]);

        $tip = Tip::findOrFail($id);
        $tip->title = $request->input('title');
        $tip->description = $request->input('description');
        $tip->steps = $request->input('steps');
        $tip->image_url = $request->input('image_url');
        $tip->save();

        return redirect()->route('tips.index')->with('success', 'Tips berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'steps' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName); // Save to public/images directory

            // Create the tip
            Tip::create([
                'title' => $request->title,
                'description' => $request->description,
                'steps' => $request->steps,
                'image_url' => '/images/' . $imageName, // Store the path to the image
            ]);
        }

        return redirect()->route('tips.index')->with('success', 'Tips berhasil ditambahkan.');
    }
}
