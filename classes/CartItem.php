<?php

// Represents a single item in the cart 

class CartItem
{
    private $_itemName;
    private $_quantity;
    private $_price;
    private $_productID;
    
    public function __construct($itemName, $price, $productID, $quantity = 1)
    {
        $this->_itemName = $itemName;
        $this->_quantity = (int)$quantity;
        $this->_price = (float)$price;
        $this->_productID = (int)$productID;
    }

    // getters

    public function getQuantity(): int { return $this->_quantity; }
    public function getPrice(): float { return $this->_price; }
    public function getItemId(): int { return $this->_productID; }
    public function getItemName(): string { return $this->_itemName; }

    // setters

    public function setQuantity(int $value)
    {
        if ($value < 1 || $value > 10) {
            throw new Exception("Quantity must be between 1 and 10");
        }

        $this->_quantity = $value;
        }


}
