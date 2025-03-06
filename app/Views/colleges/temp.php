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


    <?php include APPPATH . 'Views/navbar.php'; ?>

    <div class="main-wrapper">

        <?php include APPPATH . 'Views/header.php'; ?>


        <div class="container add-form">
            <form action="/colleges/store" method="post">
                <div class="header">
                    <div>
                        <a href="<?= site_url('colleges') ?>">Back to List</a>
                        <h2>Add College</h2>
                    </div>
                    <div class="submit-btn">
                        <button class="submit" type="submit">
                            Add College
                        </button>
                    </div>
                </div>



                <!-- {/* PERSONAL DETAILS */} -->
                <fieldset>
                    <legend>College Details</legend>
                    <div class="form-container">
                        <div class="row">
                            <div class="col-3">
                                <label For="name">College Code</label>

                                <input
                                    class="form-inputs"
                                    type="text"
                                    name="college_code"
                                    id="name"
                                    placeholder="Enter College Code" />
                            </div>

                            <div class="col-6">
                                <label For="username">College Name</label>

                                <input
                                    class="form-inputs"
                                    type="text"
                                    name="college_name"
                                    id="username"
                                    placeholder="Enter College Name" />
                            </div>



                        </div>

                        <?php
                        if (isset($validation)) { ?>
                            <div class="row" style="color: crimson;">
                                <?= $validation->listErrors(); ?>
                            </div><?php
                                }
                                    ?>

                </fieldset>

            </form>

        </div>

    </div>



</body>

</html>