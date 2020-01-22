<?php

namespace App\Services;

use app\Webservices\N4LoginWebservice;

class N4Loginservice {

    private $n4loginwebservice;

    public function __construct( $n4loginwebservice)
    {
      $this->n4loginwebservice = $n4loginwebservice;
    }

    public function ejecutadLogin ($array){
        dd($this->n4loginwebservice);
    }
}
