<?php
require_once('i2c_bus.php');

class DS1631 {
  const i2c_address = 0x48;

  private $I2c; // i2c connection

  function __construct() {
    // i2c communication class
    $this->I2c = new i2c_bus(self::i2c_address);
    $this->start_conversion();
  }

  public function start_conversion() {
    $this->I2c->write_register(0x51,0);
  }

  public function read_temperature() {
    return $this->I2c->read_register(0xaa);
  }

  public function C() {
    // read the temperature (C)
    return $this->I2c->read_signed_short(0xaa)/256;
  }

  public function f() {
    // read the temperature (C) and return as F
    $r = $this->C();
    return $r * (9.0 / 5.0) + 32.0;
  }
}
?>
