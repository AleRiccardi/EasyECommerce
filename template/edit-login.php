<?php

use Inc\Utils\User;
use \Inc\Utils\Image;

require_once($baseController->website_path . "/template/_header.php");

$user = User::getBy($_SESSION['userName']);
?>
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">User</a></li>
                    <li class="breadcrumb-item active">Edit Login</li>
                </ol>
            </nav>
        </div>
    </section>
    <main class="page-edit">
        <section class="flex-container-center brc fit-height-section">
            <div class="container pe-cont flex-item-center">
                <div class="col-12 cont-edit-form">
                    <h1 class="display-4">Edit Login</h1>
                    <form class="form-edit-login" method="post" action="page.php?name=edit-login"
                          enctype="multipart/form-data"
                          name="edit-login-form">
                        <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
                        <input style="display: none;" class="form-control" name="firstName">
                        <input style="display: none;" class="form-control" name="lastName">
                        <input style="display: none;" type="password" class="form-control" placeholder="Password">

                        <div class="user-img-name middle-h-cont form-group row">
                            <div class="col-sm-3">
                                <div class="pu-img">
                                    <img id="preview-icon" class="profile-image"
                                         src="<?php echo User::getProfilePic($user->userName); ?>" alt="Profile image"/>
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
                            <label for="lastName" class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                                <input name="lastName" class="form-control" id="lastName" placeholder="Last Name"
                                       value="<?php echo $user->lastName; ?>">
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
    <script>
        /**
         *
         */
        $('[data-toggle="offcanvas"]').on('click', function () {
            $('.row-offcanvas').toggleClass('active')
        })

        /**
         *
         */
        $('#uploadIcon').change(function (e) {
            var preview = document.getElementById('preview-icon');
            var file = e.target.files[0]; //sames as here
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file); //reads the data as a URL
            } else {
                preview.src = "<?php echo User::getProfilePic($user->userName); ?>";
            }
        });
    </script>

<?php

require_once($baseController->website_path . "/template/_footer.php");
