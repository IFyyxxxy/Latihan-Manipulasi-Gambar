<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;

class ImageController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'action' => 'required'
        ]);

        $file = $request->file('photo');
        $action = $request->action;
        $extension = 'jpg'; 
        $filename = time() . '_' . $action . '.' . $extension;

        // Inisialisasi ImageManager Intervention Image v4
        $manager = new ImageManager(new Driver());
        
        // Membaca gambar menggunakan decode() untuk v4 (menggunakan binary data agar aman di Windows)
        $image = $manager->decode($file->getContent());

        switch($action) {
            case 'resize':
                $image->resize(300, 300);
                break;
            case 'crop':
                // Memotong 200x200 dari koordinat x:0 y:0
                $image->crop(200, 200, 0, 0); 
                break;
            case 'rotate':
                $image->rotate(45);
                break;
            case 'watermark':
                // Pastikan ada file watermark.png di folder public/
                $watermarkPath = public_path('watermark.png');
                if (file_exists($watermarkPath)) {
                    $watermark = $manager->decode(file_get_contents($watermarkPath));
                    // v4 menggunakan insert()
                    $image->insert($watermark, 10, 10, 'bottom-right');
                } else {
                    return back()->with('error', 'Gagal: File watermark.png tidak ditemukan di folder public!');
                }
                break;
            case 'format':
                // Mengubah format ke PNG
                $extension = 'png';
                $filename = time() . '_format.' . $extension;
                $encoded = $image->encode(new PngEncoder());
                Storage::disk('public')->put('uploads/' . $filename, $encoded->toString());
                return back()->with('success', 'Berhasil mengubah format ke PNG!')
                             ->with('image', asset('storage/uploads/' . $filename));
                
            case 'browser':
                // Tampilkan langsung di browser (tanpa disimpan)
                $encoded = $image->encode(new JpegEncoder());
                return response($encoded->toString())->header('Content-Type', 'image/jpeg');
        }

        // Jika bukan format PNG atau Browser, simpan sebagai JPG default kualitas 75
        if ($action !== 'format' && $action !== 'browser') {
            $encoded = $image->encode(new JpegEncoder(quality: 75));
            Storage::disk('public')->put('uploads/' . $filename, $encoded->toString());
        }

        return back()->with('success', 'Berhasil melakukan eksekusi: ' . strtoupper($action) . '!')
                     ->with('image', asset('storage/uploads/' . $filename));
    }
}
