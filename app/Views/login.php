<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        * {
            font-family: Verdana;
            box-sizing: border-box;

        }

        .login-container {
            width: 40vw;
            padding: 20px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

        }

        .login-container h1 {
            text-align: center;
            letter-spacing: 2px;
        }


        .login-container table tr:nth-child(odd) td {
            padding-top: 30px;
        }

        .login-container table tr td label {
            font-size: 17px;

            letter-spacing: 1px;
        }

        .form-inputs,
        .dropdown {
            margin-top: 10px;
            width: 15rem;
            height: 3rem;
            background-color: #FAFAFA;
            border: 1px solid #E3E3E3;
            border-radius: 4px;
            padding: 0px 20px;
        }

        ::placeholder {
            padding-left: 0px;
            color: #C2C2C2;
            font-weight: 400;
            font-size: 0.9rem;
        }


        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        td button {
            font-size: 20px;
            letter-spacing: 1px;
            background-color: black;
            color: white;
            width: 100%;
            padding: 10px 30px;
        }

        td p {
            text-align: center;
        }

        td p a {
            font-size: inherit;
            text-align: center;
            width: 100%;
            letter-spacing: 1px;
        }

        .login-container table tr:last-child td {
            padding: 0px;

        }

        a {
            text-decoration: none;
            color: black;
        }

        .red {
            color: crimson;
        }
    </style>
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
                    </td>
                </tr>

            </table>

        </form>


    </div>
</body>

</html>