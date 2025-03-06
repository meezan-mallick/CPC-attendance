
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
             
              if(!empty($subject)){

          ?>
            <form action="/allocatesubjectstore" method="Post">
              <div class="header">
                <div>
                  <h2>Subjects</h2>
                </div>
               
              </div>
      
              <!-- {/* PERSONAL DETAILS */} -->
              <fieldset>
                <!-- <legend>Subject Details</legend> -->
                <div class="form-container">
                  <div class="row allo-subs">
                   

                    
                       
                        <?php
                        $a=0;
                            foreach ($subject as $row) {
                                  
                                ?>

                                    <div class='subs-btns'><a href="<?= base_url('/alltopics/' . $row['program_id'] . '/' . $row['semester_id'] . '/' . $row['subject_id'] . '/' ) ?>"><?=$row['sub_name']?></a></div>
                                 
                                    <?php
                                    $a+=1;
                                    if($a%3==0)
                                    {
                                        echo "</div> <div class='row allo-subs'>";
                                    }
                             } 
                             
                             
                             foreach ($coordinator_sub as $row) {
                              
                             ?>

                                      <div class='subs-btns'><a href="<?= base_url('/suballstudents/' . $row['prog_id'] . '/' . $row['sem_id'] . '/' . $row['sub_id'] . '/' ) ?>"><?=$row['sub_name']?></a></div>
                                      
                                      <?php
                                      $a+=1;
                                      if($a%3==0)
                                      {
                                          echo "</div> <div class='row allo-subs'>";
                                      }
                                } 

                                ?>

                    
                  
                   
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
            <?php }else{
              ?>
              
                 <div class="row" style="color: crimson;">
                           <h1> You have not been alloted any Subject</h1>
                  </div>
                        
              <?php } ?>
          </div>
          
       


    </div>
	     
   
</body>
</html>