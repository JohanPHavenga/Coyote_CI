    <div class="row">
        <div class="col-sm-6 col-md-4">
            <?php
                echo validation_errors(); 
    
                echo "<div class='form-group'>";
                echo form_label('Username', 'user_username');                
                echo form_open($form_url); 
                echo form_input([
                    'name'          => 'user_username',
                    'id'          => 'user_username',
                    'class'         => 'form-control',
                    'placeholder'   => 'Username',
                    'required'      => '',
                    'autofocus'     => '',
                ]);
                echo "</div>";
    
                echo "<div class='form-group'>";
                echo form_label('Username', 'user_password');   
                echo form_input([
                    'name'          => 'user_password',
                    'id'            => 'user_password',
                    'class'         => 'form-control',
                    'type'          => 'password',
                    'placeholder'   => 'Password',
                    'required'      => '',
                ]);
                echo "</div>";
                echo fbutton("Sign in", "submit", "primary");
                echo form_close();
                ?>
        </div>
    </div>



