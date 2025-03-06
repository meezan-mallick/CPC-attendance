
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

      

        <form action="<?= base_url('/topicstore/' . $prog_id . '/' . $sem_id . '/' . $sub_id . '/' ) ?>" method="Post">
            
            <div class="header" style="margin-bottom: 30px;display: flex;flex-direction: column;justify-content: start;align-items: start;">
              <div class="heading">
                <h2>Topic</h2>
              </div>

             <div style="width:100%; display: flex;flex-direction: row;justify-content: space-between;align-items: center;">
              <div>
                <input type="text" id="topic" name="topic" class="form-inputs" placeholder="Enter Topic Name" style="margin-right: 20px;">

                <input type="date" id="date" name="date" class="form-inputs" style="width: 7vw;margin-right: 20px;">

                <select name="batch" id="batch" class="dropdown batch_ch" style="width: fit-content;margin-right: 20px;">
                  <option value="all">All Batch</option>
                  <?php
                      foreach ($batches as $row) {
                        echo "<option value=".$row['batch'].">Batch-".$row['batch']."</option>";
                      }

                  ?>
                </select>

                <select name="time" id="time" class="dropdown " style="width: fit-content;">
                  
                  <?php
                      foreach ($timeslot as $row) {
                        $t=$row['start_time']."-".$row['end_time'];
                        echo "<option value=".$t.">".$row['start_time']." - ".$row['end_time']."</option>";
                      }

                  ?>
                </select>
              </div>
              
            


              <div class="add-btn">
              
               <button type="submit" class="submit">
                  Add
                </button>
              </div>
             </div>
             <?php
                        if(isset($validation)){?>
                         <div class="row" style="color: crimson;">
                            <?=$validation->listErrors();?>
                        </div><?php
                        }
                    ?>
            </div>
            <div class="table-wrapper data-table">
                <?php
                    if(!empty($topics)){
                ?>
                          <table>
                            <thead>
                        
                              <tr>
                                <th>Id</th>
                                <th>TOPIC</th>
                                <th>Date</th>
                              
                                <th>Time</th>
                                <th>Batch</th>
                                <th>Attendance</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody id="table_data">
                              
                          

                                    <?php
                                        foreach ($topics as $row) {
                                            echo "<tr>";
                                            echo "<td>".$row['id']."</td>";
                                            echo "<td>".$row['topic']."</td>";
                                            echo "<td>".$row['date']."</td>";
                                            echo "<td>".$row['time']."</td>";
                                            echo "<td>".$row['batch']."</td>";
                                            echo "<td>".$row['total_present']."/".$row['total_stud']."</td>";
                                            
                                            ?>
                                            
                                            
                                            <td><a href="<?= base_url('attendance/'.$prog_id . '/' . $sem_id . '/' . $sub_id . '/'.$row['id']. '/'.$row['batch'])?>" class="submit"  style="margin-right: 5px;background-color: #04AA6D;border:1px solid #04AA6D ;font-size:12px;">Attendance</a>
                                            <a href="<?= base_url('delete-topic/'. $prog_id . '/' . $sem_id . '/' . $sub_id . '/'.$row['id'])?>"  class="submit"  style="margin-right: 10px;background-color: red;border:1px solid red ;font-size:12px;">Delete</a></td>

                                        </tr>

                                <?php
                                }
                            ?>
                          
                  
                                  
                            </tbody>
                          </table>
                <?php
                  }else{
                    ?>
                         <div class="row" style="color: crimson;">
                            <h4>No topics Found</h4>
                   </div> 

                   <?php
                  }
                ?>
            </div>
            </div>

             </form>
           
	     
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // Get today's date in the format 'YYYY-MM-DD'
        const today = new Date().toISOString().split('T')[0];
        // Set the value of the input field with id 'date'
        $('#date').val(today);


          const topic = <?php echo json_encode($topics); ?>;
          const prog_id = <?php echo json_encode($prog_id); ?>;
          const sem_id = <?php echo json_encode($sem_id); ?>;
          const sub_id = <?php echo json_encode($sub_id); ?>;

          console.log(sub_id);
         function change_batch() {
            $b=$("#batch").val();
             $("#table_data").children().remove();

            topic.forEach(row => {
              if($b==row['batch'] || $b=='all')
              {
                var tdContent = `
                  <td>
                      <a href="<?= base_url('attendance/') ?>${prog_id}/${sem_id}/${sub_id}/${row['id']}/${row['batch']}" class="submit" 
                        style="margin-right: 5px;background-color: #04AA6D;border:1px solid #04AA6D ;font-size:12px;">
                        Attendance
                      </a>
                      <a href="<?= base_url('delete-topic/') ?>${prog_id}/${sem_id}/${sub_id}/${row['id']}" class="submit" 
                        style="margin-right: 10px;background-color: red;border:1px solid red ;font-size:12px;">
                        Delete
                      </a>
                  </td>`;
                $("#table_data").append(`<tr><td>`+row['id']+`</td><td>`+row['topic']+`</td><td>`+row['date']+`</td><td>`+row['time']+`</td><td>`+row['batch']+`</td><td>`+row['total_present']+`/`+row['total_stud']+`</td>`+tdContent+`</tr>`);
                
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