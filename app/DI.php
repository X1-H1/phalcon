<?php
// +----------------------------------------------------------------------
// | Application.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App;

use Phalcon\DI\FactoryDefault;
use Phalcon\Config;

/**
 * Class DI
 * @package App
 */
class DI
{
    protected $di;
    protected $config;

    public function __construct(Config $config)
    {
        $this->di = new FactoryDefault();
        $this->config = $config;

        $this->register();

        print_r($this->di->getShared('dispatcher'));
        exit;
    }

    protected function register()
    {
        foreach ($this->config->services->common as $service) {
            $service = new $service;
            $service->register($this->di, $this->config);
        }

        if (IS_CLI) {
            $this->registerCliServices();
        } else {
            $this->registerHttpServices();
        }
    }

    protected function registerCliServices()
    {
        foreach ($this->config->services->cli as $service) {
            $service = new $service;
            $service->register($this->di, $this->config);
        }
    }

    protected function registerHttpServices()
    {
        foreach ($this->config->services->http as $service) {
            $service = new $service;
            $service->register($this->di, $this->config);
        }
    }

    public function getDI()
    {
        return $this->di;
    }
}