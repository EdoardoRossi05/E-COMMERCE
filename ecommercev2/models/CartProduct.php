<?php


class CartProduct
{
    private $id, $product_id, $cart_id, $quantita;

    public function GetId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cart_id;
    }

    /**
     * @param mixed $cart_id
     */
    public function setCartId($cart_id)
    {
        $this->cart_id = $cart_id;
    }

    /**
     * @return mixed
     */
    public function getQuantita()
    {
        return $this->quantita;
    }

    /**
     * @param mixed $quantita
     */
    public function setQuantita($quantita)
    {
        $this->quantita = $quantita;
    }


    public static function Create($cart_id, $product_id, $quantita)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select quantita from ecommerce.cart_products where cart_id = :cart_id AND product_id=:product_id");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        if(!$stmt->fetchObject("CartProduct"))
        {
            $stmt = $pdo->prepare("INSERT INTO ecommerce.cart_products (cart_id, product_id, quantita) VALUES (:cart_id, :product_id, :quantita)");
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":quantita", $quantita);
            $stmt->execute();
        }
        else
        {
            $stmt = $pdo->prepare("update ecommerce.cart_products set quantita =:quantita where cart_id = :cart_id AND product_id=:product_id");
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->bindParam(":quantita", $quantita);
            $stmt->execute();
        }
        return true;








        /*
        $stmt = $pdo->prepare("INSERT INTO ecommerce.cart_products (cart_id, product_id, quantita) VALUES (:cart_id, :product_id, :quantita)");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantita", $quantita);

        if(!$stmt->execute())
        {
            return false;
        }
        return self::last_record();
        */

    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }

    public static function last_record()
    {
        $pdo = self::connect();
        $stm = $pdo->prepare("SELECT cart_id FROM ecommerce.cart_products ORDER BY cart_id DESC LIMIT 1");

        if (!$stm->execute()) {
         return false;
        }
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        return $result['cart_id'];
    }

    public static function fetchAll($current_user)
    {

        $user_id = $current_user->GetID() ;
        $cart_id = Cart::FindByUserId($user_id)->getId();
        $pdo = self::connect();
        $stmt = $pdo->prepare("select * from ecommerce.cart_products where cart_id =:cart_id");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'CartProduct');
    }

    public static function Find($cart_id, $product_id)
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare("select * from ecommerce.cart_products where cart_id =:cart_id and product_id =:product_id");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->bindParam(":product_id", $product_id);
        if(!$stmt->execute())
        {
            return false;
        }
        return $stmt->fetchObject("CartProduct");
    }

    public function Save($cart_id,$product_id,$quantita)
    {
        $cart_product=self::Find($cart_id,$product_id);
        $pdo = self::connect();
        $stmt = $pdo->prepare("update ecommerce.cart_products set quantita = :quantita where cart_id =:cart_id AND product_id=:product_id ");
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantita", $quantita);

        $stmt->execute();
    }

}