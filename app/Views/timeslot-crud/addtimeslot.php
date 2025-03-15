
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
            <form action="/timeslotstore" method="POST">
              <div class="header">
                <div>
                  <h2>Add Timeslot</h2>
                </div>
                <div class="submit-btn">
                  <button class="submit" type="submit">
                    Add
                  </button>
                </div>
              </div>
      
              <!-- {/* PERSONAL DETAILS */} -->
              <fieldset>
                <legend>Slot Details</legend>
                <div class="form-container">
                  <div class="row"  style="justify-content: start;gap:100px;">
                    <div>
                        <label For="start_time">Starting Time</label>
        
                        <input
                          class="form-inputs"
                          type="time"
                          name="start_time"
                          id="start_time"
                          placeholder="Enter Start Time"
                          
                        />
                    </div>
                    <div>
                        <label For="end_time">Ending Time</label>
        
                        <input
                          class="form-inputs"
                          type="time"
                          name="end_time"
                          id="end_time"
                          placeholder="Enter End Time"
                          
                        />
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