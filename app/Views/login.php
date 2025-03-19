<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div class="login-container ">
        <h1>Login</h1>
        <hr style="height: 2px;width:70%; color: black; margin-bottom: 10px;">

        <form action="/f-login" method="post">
            <table>
                <tr>
                    <td><label for="username">Username</label></td>
                </tr>
                <tr>
                    <td><input class="form-inputs" type="text" name="username" placeholder="Username"></td>
                </tr>

                <tr>
                    <td><label for="password">Password</label></td>

                </tr>

                <tr>
                    <td><input class="form-inputs" type="password" name="password" placeholder="Password"></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit">SignIn</button></td>
                </tr>



                <tr>
                    <td>
                        <p class="red"><?php echo session()->getFlashdata('message'); ?>
                            <?php
                            if (isset($validation)) { ?>
                                <?= $validation->listErrors(); ?><?php
                                                                }
                                                                    ?>
                        </p>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                    </td>
                </tr>

            </table>

        </form>


    </div>
</body>

</html>