<?php
/**
 * @todo give the possibility to store more of one address.
 */

use Inc\Utils\Address;

require_once($baseController->website_path . "/template/_header.php");
$user = \Inc\Utils\User::getCurrentUser();
$address = Address::getAddress($user->id);
?>
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">User</a></li>
                    <li class="breadcrumb-item active">Edit Address</li>
                </ol>
            </nav>
        </div>
    </section>
    <main class="page-edit">
        <section class="flex-container-center brc fit-height-section">
            <div class="container pe-cont flex-item-center">
                <div class="col-12 cont-edit-form">
                    <h1 class="display-4">Edit Address</h1>
                    <p>Write the information of your university, that consist in a department and a class to permit to
                        receive the food in the best place for you.</p>
                    <form class="form-edit-login" method="post" action="page.php?name=edit-address"
                          enctype="multipart/form-data"
                          name="edit-login-form">
                        <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
                        <input style="display: none;" class="form-control" name="firstName">
                        <input style="display: none;" class="form-control" name="lastName">
                        <input style="display: none;" type="password" class="form-control" placeholder="Password">

                        <div class="form-group row">
                            <label for="department" class="col-sm-3 col-form-label">Department</label>
                            <div class="col-sm-9">
                                <input name="department" class="form-control" id="firstName"
                                       placeholder="Ing. Informatica / Civile / Chimica ... "
                                       value="<?php echo $address ? $address->department : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="class" class="col-sm-3 col-form-label">Class</label>
                            <div class="col-sm-9">
                                <input name="class" class="form-control" id="lastName"
                                       placeholder="Aula Magna / A1 / C ..."
                                       value="<?php echo $address ? $address->class : ""; ?>">
                            </div>
                        </div>

                        <button class="btn btn-primary" name="editAddress" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </section>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
