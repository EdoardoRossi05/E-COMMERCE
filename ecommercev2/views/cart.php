<?php

require_once '../models/User.php';
require_once'../models/CartProduct.php';
require_once '../models/Product.php';
require_once '../models/Cart.php';

session_start();

$current_user = $_SESSION['current_user'];

$carrello_user = CartProduct::fetchAll($current_user);
$totale = 0;
?>

<html>
<head>
    <title>Carrello</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;GREZ
            margin: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        ul li {
            margin: 20px 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-top: 10px;
            margin-left: 10px;
        }

        form input {
            padding: 8px;
            margin-right: 10px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 10px 15px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>

<?php include '../views/navbar.php'; ?>

<?php foreach ($carrello_user as $acquisto) {
    $product = Product::Find($acquisto->getProductId());
    $quantita = $acquisto->getQuantita();
    $prezzo = $product->getPrezzo();?>
    <ul>
        <li><?php echo "Marca: ".$product->getMarca(); ?></li>
        <li><?php echo "Nome: ".$product->getNome(); ?></li>
        <li><?php echo "Prezzo: ".$prezzo; ?></li>
        <li><?php echo "Quantità: ".$quantita;?></li>
        <li><?php echo "Prezzo totale: ".$totale += $quantita * $prezzo;?></li>
    </ul>

    <form action="../actions/edit_cart.php" method="POST">
        <input type="number" name="quantita" value="<?php echo $quantita; ?>">
        <input type="hidden" name="cart_id" value="<?php echo $acquisto->getCartId(); ?>">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="submit" value="submit" >
    </form>


<?php } ?>
<p>Totale carrello: <?php echo $totale; ?></p>

</body>
</html>