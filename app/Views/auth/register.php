<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Numans');

        html,
        body {
            background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            font-family: 'Numans', sans-serif;
        }

        .container {
            height: 100%;
            align-content: center;
        }

        .card {
            height: fit-content;
            margin-top: auto;
            margin-bottom: auto;
            width: 400px;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .card-header h3 {
            color: white;
        }

        .social_icon {
            position: absolute;
            right: 20px;
            top: -45px;
        }

        .input-group-prepend span {
            width: 50px;
            background-color: #FFC312;
            color: black;
            border: 0 !important;
        }

        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;

        }

        .remember {
            color: white;
        }

        .remember input {
            width: 20px;
            height: 20px;
            margin-left: 15px;
            margin-right: 5px;
        }

        .login_btn {
            color: black;
            background-color: #FFC312;
            width: 100px;
        }

        .login_btn:hover {
            color: black;
            background-color: white;
        }

        .links {
            color: white;
        }

        .links a {
            margin-left: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url('register_process'); ?>" method="post" class="mt-4">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div> <input type="text" name="username" id="username" class="form-control" placeholder="username" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-font"></i></span>
                            </div> <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-font"></i></span>
                            </div> <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div> <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div> <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                        </div>
                        <div id="favourite-sports-container" class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-futbol"></i></span>
                            </div>
                                <input type="text" class="form-control" id="favourite_sport_1" name="favourite_sport[]" placeholder="Enter a sport">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-sport-btn" id="add-sport" type="button">+</button>
                                </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div> <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="register" class="btn float-right login_btn">
                        </div>
                        <div class="d-flex flex-column justify-content-center links">
                        Already have an account? <a href="<?php echo base_url('login'); ?>">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('favourite-sports-container');
                        const addSportButton = container.querySelector('.add-sport-btn');

                        addSportButton.addEventListener('click', function() {
                            let sportIndex = 1;

                            document.getElementById('add-sport').onclick = function() {
                                sportIndex++;
                                const newInput = document.createElement('div');
                                newInput.innerHTML = `
                            <div id="favourite-sports-container" class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                                <input type="text" class="form-control" id="favourite_sport_${sportIndex}" name="favourite_sport[]" placeholder="Enter a sport">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-sport-btn" id="add-sport" type="button">+</button>
                                </div>
                        </div>
    `;
                                document.getElementById('sport-container').appendChild(newInput);
                            };

                            // Create a new input group
                            const newInputGroup = document.createElement('div');
                            newInputGroup.className = 'input-group mb-2';

                            // Create the new input field
                            const newInput = document.createElement('input');
                            newInput.type = 'text';
                            newInput.className = 'form-control';
                            newInput.name = 'favourite_sport[]';
                            newInput.placeholder = 'Enter a sport';

                            // Create the remove button
                            const removeButton = document.createElement('button');
                            removeButton.className = 'btn btn-outline-danger';
                            removeButton.type = 'button';
                            removeButton.innerText = '-';

                            removeButton.addEventListener('click', function() {
                                container.removeChild(newInputGroup);
                            });

                            // Append the new input and button to the input group
                            const inputGroupAppend = document.createElement('div');
                            inputGroupAppend.className = 'input-group-append';
                            inputGroupAppend.appendChild(removeButton);

                            newInputGroup.appendChild(newInput);
                            newInputGroup.appendChild(inputGroupAppend);

                            // Append the new input group to the container
                            container.appendChild(newInputGroup);
                        });
                    });
                </script>
</body>

</html>