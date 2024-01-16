<?php
include '../../models/Session.php';
include '../../models/Product.php';
include '../../models/User.php';
include '../../models/Cart.php';


session_start();
$user = $_SESSION['current_user'];
$products = Product::fetchAll();
?>

<html>
<head>
    <title>Catalogo Prodotti</title>
</head>

<body>

<?php foreach ($products as $product) { ?>
    <ul>
        <li><?php echo $product->getMarca() ?></li>
        <li><?php echo $product->getNome() ?></li>
        <li><?php echo $product->getPrezzo() ?></li>
        <li></li>
    </ul>

    <form action="../../actions/add_to_cart.php" method="POST">
        <input type="number" name="quantita" placeholder="quantita">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="hidden" name="cart_id" value="<?php echo Cart::FindByUserId($user->GetID())->getId(); ?>">
        <input type="submit" value="submit">
    </form>
<?php } ?>

<a href="../../views/cart.php">Vai al carrello</a>

</body>
</html>
