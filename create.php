<?php
// memanggil config.php
require_once "config.php";
 
// mendefinisikan variabel dan inisialisasi dengan nilai kosong
$name = $address = $salary = $department = $position = $tunjangan = "";
$name_err = $address_err = $salary_err = $department_err =$position_err = $tunjangan_err = "";
 
// memproses form ketika ditekan tombol submit
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // validasi field nama
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Mohon masukkan sebuah nama.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Mohon masukkan nama yang valid.";
    } else{
        $name = $input_name;
    }
    
    // validasi field alamat
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Mohon masukkan sebuah alamat.";     
    } else{
        $address = $input_address;
    }
    
    // validasi field gaji
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Mohon masukkan jumlah gaji.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Mohon masukkan bilangan bulat positif saja.";
    } else{
        $salary = $input_salary;
    }
    $input_department = trim($_POST["department"]);
    if(empty($input_department)){
        $department_err = "Please enter the department amount.";   
        } else{
            $department = $input_department;    }

    $input_position = trim($_POST["position"]);
    if(empty($input_position)){
        $position_err = "Please enter the position amount.";     
     
    } else{
        $position = $input_position;
    }
   
    $input_tunjangan = trim($_POST["tunjangan"]);
    if(empty($input_tunjangan)){
        $tunjangan_err = "Please enter the tunjangan amount.";     
    } else{
        $tunjangan = $input_tunjangan;
    }
    
    // Cek input error sebelum memasukkan ke database

        if(empty($name_err) && empty($address_err) && empty($salary_err) &&  empty($department_err) &&  empty($position_err) &&  empty($tunjangan_err)){
            // Prepare an update statement
            $sql = "INSERT INTO employees (name, address, salary, department, position, tunjangan) VALUES (?, ?, ?, ?, ?, ?)";
                      
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_address, $param_salary, $param_department, $param_position, $param_tunjangan);
                
                // Set parameters
                $param_name = $name;
                $param_address = $address;
                $param_salary = $salary;
                $param_department = $department;
                $param_position = $position;
                $param_tunjangan =$tunjangan;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records updated successfully. Redirect to landing page
                    header("location: index.php");
                    exit();
                } else{
                    echo "Something went wrong. Please try again later.";
                
            }
             
            // Close statement
            mysqli_stmt_close($stmt);
        }
         
        // Menutup statemen
        mysqli_stmt_close($stmt);
    }
    
    // menutup config ke database
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membuat Data Baru</title>
    <!-- link untuk memasukkan bootstrap -->
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
                        <h2>Tambah Data</h2>
                    </div>
                    <p>Mohon isi form ini dan submit untuk menambah data employee ke database.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
                            <label>Department</label>
                            <input type="text" name="department" class="form-control" value="<?php echo $department; ?>">
                            <span class="help-block"><?php echo $department_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                            <label>Position</label>
                            <input type="text" name="position" class="form-control" value="<?php echo $position; ?>">
                            <span class="help-block"><?php echo $position_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tunjangan_err)) ? 'has-error' : ''; ?>">
                            <label>Tunjangan</label>
                            <input type="text" name="tunjangan" class="form-control" value="<?php echo $tunjangan; ?>">
                            <span class="help-block"><?php echo $tunjangan_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>