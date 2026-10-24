<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara 31 - Manipulasi Gambar</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'VT323', monospace; letter-spacing: 1px; }
        body { margin: 0; min-height: 100vh; display: flex; justify-content: center; align-items: center; background: linear-gradient(135deg, #10b981, #3b82f6, #6366f1); background-size: 200% 200%; animation: gradientBG 10s ease infinite; padding: 20px; color: #fff; }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .glass-container { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 4px solid rgba(255, 255, 255, 0.4); box-shadow: 10px 10px 0px rgba(0, 0, 0, 0.3); padding: 35px 40px; width: 100%; max-width: 500px; text-align: center; }
        h2 { text-transform: uppercase; text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.5); font-size: 2.8rem; margin-top: 0; margin-bottom: 25px; border-bottom: 4px dashed rgba(255, 255, 255, 0.5); padding-bottom: 10px; }
        .alert-success { background: rgba(0, 255, 0, 0.2); border: 3px solid #00ff00; padding: 10px; margin-bottom: 20px; font-size: 1.5rem; }
        .alert-error { background: rgba(255, 0, 0, 0.2); border: 3px solid #ff0000; padding: 10px; margin-bottom: 20px; font-size: 1.5rem; }
        .result-preview { margin-bottom: 20px; }
        .result-preview img { max-width: 100%; max-height: 250px; border: 3px solid #00ffcc; box-shadow: 6px 6px 0px rgba(0, 0, 0, 0.4); }
        input[type="file"], select { width: 100%; padding: 15px; background: rgba(0, 0, 0, 0.2); border: 2px dashed rgba(255, 255, 255, 0.6); color: #fff; font-size: 1.4rem; cursor: pointer; margin-bottom: 25px; outline: none; }
        select { border-style: solid; }
        select option { color: #000; }
        button { width: 100%; padding: 15px; background: rgba(0, 255, 204, 0.2); backdrop-filter: blur(5px); border: 4px solid #00ffcc; color: #fff; font-size: 1.8rem; font-weight: bold; cursor: pointer; text-transform: uppercase; box-shadow: 6px 6px 0px rgba(0, 0, 0, 0.4); }
        button:hover { background: #00ffcc; color: #000; text-shadow: none; }
    </style>
</head>
<body>
    <div class="glass-container">
        <h2>Acara 31: Manipulasi</h2>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if(session('image'))
            <div class="result-preview">
                <div style="font-size: 1.4rem; margin-bottom: 8px;">Hasil Gambar:</div>
                <img src="{{ session('image') }}" alt="Hasil Manipulasi">
            </div>
        @endif

        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="file" name="photo" required accept="image/*">
            
            <div style="text-align: left; margin-bottom: 5px; font-size: 1.2rem;">Pilih Jenis Manipulasi:</div>
            <select name="action">
                <option value="resize">1. Resize Gambar (300x300)</option>
                <option value="crop">2. Crop Gambar (200x200)</option>
                <option value="rotate">3. Rotate Gambar (45 Derajat)</option>
                <option value="watermark">4. Tambahkan Watermark</option>
                <option value="format">5. Ubah Format ke PNG</option>
                <option value="browser">6. Tampilkan Langsung di Browser</option>
            </select>

            <button type="submit">Eksekusi Fitur</button>
        </form>
    </div>
</body>
</html>

</html>