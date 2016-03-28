<?php
  // Found at https://github.com/tbrianjones/raspberry-pi-i2c-bus/blob/master/peripherals/i2c_bus.php

  // class to deal with i2c communications on the raspberry pi
  //
  // - this class makes use of i2c-tools 
  //
  class i2c_bus
  {
    private $block = 1; // the i2c block (0 on first gen rpi's, 1 on subsequnet rpi's)
    private $i2c_address; // the i2c bus address of the unit being communicated with (set when instantiated)

    function __construct(
                         $i2c_address // the i2c address of the device we're communicating with
                        ) {
      $this->i2c_address = $i2c_address;
    }

    function __destruct() {
    }
// --- READERS --------------------------------------------------------------------

    public function read_register(
                                  $register // register location ( eg. 0x29 )
                                 ) {
      return trim( shell_exec( 'sudo i2cget -y ' . $this->block . ' ' . $this->i2c_address . ' ' . $register ) );
    }

    public function read_signed_short(
                                      $msb_register // most significant byte register location
                                     ) {
      $msb = intval( $this->read_register( $msb_register ), 16 );
      $lsb = intval( $this->read_register( $msb_register + 1 ), 16 );
      $val = ( $msb << 8 ) + $lsb;
      $array = unpack( 's', pack( 'v', $val ) );
      $decimal_value = $array[1];
      return $decimal_value;
    }

/*		public function read_unsigned_short(
			$msb_register	// most significant byte register location
		) {
			$msb = intval( $this->read_register( $msb_register ), 16 );
			$lsb = intval( $this->read_register( $msb_register + 1 ), 16 );
			$val = ( $msb << 8 ) + $lsb;
			$array = unpack( 'S', pack( 'v', $val ) );
			$decimal_value = $array[1];
			return $decimal_value;
		}

		public function read_unsigned_long(
			$msb_register	// most significant byte register location
		) {
			$msb = intval( $this->read_register( $msb_register ), 16 );
			$lsb = intval( $this->read_register( $msb_register + 1 ), 16 );
			$xlsb = intval( $this->read_register( $msb_register + 2 ), 16 );
			$val = ( $msb << 16 ) + ( $lsb << 8 ) + $xlsb;
			$array = unpack( 'l', pack( 'V', $val ) );
			$decimal_value = $array[1];
			return $decimal_value;
		}
*/

// --- WRITERS --------------------------------------------------------------------

    public function write_register(
                                   $register, // register address ( eg. 0x29 )
                                   $value // value to set at register address ( must be a decimal value )
    ) {
      shell_exec( 'sudo i2cset -y ' . $this->block . ' ' . $this->i2c_address . ' ' . $register . ' ' . $value );
    }

  } // class i2c_bus

?>
