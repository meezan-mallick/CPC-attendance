<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<?php
    $z=false;
    $flag=true;
    foreach ($batches as $key) {
        foreach ($key as $k) {
            if($k==0)
            {
                $z=true;
            }
        }
    }
    if(count($batches)==1 && $z==true)
    {
        $flag=false;
    }
  
   
    
?>
<div class="container-fluid">
    <div class="m-4">
        <form action="<?= site_url('/topics-list/store/(:num)/(:num)/(:num)') ?>" method="POST">
            <div class="header p-4">
            <a class="btn btn-sm btn-warning" href="<?= site_url('faculty-subjects') ?>">
                < Back to Program List</a>
                <div>
                    <h2>ADD NEW TOPIC</h2>
                </div>

                <button class="submit" type="submit">
                    Add
                </button>
            </div>
            <div class="container">
            <hr>
            </div>

            <div class="row">


            <div class="col-md-3 col-12">
                <input
                class="form-inputs"
                type="text"
                name="topic"
                id="topic"
                placeholder="Enter Topic Name" required/>
            </div>

            <div class="col-md-3 col-12">
                <input
                class="form-inputs"
                type="date"
                name="date"
                id="date"
                required />
            </div>

            <?php

                    if($flag)
                    {
            ?>
                    <div class="col-md-3 col-12">
                        
                        <select class="form-inputs" name="batch" required>
                            <?php foreach ($batches as $key) {
                                foreach ($key as $k) {
                                   ?>
                                   <option value="<?= $k?>">Batch - <?= $k?></option>
                                   <?php
                                }
                            }?>
                        
                        </select>
                    </div>

            <?php }?>

            <div class="col-md-3 col-12">
            
                <select class="form-inputs" name="time" required >
                    <?php foreach ($timeslot as $t) {
                        ?>
                            <option value="<?=$t['start_time'].' - '.$t['end_time']?>"><?=$t['start_time'].' - '.$t['end_time']?></option>
                
                        <?php
                    }
                    ?>
                
                </select>
            </div>




            </div>

            <div class="row">

            <?php if (session()->getFlashdata('errors')): ?>
                <div style="color: red;">
                <?= implode('<br>', session()->getFlashdata('errors')); ?>
                </div>
            <?php endif; ?>
            </div>
        </form>

            <hr>

            <div class="table-wrapper data-table">
            <table>
                <thead>

                <tr>
                    <th>ID</th>
                    <th>TOPIC</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <?php if($flag==true){ echo "<th>BATCH</th>";}?>
                    <th>BATCH</th>
                    <th>ATTENDANCE</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

            

                </tbody>
            </table>
        </div>
        </div>
</div>
<script>
 
</script>
<?= $this->endSection() ?>