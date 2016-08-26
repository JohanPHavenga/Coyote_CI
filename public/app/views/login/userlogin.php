    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <?php
                echo validation_errors(); 
            ?>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                <?php
                    echo form_open($form_url,["class"=>"form-signin"]); 
                    echo form_input([
                        'name'          => 'user_username',
                        'class'         => 'form-control',
                        'placeholder'   => 'Username',
                        'required'      => '',
                        'autofocus'     => '',
                    ]);
                    echo form_input([
                        'name'          => 'user_username',
                        'class'         => 'form-control',
                        'type'          => 'password',
                        'placeholder'   => 'Password',
                        'required'      => '',
                    ]);
                    echo fbutton("Sign in", "submit", "primary");
                    echo form_close();
                ?>
            </div>
            <a href="#" class="text-center new-account">Create an account </a>
        </div>
    </div>



