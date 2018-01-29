<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 29/01/2018
 * Time: 01:09
 */

namespace Inc\Admin;


use Inc\Base\BaseController;
use Inc\Database\DbUser;

class UserAdmin extends BaseController {

    /**
     * Product constructor.
     */
    public function __construct() {
        // BaseController
        parent::__construct();

        // Check if have privilege
        if (!\Inc\Utils\User::isAdmin()) {
            return false;
        }
    }

    public function register() {
        // in this case unless class
        if (isset($_GET['user'])) {

            if (isset($_GET['add-new'])) {
                $this->showAddNew();
            } else if (isset($_GET['edit']) && isset($_GET['id'])) {
                $this->showEdit($_GET['id']);
            } else {
                $this->getMain("User");
            }

        }
    }

    /**
     * @param $name
     */
    public function getMain($name) {
        $users = DbUser::getAll("object");

        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>List User</h4>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <caption>List of the all users</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Is admin</th>
                        <th>Date registration</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($users) {
                        foreach ($users as $user) {
                            ?>

                            <tr> <!--onclick="window.location='?name=admin-area&product&edit&id=<?php echo $user->id; ?>';"-->
                            <td><?php echo $user->id; ?></td>
                            <td><?php echo $user->userName; ?></td>
                            <td><?php echo $user->userEmail; ?></td>
                            <td><?php echo $user->firstName; ?></a></td>
                            <td><?php echo $user->lastName; ?></td>
                            <td><?php echo $user->isAdmin ? "yes" : "no"; ?></td>
                            <td><?php echo $user->dateRegistration; ?></td>
                            </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
        </main>
        <?php
    }

}