<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Sinkron_Mikrotik extends CI_Controller
{

    public function Sinkron_Kraksaan()
    {
        $this->M_Mikrotik_Kraksaan->index();
    }

    public function Sinkron_Paiton()
    {
        $this->M_Mikrotik_Paiton->index();
    }
}
