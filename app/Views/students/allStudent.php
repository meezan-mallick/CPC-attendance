
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
        
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	
<?php include APPPATH . 'Views/navbar.php';?>


    <div class="main-wrapper">
         <?php include APPPATH . 'Views/header.php';?>

        
        <div class="card">
            <div class="header">
              <div class="heading">
                <h2>Sudents</h2>
              </div>
              <div class="add-btn">
                <a href="/add-student" class="add-p">
                  Add New
                </a>
              </div>
            </div>
	     
            <div class="table-wrapper data-table">
              <table>
                <thead>
            
                  <tr>
                    <th>Enrollment No</th>
                    <th>Name</th>
                    <th>Course</th>
                   
                    <th>Semester</th>
                    <th>Batch</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                	
                <?php
                            foreach ($student as $row) {
                                echo "<tr>";
                                echo "<td>".$row['enroll_no']."</td>";
                                echo "<td>".$row['stud_name']."</td>";
                                echo "<td>".$row['program_name']."</td>";
                                echo "<td>".$row['semester']."</td>";
                                echo "<td>".$row['batch']."</td>";
                            
                                ?>

                                <td><a href="<?= base_url('update-student/'.$row['id'])?>" class="material-icons">edit</a>
                                <a href="<?= base_url('delete-student/'.$row['id'])?>" class="material-icons">delete</a></td>

                            </tr>

                    <?php
                    }
                  ?>

			
                      
                </tbody>
              </table>
            </div>
           
          </div>

    </div>
	     
    

</body>
</html>