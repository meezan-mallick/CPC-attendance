
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

       
        <div class="container add-form">
          
          <?php
             
              if(!empty($program)){

          ?>
            <form action="<?= base_url('/update-allocatesubjectstore/'.$allocatesubject['id'])?>"  method="Post">
              <div class="header">
                <div>
                  <h2>Update Allocate Subject</h2>
                </div>
                <div class="submit-btn">
                  <button class="submit" type="submit">
                    <input type="hidden" id="allot_subid" name="allot_sub" value="<?=$allocatesubject['subject_id']?>">
                    Update
                  </button>
                </div>
              </div>
      
              <!-- {/* PERSONAL DETAILS */} -->
              <fieldset>
                <legend>Subject Details</legend>
                <div class="form-container">
                  <div class="row">
                   

                    <div>
                        <label For="faculty_id">Faculty</label>
        
                        <select name="faculty_id" id="" class="dropdown" style="width: fit-content;">
                        <?php
                            foreach ($faculty as $row) {
                                if($row['id']==$allocatesubject['faculty_id']){
                                    echo "<option selected value=".$row['id'].">".$row['name']."  </option>";
                                  
                                  } 
                                  else{
                                    echo "<option value=".$row['id'].">".$row['name']."  </option>";
                                  
                                  }
                                   
                             } ?>
                        </select>
                    </div>
                   
                
                    <div>
                        <label For="program_id">Program</label>
        
                        <select name="program_id" id="pro_id" class="dropdown p_change" style="width: fit-content;">
                        <?php
                            foreach ($program as $row) {
                             
                                if($row['id']==$allocatesubject['program_id']){
                                    echo "<option selected value=".$row['id'].">".$row['program_name']."</option>";
                               
                                  } 
                                  else{
                                    echo "<option value=".$row['id'].">".$row['program_name']."</option>";
                               
                                  }
                      
                           
                             } ?>
                        </select>
                       
                    </div>

                  
                      <div>
                        <label For="semester_id">Semester</label>
        
                        <select name="semester_id" id="sem_id" class="dropdown s_change">
                        <?php
                            foreach ($semester as $row) {
                            echo "<option value=".$row['id'].">".$row['semester']."</option>";
                            
                             } ?>
                        </select>
                       
                      </div>

                      <div>
                        <label For="subject_id">Subject</label>
        
                        <select name="subject_id" id="sub_change" class="dropdown" style="width: fit-content;">
                        <?php
                            foreach ($subject as $row) {
                            echo "<option value=".$row['id'].">".$row['sub_name']."</option>";
                            
                             } ?>
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
                     <div class="row" style="color: crimson;" id="sub_error">
                           
                    </div>
              </fieldset>
              
            </form>
            <?php }else{
              ?>
              
                 <div class="row" style="color: crimson;">
                           <h1>Please Add Programs</h1>
                  </div>
                        
              <?php } ?>
          </div>
          
       


    </div>
	     
    <script>
        // PHP data as a JavaScript variable
        const program = <?php echo json_encode($program); ?>;
        const semester = <?php echo json_encode($semester); ?>;
        const subject = <?php echo json_encode($subject); ?>;
        const allocatesubject = <?php echo json_encode($allocatesubject); ?>;
        
       // Check the data in the browser console

       function change_pro() {
        
          
            $p_id=$('#pro_id').val();
            $s_id=$('#sem_id').val();

            $("#sem_id").children().remove();
          
            $arr=[];
            // console.log($p_id);
            $("#sub_change").children().remove();
            subject.forEach(row => {
              
              if ($p_id==row['program_id']) {
                $arr.push(row['semester_id']);
              }
            });

            $arr=$arr.filter((item, index) => $arr.indexOf(item) === index);

            semester.forEach(row => {
              $k1=row['id'];
              $arr.forEach(e=> {
                $k=e;
                if ($k==$k1) {
                  $("#sem_id").append("<option value="+row['id']+">"+row['semester']+"</option>");
                  
                }
              
              });
              
             
             
            });
           console.log($arr);
           

       }


       function change_sem()
       {
            $p_id=$('#pro_id').val();
            $s_id=$('#sem_id').val();

            // console.log($p_id);
            $("#sub_change").children().remove();
            subject.forEach(row => {
              
              if ($p_id==row['program_id'] && $s_id==row['semester_id']) {
                $("#sub_change").append("<option value="+row['id']+">"+row['sub_name']+"</option>");
              }
            });

            if($("#sub_change").children().length<1)
            {
                $("#sub_error").append("<p>Subjects not Available</p>");
            }
            else{
              $("#sub_error").html("");
            }
       }


       change_pro();
       $("#sem_id").val(allocatesubject['semester_id']); 
       change_sem();
       $("#sub_change").val(allocatesubject['subject_id']); 
      
       $(".s_change").change(function () {
        change_sem();
        });

        $(".p_change").change(function () {
        change_pro();
        change_sem();
        });


    </script>

</body>
</html>