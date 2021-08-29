<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class TwigFunctions extends AbstractExtension {

    public function getFunctions()
    {
        return [
            new TwigFunction('isAdministrador', [$this, 'isAdministrador']),
            new TwigFunction('message', [$this, 'message']),
        ];
    }

    public function isAdministrador(){

        if (isset($_SESSION['isAdministrador'])){
            return $_SESSION['isAdministrador'] ? true : false;
        }
    }

    public function message(){

        if (isset($_SESSION['message'])){
            echo "<script> setTimeout(function () {
				toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 4000
				};
				toastr.{$_SESSION['message'][0]}(\"{$_SESSION['message'][1]}\");
			});</script>";
            unset($_SESSION['message']);
        }
    }



}