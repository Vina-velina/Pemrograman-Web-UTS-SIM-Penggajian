<div class="container padding-top col-lg-4 col-sm-6">
    <div class="kotak">
        <?php
        Flasher::flash()
        ?>
    </div>
    <div class="card ">
        <h5 class="card-header">Login Administrator</h5>
        <div class="card-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="passwd" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary" value="SUBMIT" name="submit">Login</button>
            </form>
        </div>
    </div>
</div>