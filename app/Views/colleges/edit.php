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
            <form action="<?= base_url('/colleges/update' . $college['id']) ?>" method="Post">
                <div class="header">
                    <a href="/colleges">Back to Colleges</a>
                    <div>
                        <h2>Update College</h2>

                    </div>
                    <div class="submit-btn">
                        <button class="submit" type="submit">
                            Update
                        </button>
                    </div>
                </div>

                <!-- {/* PERSONAL DETAILS */} -->
                <fieldset>
                    <legend>Faculty Details</legend>
                    <div class="form-container">
                        <div class="row">
                            <div>
                                <label For="name">College Code</label>

                                <input
                                    class="form-inputs"
                                    type="text"
                                    name="name"
                                    id="name"
                                    placeholder="Enter College Code"
                                    value="<?= $college['college_code'] ?>" />
                            </div>

                            <div>
                                <label For="username">College Name</label>

                                <input
                                    class="form-inputs"
                                    type="text"
                                    name="username"
                                    id="username"
                                    placeholder="Enter College Name"
                                    value="<?= $college['college_name'] ?>" />
                            </div>


                        </div>

                        <?php
                        if (isset($validation)) { ?>
                            <div class="row" style="color: crimson;">
                                <?= $validation->listErrors(); ?>
                            </div><?php
                                }
                                if (isset($validationdup)) { ?>
                            <div class="row" style="color: crimson;">
                                <?= $validationdup; ?>
                            </div><?php
                                }
                                    ?>

                </fieldset>

            </form>

        </div>

    </div>



</body>

</html>