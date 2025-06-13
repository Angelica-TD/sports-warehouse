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
        $index = $this->itemIndex($productId);
        
        //get current quantity
        $oldQty = $this->_cartItems[$index]->getQuantity();
        
        $additionalQty = $cartItem->getQuantity();
        
        //calculate new quantity
        $newQty = $oldQty + $additionalQty;
        
        //update cart item with new quatity
        $this->_cartItems[$index]->setQuantity($newQty);

    }

    //update quantity
    public function updateQuantity($productId, $quantity)
    {
        $index = $this->itemIndex($productId);
        
        //update cart item with new quantity
        $this->_cartItems[$index]->setQuantity($quantity);

    }

    //remove item
    public function removeItem($cartItem)
    {
        $productId = $cartItem->getItemId();
        $index = $this->itemIndex($productId);

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


    //save cart
    public function saveCart(DBAccess $db, $Address, $ContactNumber, $CreditCardNumber, $CSV, $Email,
    $ExpiryDate, $FirstName, $LastName, $NameOnCard)
    {


        //set up SQL statement to insert order
        $sql = "insert into ShoppingOrder(Address, ContactNumber, CreditCardNumber, CSV,
        Email, ExpiryDate, FirstName, LastName, NameOnCard, OrderDate) values(:Address, :ContactNumber, :CreditCardNumber, :CSV, :Email, :ExpiryDate, :FirstName, :LastName,
        :NameOnCard, curdate())";

        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":Address" , $Address, PDO::PARAM_STR);
        $stmt->bindValue(":ContactNumber" , $ContactNumber, PDO::PARAM_STR);
        $stmt->bindValue(":CreditCardNumber" , $CreditCardNumber, PDO::PARAM_STR);
        $stmt->bindValue(":CSV" , $CSV, PDO::PARAM_STR);
        $stmt->bindValue(":Email" , $Email, PDO::PARAM_STR);
        $stmt->bindValue(":ExpiryDate" , $ExpiryDate, PDO::PARAM_STR);
        $stmt->bindValue(":FirstName" , $FirstName, PDO::PARAM_STR);
        $stmt->bindValue(":LastName" , $LastName, PDO::PARAM_STR);
        $stmt->bindValue(":NameOnCard" , $NameOnCard, PDO::PARAM_STR);
        $shoppingOrderID = $db->executeNonQuery($stmt, true);

        //loop through shopping cart, insert items
        foreach ($this->_cartItems as $item)
        {
            //set up insert statement
            $sql = "insert into OrderItem(ItemID, Price, Quantity, shoppingOrderID)
            values(:ItemID, :Price, :Quantity, :shoppingOrderID)";

            //for each item insert a row in OrderItem
            $stmt = $db->prepareStatement($sql);
            $stmt->bindValue(":ItemID" , $item->getItemId(), PDO::PARAM_INT);
            $stmt->bindValue(":Price" , $item->getPrice(), PDO::PARAM_STR);
            $stmt->bindValue(":Quantity" , $item->getQuantity(), PDO::PARAM_INT);
            $stmt->bindValue(":shoppingOrderID" , $shoppingOrderID, PDO::PARAM_INT);
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


    private function itemIndex($productId)
    {
        $index = -1;
        for($i=0; $i<$this->count(); $i++)
        {
            if($productId == $this->_cartItems[$i]->getItemId())
            {
                $index = $i;
            }
        }
        return $index;
    }


    //display array testing purposes
    public function displayArray()
    {
        print_r($this->_cartItems);
    }
}
