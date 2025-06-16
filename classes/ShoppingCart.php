<?php

// Holds cart items and business logic

// Dependencies
require_once "CartItem.php";

class ShoppingCart
{
    private $_cartItems = [];
    private $_shoppingOrderId;
    // private DBAccess $_db;

    public function __construct()
    {
        // $this->_db = $db;
    }

    public function count()
    {
        return count($this->_cartItems);
    }

    public function setShoppingOrderID($id)
    {
        $this->_shoppingOrderId = (int)$id;
    }

    public function getItems()
    {
        return $this->_cartItems;
    }

    //add item to cart
    public function addItem($cartItem)
    {
        //if cartItem already exists update quatity
        $found = $this->inCart($cartItem);
            if($found != null)
            {
                //update quantity
                $this->updateItem($cartItem);
            }
        else
        {
            //insert new cart item
            $this->_cartItems[] = $cartItem;
        }
    }


    //add quantity
    public function updateItem($cartItem)
    {
        $productId = $cartItem->getItemId();
        $index = $this->itemIndex($cartItem);
        
        //get current quantity
        $oldQty = $this->_cartItems[$index]->getQuantity();
        
        $additionalQty = $cartItem->getQuantity();
        
        //calculate new quantity
        $newQty = $oldQty + $additionalQty;
        
        //update cart item with new quatity
        $this->_cartItems[$index]->setQuantity($newQty);

    }

    //update quantity
    public function updateQuantity($cartItem, $quantity)
    {
        $index = $this->itemIndex($cartItem);
        
        if ($index >= 0) {
            if ($quantity <= 0) {
                $this->removeItem($cartItem);
            } else {
                $this->_cartItems[$index]->setQuantity($quantity);
            }
        }

    }

    //remove item
    public function removeItem($cartItem)
    {
        $index = $this->itemIndex($cartItem);

        if($index >= 0)
        {
            //remove array element
            unset($this->_cartItems[$index]);

            //reorganise values
            $this->_cartItems = array_values($this->_cartItems);
        }
    }


    //calculate total
    public function calculateTotal()
    {
        $total = 0.0;
        foreach ($this->_cartItems as $item)
        {
            $total += $item->getQuantity() * $item->getPrice();
        }

        return $total;
    }


  //save order
  public function saveOrder(DBAccess $db, $name, $address, $email, $contactNumber, $nameOnCard, $cardNumber, $cardMonth, $cardYear, $cvv)
  {

    $total = $this->calculateTotal();

    //set up SQL statement to insert order
    $sql = "insert into tblorder(shipName, shipAddress, orderDate, total, email, contactNumber, nameOnCard, cardNumber, cardExpiryMonth, cardExpiryYear, cvv) values(:Name, :Address, curdate(), :Total, :Email, :ContactNumber, :NameOnCard, :CreditCardNumber, :CardMonth, :CardYear, :CVV)";

    $stmt = $db->prepareStatement($sql);
    $stmt->bindValue(":Name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":Address", $address, PDO::PARAM_STR);
    $stmt->bindValue(":Total" , $total, PDO::PARAM_STR);
    $stmt->bindValue(":Email" , $email, PDO::PARAM_STR);
    $stmt->bindValue(":ContactNumber" , $contactNumber, PDO::PARAM_STR);
    $stmt->bindValue(":NameOnCard" , $nameOnCard, PDO::PARAM_STR);
    $stmt->bindValue(":CreditCardNumber" , $cardNumber, PDO::PARAM_STR);
    $stmt->bindValue(":CardMonth" , $cardMonth, PDO::PARAM_STR);
    $stmt->bindValue(":CardYear" , $cardYear, PDO::PARAM_STR);
    $stmt->bindValue(":CVV" , $cvv, PDO::PARAM_STR);
    $shoppingOrderID = $db->executeNonQuery($stmt, true);

    //loop through shopping cart, insert items
    foreach ($this->_cartItems as $item)
    {
        //set up insert statement
        $sql = "insert into order_item(orderId, itemId, unitPrice, quantity)
        values(:OrderID, :ItemID, :Price, :Quantity)";

        //for each item insert a row in order_item
        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":OrderID" , $shoppingOrderID, PDO::PARAM_INT);
        $stmt->bindValue(":ItemID" , $item->getItemId(), PDO::PARAM_INT);
        $stmt->bindValue(":Price" , $item->getPrice(), PDO::PARAM_STR);
        $stmt->bindValue(":Quantity" , $item->getQuantity(), PDO::PARAM_INT);
        $db->executeNonQuery($stmt);
    }

    return $shoppingOrderID;

  }

    public function getItemsForDisplay(DBAccess $db)
    {
        $displayItems = [];

        foreach ($this->_cartItems as $item) {
            
            $product = new Product($db);
            $product->loadSingleProductByID($item->getItemId());

            $displayItems[] = [
                "itemId" => $item->getItemId(),
                "itemName" => $item->getItemName(),
                "price" => $product->getOriginalPrice(),
                "quantity" => $item->getQuantity(),
                "salePrice" => $product->getSalePrice(),
                "finalPrice" => $product->getFinalPrice(),
                "totalItemPrice" => $item->getTotal(),
                "photo" => $product->getPhoto(),
                "inCart" => true
            ];
        }

        return $displayItems;
    }

    public function getQuantityForProductId(int $productId): int
    {
        foreach ($this->_cartItems as $item) {
            if ($item->getItemId() === $productId) {
                return $item->getQuantity();
            }
        }
        return 0;
    }



    private function inCart($cartItem)
    {
        $found = null;
        foreach($this->_cartItems as $item)
        {
            if ($item->getItemId() == $cartItem->getItemId() )
            {
            $found = $item;
            }
        }
        return $found;
    }


    private function itemIndex($cartItem)
    {
        foreach ($this->_cartItems as $index => $item) {
            if ($item->getItemId() === $cartItem->getItemId()) {
                return $index;
            }
        }
        return -1;
    }


    //display array testing purposes
    public function displayArray()
    {
        print_r($this->_cartItems);
    }
}
