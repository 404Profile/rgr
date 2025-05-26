<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
            'path' => 'required|string',
        ]);

        $file = $request->file('file');
        $path = $request->path;

        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($path, $filename, 'public');

        return response()->json([
            'path' => $filePath,
            'url' => Storage::url($filePath),
        ]);
    }

    public function storeEditor(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,svg', // 10MB
        ]);

        $file = $request->file('file');

        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('editor', $filename, 'public');

        return response()->json([
            'location' => Storage::url($filePath),
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->path;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
