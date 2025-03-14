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
        <form  action="<?= site_url('topics-list/update/' . $program_id.'/'.$semester_number.'/'.$subject_id.'/'.$topic['id']) ?>" method="POST">
            <div class="header p-4">
            <a class="btn btn-sm btn-warning" href="<?= site_url('topics-list/' . $program_id.'/'.$semester_number.'/'.$subject_id) ?>">
                < Back to Topic List</a>
                <div>
                    <h2>EDIT TOPIC</h2>
                </div>

                <button class="submit" type="submit">
                    SAVE
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
                value="<?= esc($topic['topic'])?>"
                placeholder="Enter Topic Name" required/>
                
            </div>

            <div class="col-md-3 col-12">
                <input
                class="form-inputs"
                type="date"
                name="date"
                id="date"
                 value="<?= esc($topic['date'])?>"
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
                                    if($k==$topic['batch']){
                                   ?>
                                        <option value="<?= $k?>" selected>Batch - <?= $k?></option>
                                   <?php }else{ ?>
                                    <option value="<?= $k?>">Batch - <?= $k?></option>
                                  
                                    <?php }}
                            } ?>
                        
                        </select>
                    </div>
                    

            <?php }else{?>
                <input type="hidden" id="batch" name="batch" value="0">
                <?php }?>

                <input type="hidden" id="batch" name="old_batch" value="<?= $topic['batch']?>">
                
            <div class="col-md-3 col-12">
            
                <select class="form-inputs" name="time" required >
                    <?php foreach ($timeslot as $t) {
                            $time_t=$t['start_time'].' - '.$t['end_time'];
                            if($time_t==$topic['time']){
                    ?>

                            <option selected value="<?=$t['start_time'].' - '.$t['end_time']?>"><?=$t['start_time'].' - '.$t['end_time']?></option>
                
                    <?php
                    } else{
                    ?>
                            <option  value="<?=$t['start_time'].' - '.$t['end_time']?>"><?=$t['start_time'].' - '.$t['end_time']?></option>
                
                   

                    <?php }}?>
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

        </div>
</div>
<script>
    const today = new Date().toISOString().split('T')[0];
        // Set the value of the input field with id 'date'
    $('#date').val(today);
</script>
<?= $this->endSection() ?>