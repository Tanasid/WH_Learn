<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthOut implements FilterInterface {
    public function before(RequestInterface $request)
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/start');
        }   
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something
    }
}