<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 23/01/2018
 * Time: 10:41
 */

namespace Inc\Utils;


use Inc\Base\BaseController;
use Inc\Database\DbAddress;
use Inc\Database\DbCart;
use Inc\Database\DbItem;
use Inc\Database\DbModel;
use Inc\Database\DbUser;

class Checkout {

    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * Checkout constructor.
     */
    public function __construct() {

    }

    /**
     * Catch a checkout request.
     */
    public function register() {
        if (isset($_POST['checkoutForm'])) {
            $user = User::getCurrentUser();

            $rightFieldsUser = $this->checkUser($user->id);
            $rightFieldsCard = $this->checkCard();

            if ($rightFieldsUser && $rightFieldsCard) {
                $baseC = new BaseController();

                $cart = Cart::getCartUser($user->id);
                $ret = $this->completeCheckout($user->id, $cart->id);
                if ($ret) {
                    header("Location: $baseC->website_url/page.php?name=checkout-success");
                    exit();
                } else {
                    $this->errors[] = "Something went wrong! $user->id, $cart->id";
                }
            }

            $this->showError();
        }
    }

    /**
     * @param            $url
     * @param array      $data
     * @param array|null $headers
     */
    public function redirectPostData($url, array $data, array $headers = null) {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        if (!is_null($headers)) {
            $params['http']['header'] = '';
            foreach ($headers as $k => $v) {
                $params['http']['header'] .= "$k: $v\n";
            }
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if ($fp) {
            echo @stream_get_contents($fp);

        } else {
            // Error
            echo("Error loading '$url', $php_errormsg");
        }
    }

    /**
     *
     * @return bool
     */
    public function checkUser($idUser) {
        if (isset($_POST['firstName']) && isset($_POST['lastName']) &&
            isset($_POST['department']) && isset($_POST['class'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $department = $_POST['department'];
            $class = $_POST['class'];
            $success = true;

            if (!empty($firstName) && !empty($lastName)) {
                $data = [
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                ];
                $success = DbUser::update($data, ["id" => $idUser]) ? true : false;

            } else {
                $this->errors[] = "Error user information";
                $success = false;
            }

            if (!empty($department) && !empty($class)) {
                $success = Address::insertAddress($department, $class) ? true : false;

            } else {
                $this->errors[] = "Error billing address";
                $success = false;
            }

            return $success;
        }

        # default
        return false;
    }

    /**
     *
     * @return bool
     */
    public function checkCard() {
        if (isset($_POST['cc-name']) && isset($_POST['cc-number']) &&
            isset($_POST['cc-expiration']) && isset($_POST['cc-cvv'])) {
            $name = $_POST['cc-name'];
            $number = $_POST['cc-number'];
            $expiration = $_POST['cc-expiration'];
            $cvv = $_POST['cc-cvv'];
            $success = true;
            # NAME
            if (empty($name)) {
                $this->errors[] = "Empty card name";
                $success = false;
            }
            # NUMBER
            if (empty($number)) {
                $this->errors[] = "Empty card number";
                $success = false;
            } else {
                $number = str_replace(' ', '', $number);
                if (!is_numeric($number)) {
                    $this->errors[] = "The card number is not numeric";
                    $success = false;
                } else if (mb_strlen($number) != 16) {
                    $this->errors[] = "The card number must have 16 digits";
                    $success = false;
                }
            }
            # EXPIRATION
            if (empty($expiration)) {
                $this->errors[] = "Empty card expiration";
                $success = false;
            } else {
                $expirationArray = explode("/", $expiration);
                if (count($expirationArray) != 2) {
                    $this->errors[] = "Wrong format for the card expiration date";
                    $success = false;
                }
            }
            # CVV
            if (empty($cvv)) {
                $this->errors[] = "Empty card number";
                $success = false;
            } else if (!is_numeric($cvv)) {
                $this->errors[] = "The CVV is not numeric";
                $success = false;
            }
            return $success;
        }
        # default
        return false;
    }

    /**
     * @param $idUser
     * @param $idCart
     *
     * @return bool|false|int
     */
    private function completeCheckout($idUser, $idCart) {
        $cartItems = Cart::getCartItems($idCart);
        if (!empty($cartItems)) {
            # Variable DB cart
            $price = 0;
            $cartUpdate = [
                "idUser" => $idUser,
                "dateCheckout" => DbCart::now()
            ];
            $address = Address::getAddress($idUser);
            $newAddress = [
                "department" => $address->department,
                "class" => $address->class,
            ];
            $idNewAddress = DbAddress::insert($newAddress);
            $cartUpdate["idAddress"] = $idNewAddress;


            foreach ($cartItems as $cartItem) {
                $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                $price = ($price + ($item->price * $cartItem->quantity));
            }

            $shipPayment = GeneralPrice::getCartShippmentPayment($price);
            $finalPrice = $price + $shipPayment;
            $cartUpdate["finalPrice"] = $finalPrice;

            return DbCart::update($cartUpdate, ["id" => $idCart]) ? true : true;
        } else {
            return false;
        }

    }

    /**
     * Simply return the current state of the class
     *
     * @return void
     */
    public function showError() {
        if ($this->errors) { ?>
            <div class="message alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                $i = 0;
                foreach ($this->errors as $error) {
                    echo $error;
                    if (count($this->errors) != $i++) {
                        echo "<br>";
                    }

                }
                ?>
            </div>
            <?php
        }
        if ($this->messages) { ?>
            <div class="message alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                $i = 0;
                foreach ($this->messages as $message) {
                    echo $message;
                    if (count($this->messages) == $i++) {
                        echo "<br>";
                    }

                }
                ?>
            </div>
            <?php
        }

    }

}