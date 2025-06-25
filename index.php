<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Rapot Santri</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            line-height: 1.6; 
            background-color: #f5f5f5;
        }
        .form-container { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 30px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 { 
            text-align: center; 
            color: #2c3e50; 
            margin-bottom: 30px;
        }
        .form-group { 
            margin-bottom: 20px;
        }
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold;
            color: #34495e;
        }
        input[type="text"], 
        input[type="number"], 
        input[type="date"], 
        select {
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box;
            font-size: 16px;
        }
        .row { 
            display: flex; 
            gap: 15px;
        }
        .row .form-group { 
            flex: 1;
        }
        .btn-submit {
            background-color: #3498db; 
            color: white; 
            padding: 12px 20px; 
            border: none; 
            border-radius: 4px;
            cursor: pointer; 
            font-size: 16px; 
            display: block; 
            margin: 30px auto 0;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Generator Rapot Santri</h1>
        <form action="generate_pdf.php" method="post">
            
            <!-- Data Umum -->
            <div class="row">
                <div class="form-group">
                    <label for="tanggal">Tanggal Rapotan</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label for="tahun_ajaran_awal">Tahun Ajaran</label>
                    <input type="number" id="tahun_ajaran_awal" name="tahun_ajaran_awal" min="2000" max="2100" required>
                </div>
                <div class="form-group">
                    <label for="tahun_ajaran_akhir">s/d</label>
                    <input type="number" id="tahun_ajaran_akhir" name="tahun_ajaran_akhir" min="2000" max="2100" required>
                </div>
            </div>
            
            <!-- Data Santri -->
            <h3 class="section-title">Data Santri</h3>
            
            <div class="form-group">
                <label for="nama_santri">Nama Santri</label>
                <input type="text" id="nama_santri" name="nama_santri" required>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label for="nomor_induk">Nomor Induk</label>
                    <input type="text" id="nomor_induk" name="nomor_induk" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="wali_santri">Wali Kelas</label>
                <select id="wali_santri" name="wali_santri" required>
                    <option value="Dadang Prakoso">Dadang Prakoso</option>
                    <option value="Nadiyatul Khoiriyah">Nadiyatul Khoiriyah</option>
                    <option value="M. Rachmadsyah">M. Rachmadsyah</option>
                    <option value="Indah Purwati">Indah Purwati</option>
                </select>
            </div>
            
            <!-- Nilai Pelajaran -->
            <h3 class="section-title">Nilai Pelajaran</h3>
            
            <div class="form-group">
                <label for="tartil">Tartil (Nilai 0-100)</label>
                <input type="number" id="tartil" name="tartil" min="0" max="100" required>
            </div>
            
            <div class="form-group">
                <label for="doa_harian">Hafalan Doa Harian (Nilai 0-100)</label>
                <input type="number" id="doa_harian" name="doa_harian" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="surah_pendek">Hafalan Surah Pendek (Nilai 0-100)</label>
                <input type="number" id="surah_pendek" name="surah_pendek" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="ayat_pilihan">Hafalan Ayat Pilihan (Nilai 0-100)</label>
                <input type="number" id="ayat_pilihan" name="ayat_pilihan" min="0" max="100" required>
            </div>
            
            <div class="form-group">
                <label for="sholat">Praktek Sholat (Nilai 0-100)</label>
                <input type="number" id="sholat" name="sholat" min="0" max="100" required>
            </div>
            
            <button type="submit" class="btn-submit">Generate Rapot PDF</button>
        </form>
    </div>
</body>
</html>