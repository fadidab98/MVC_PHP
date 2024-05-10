<form method="post" action="">
    <h1 class="m-auto ">Register</h1>

    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input  name="email" value="<?php echo $model->email;?>"
               class="form-control <?php echo $model->hasErrors('email')? 'is-invalid':'';?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted"><?php echo $model->getFirstError('email') ?></small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword2">Repeat Password</label>
        <input type="repeat_password" name="repeat_password" class="form-control" id="exampleInputPassword2" placeholder="Repeat Password">
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>