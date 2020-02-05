<?php ?>

<?php include('include/header.inc.php'); ?>
    <form action="/" method="post">
        <fieldset>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label" for="inputDefault">First Name
                        <input type="text" class="form-control" placeholder="First Name">
                    </label>
                </div>
            </div>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Last Name
                        <input type="text" class="form-control" placeholder="Last Name">
                    </label>
                </div>
            </div>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Data of Birth
                        <input type="date" class="form-control" placeholder="Data of Birth">
                    </label>
                </div>
            </div>

            <div class="container">
                <fieldset>
                    <legend>Are you working now?</legend>
                    <label class="form-check-label">
                        <input type="radio" name="options" id="option1"> Yes
                    </label>
                    <label class="orm-check-label">
                        <input type="radio" name="options" id="option1"> No
                    </label>
                </fieldset>
            </div>
            <div class="container form-check">
                <fieldset>
                    <legend>Please Choose Technologies Which You Know</legend>
                    <label class="form-check">
                        <input type="checkbox" name="JS" value="JS">JS<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="CSS" value="CSS">CSS<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="HTML" value="HTML">HTML<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="PHP" value="PHP">PHP<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="NODEJS" value="NODEJS">NODE JS<br>
                    </label>
                </fieldset>
            </div>
            <div class="container form-group">
                <label>Personal info info
                    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                </label>
            </div>
        </fieldset>
    </form>
<?php include('include/footer.inc.php'); ?>