
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
        
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	
    
<?php include APPPATH . 'Views/navbar.php';?>

    <div class="main-wrapper">
       
        <?php include APPPATH . 'Views/header.php';?>


          
            
          

        <div class="card">

        <?php
             
             if(!empty($student)){

         ?>

        <form action="<?= base_url('/attendancestore/' . $prog_id . '/' . $sem_id . '/' . $sub_id . '/'. $s_topic['id'] . '/' . $batch . '/') ?>" method="Post">
            
            <div class="header" style="margin-bottom: 30px;display: flex;flex-direction: column;justify-content: start;align-items: start;">
              <div class="heading">
                <h2>Attendance</h2>
              </div>

             <div style="width:100%; display: flex;flex-direction: row;justify-content: space-between;align-items: center;">
              <div>
                <input type="date" id="date" name="date" class="form-inputs" style="width: 7vw;margin-right: 20px;" value="<?=$s_topic['date']?>">

                <select name="time" id="time" class="dropdown " style="width: fit-content;">
                  
                  <?php
                      foreach ($timeslot as $row) {
                        $t=$row['start_time']."-".$row['end_time'];
                        if($t==$s_topic['time']){
                          echo "<option selected value=".$t.">".$row['start_time']." - ".$row['end_time']."</option>";
                      
                        } 
                        else{
                          echo "<option value=".$t.">".$row['start_time']." - ".$row['end_time']."</option>";
                      
                        
                        }
                      }

                  ?>
                </select>
              </div>
              
            


              <div class="add-btn">
                <button type="button" class="submit" id="present_all" style="margin-right: 20px;background-color: #04AA6D;border:1px solid #04AA6D ;">
                  Present All
                </button>
                <button type="reset" class="submit" style="margin-right: 20px;">
                  Clear
                </button>
               <button type="submit" class="submit">
                  Submit
                </button>
              </div>
             </div>
            </div>
            <div class="table-wrapper data-table">
              <table>
                <thead>
            
                  <tr>
                    <th>Enrollment No</th>
                    <th>Name</th>
                  
                    <th>Present/Absent</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody id="table_data">
                  
              
                    <?php
                                foreach ($student as $row) {
                                    echo "<tr>";
                                    echo "<td>".$row['enroll_no']."</td>";
                                    ?>
                                    
                                    <input type="hidden" name="student_ids[]" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="att_ids[<?=$row['id']?>]" value="<?= $row['att_id'] ?>">
                                  
                                    <?php
                                    echo "<td>".$row['stud_name']."</td>";
                            
                                
                                    ?>

                                    <td> <input class="ch-box" type="checkbox" name="attendance[<?= $row['id'] ?>]" value="Present" <?php echo $row['attendance']=="Present"?"checked":"";?>></td>

                                </tr>

                        <?php
                        }
                    ?>

                  
              
      
                      
                </tbody>
              </table>
            </div>
            </div>

             </form>
            <?php
            
             }else{
                ?>

                <div class="row" style="color: crimson;">
                           <h1>No students Found</h1>
                  </div>
                <?php
             }
            ?>
	     
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

    
        $('#present_all').on('click', function () {
        // Select all checkboxes with the class "ch-box"
        $('.ch-box').prop('checked', true);
         });


         const student = <?php echo json_encode($student); ?>;
         function change_batch() {
            $b=$("#batch").val();
            $("#table_data").children().remove();

            student.forEach(row => {
              if($b==row['batch'] || $b=='all')
              {
                $("#table_data").append("<tr><td>"+row['enroll_no']+"</td><td>"+row['stud_name']+"</td><td><input class='ch-box' type='checkbox' name='attendance["+row['id'] +"]' value='Present' ></td></tr>");
              }
            });
          
         }


          $(".batch_ch").change(function () {
              change_batch();
          });
    });
</script>
</body>
</html>