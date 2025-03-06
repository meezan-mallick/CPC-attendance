
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


        <div class="container add-form">
            <form action="/studentstore" method="POST">
              <div class="header">
                <div>
                  <h2>Add Student</h2>
                </div>
                <div class="submit-btn">
                  <button class="submit" type="submit">
                    Add
                  </button>
                </div>
              </div>
      
              <!-- {/* PERSONAL DETAILS */} -->
              <fieldset>
                <legend>Student Details</legend>
                <div class="form-container">
                  <div class="row">
                    <div>
                        <label For="enroll_no">Enrollment Number</label>
        
                        <input
                          class="form-inputs"
                          type="text"
                          name="enroll_no"
                          id="enroll_no"
                          placeholder="Enter Enrollment No"
                          
                        />
                    </div>

                    <div>
                      <label For="stud_name">Student Name</label>
      
                      <input
                        class="form-inputs"
                        type="text"
                        name="stud_name"
                        id="stud_name"
                        placeholder="Enter Name"
                     
                      />
                    </div>
                   
                
                    <div>
                          <label For="program_id">Program</label>
                          
                          <select name="program_id" id="" class="dropdown" style="width: fit-content;">
                          <?php
                              foreach ($program as $row) {
                              echo "<option value=".$row['id'].">".$row['program_name']."</option>";
                              
                              } ?>
                          </select>
                      </div>

                      <div>
                           <label For="semester_id">Semester</label>
        
                            <select name="semester_id" id="" class="dropdown">
                            <?php
                                foreach ($semester as $row) {
                                echo "<option value=".$row['id'].">".$row['semester']."</option>";
                                
                                } ?>
                            </select>
                          
                       
                      </div>
                     
                   
                </div>

                <div class="row">

                        <div>
                            <label For="batch">Batch</label>
                              
                              <select name="batch" id="" class="dropdown" >
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                              </select>
                        </div>
                </div>
                <?php
                        if(isset($validation)){?>
                         <div class="row" style="color: crimson;">
                            <?=$validation->listErrors();?>
                        </div><?php
                        }
                    ?>
                
              
              </fieldset>
              
            </form>
            
          </div>
       

    </div>
	     
    

</body>
</html>