<?php

class Customer
{
  private $_firstName;
  private $_lastName;
  private $_contactNumber;
  private $_emailAddress;
  private $_streetAddress;
  private $_suburb;
  private $_postcode;
  private $_state;

  public function __construct(
      $firstName = "",
      $lastName = "",
      $contactNumber = "",
      $emailAddress = "",
      $streetAddress = "",
      $suburb = "",
      $postcode = "",
      $state = ""
  ) {
      $this->_firstName = $firstName;
      $this->_lastName = $lastName;
      $this->_contactNumber = $contactNumber;
      $this->_emailAddress = $emailAddress;
      $this->_streetAddress = $streetAddress;
      $this->_suburb = $suburb;
      $this->_postcode = $postcode;
      $this->_state = $state;
  }

  // Getters
  public function getFirstName() { return $this->_firstName; }
  public function getLastName() { return $this->_lastName; }
  public function getContactNumber() { return $this->_contactNumber; }
  public function getEmailAddress() { return $this->_emailAddress; }
  public function getStreetAddress() { return $this->_streetAddress; }
  public function getSuburb() { return $this->_suburb; }
  public function getPostcode() { return $this->_postcode; }
  public function getState() { return $this->_state; }

  // Setters
  public function setFirstName($value) { $this->_firstName = $value; }
  public function setLastName($value) { $this->_lastName = $value; }
  public function setContactNumber($value) { $this->_contactNumber = $value; }
  public function setEmailAddress($value) { $this->_emailAddress = $value; }
  public function setStreetAddress($value) { $this->_streetAddress = $value; }
  public function setSuburb($value) { $this->_suburb = $value; }
  public function setPostcode($value) { $this->_postcode = $value; }
  public function setState($value) { $this->_state = $value; }

}
