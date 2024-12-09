<?php

namespace App\Http\Controllers;

use App\Models\CategorieType; 
use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    // Menampilkan semua tips (index)
    public function index()
    {
        $tips = Tip::all();
        $categorieTypes = CategorieType::with('categories')->get();  // Corrected name
        return view('tips.index', compact('tips', 'categorieTypes'));
    }

    // Menampilkan halaman detail tips (show)
    public function show($id)
    {
        $tip = Tip::findOrFail($id);  // Jika data tidak ditemukan, akan muncul 404 error
        $categorieTypes = CategorieType::with('categories')->get();
        return view('tips.show', compact('tip', 'categorieTypes'));
    }

    // Menampilkan form untuk membuat tips baru (create)
    public function create()
    {   
        $categorieTypes = CategorieType::with('categories')->get();
        return view('tips.create', compact('categorieTypes'));
    }

    // Menampilkan form untuk mengedit tips yang sudah ada
    public function edit($id)
{
    $tip = Tip::findOrFail($id);  // Ambil data berdasarkan ID
    return view('tips.edit', compact('tip'));  // Tampilkan halaman edit
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'steps' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Gambar bersifat opsional
    ]);

    $tip = Tip::findOrFail($id);
    $tip->title = $request->input('title');
    $tip->description = $request->input('description');
    $tip->steps = $request->input('steps');
    
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imageName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $imageName);
        $tip->image_url = '/images/' . $imageName; 
    }

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

     public function destroy($id)
    {
        // Cari tips berdasarkan ID
        $tip = Tip::findOrFail($id);

        // Hapus data
        $tip->delete();

        // Redirect kembali ke halaman daftar tips dengan pesan sukses
        return redirect()->route('tips.index')->with('success', 'Tips berhasil dihapus.');
    }
}