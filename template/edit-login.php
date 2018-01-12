<?php

use Inc\Classes\User;
use \Inc\Classes\Image;

require_once($baseController->website_path . "/template/_header.php");

if (isset($_POST['editLogin'])) {

    $data = array(
        "firstName" => $_POST['firstName'],
        "secondName" => $_POST['secondName'],
    );

    // PASSWORD
    $user_password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
    if ($user_password) {
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
        $data['passwordHash'] = $user_password_hash;
    }

    // FILE
    if ($_FILES["uploadIcon"]['name']) {
        $idImage = Image::upload($_SESSION['user_name'], $_FILES['uploadIcon']);
        $data['idImage'] = $idImage;
    }

    User::edit($_SESSION['user_name'], $data);
} else if (isset($_POST["removeImage"])) {
    echo User::removeImage($_SESSION["user_name"]) ? "yeahhhhhhhhhhhhh" : "fucking idiot";
}

$user = User::getByNameEmail($_SESSION['user_name']);
?>
    <main class="page-edit">
        <section class="flex-container-center fit-height-section">
            <div class="container flex-item-center">
                <div class="col-12 cont-edit-form">
                    <h1 class="display-4">Edit Login</h1>
                    <form class="form-edit-login" method="post" action="page.php?name=edit-login"
                          enctype="multipart/form-data"
                          name="edit-login-form">
                        <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
                        <input style="display: none;" class="form-control" name="firstName">
                        <input style="display: none;" class="form-control" name="secondName">
                        <input style="display: none;" type="password" class="form-control" placeholder="Password">

                        <div class="user-img-name middle-h-cont form-group row">
                            <div class="col-sm-3">
                                <div class="pu-img">
                                    <img id="preview-icon" class="profile-image"
                                         src="<?php echo User::getProfilePic($_SESSION['user_name']); ?>"/>
                                </div>
                            </div>
                            <div class="middle-h-item col-sm-9">
                                <label class="btn btn-outline-secondary fileContainer">
                                    Upload
                                    <input id="uploadIcon" type="file" name="uploadIcon"/>
                                </label>
                                &nbsp;
                                <input id="remove-icon" type="submit" name='removeImage'
                                       value="Remove it"
                                       class="btn btn-outline-danger btn-remove-file">
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="firstName" class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input name="firstName" class="form-control" id="firstName" placeholder="First Name"
                                       value="<?php echo $user->firstName; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="secondName" class="col-sm-3 col-form-label">Second Name</label>
                            <div class="col-sm-9">
                                <input name="secondName" class="form-control" id="secondName" placeholder="Second Name"
                                       value="<?php echo $user->secondName; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" id="password"
                                       placeholder="Password">
                            </div>
                        </div>
                        <button class="btn btn-primary" name="editLogin" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

<?php

require_once($baseController->website_path . "/template/_footer.php");
