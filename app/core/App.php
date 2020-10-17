<?php

class App
{
    //membuat properti
    protected $controller = 'User';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        //controller
        if (file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            header('Location:' . BASEURL . '/user');
            exit;
        }

        //menginstansiasi kelas
        require_once '../app/controllers/' . ucfirst($this->controller) . '.php';
        $this->controller = new $this->controller;

        //method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        //kelola parametersnya
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        //jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    //mengambil apapun inputan dari url, kemudian memecahnya serta membuat router. Hasil pemecahannya akan dikirim ke method, controller, dan parameter tiap2 halaman
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}