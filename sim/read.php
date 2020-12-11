<?php
// Periksa keberadaan parameter id sebelum diproses lebih lanjut
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // siapkan statement SELECT
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Ikat variabel ke pernyataan yang disiapkan sebagai parameter
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Setel parameter
        $param_id = trim($_GET["id"]);
        
        // Mencoba mengeksekusi pernyataan yang telah disiapkan
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Ambil baris hasil sebagai array asosiatif. Karena kumpulan hasil hanya berisi satu baris, kita tidak perlu menggunakan while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // menarik record perorangan
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL tidak berisi parameter id yang valid. Alihkan ke error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Terjadi kesalahan. Silakan coba lagi.";
        }
    }
     
    // mengakhiri statemen
    mysqli_stmt_close($stmt);
    
    // mengakhiri config
    mysqli_close($link);
} else{
    // URL tidak berisi parameter ID. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lihat Data Pekerja</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Lihat Data Pekerja</h1>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Gaji</label>
                        <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Kembali</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>