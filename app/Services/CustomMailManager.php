<?php

namespace App\Services;

use Illuminate\Mail\MailManager;

class CustomMailManager extends MailManager
{
    protected $config;

    public function config(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Get the mail connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig(string $name)
    {
        if($this->config) {
            return $this->config;
        }

        // Here we will check if the "driver" key exists and if it does we will use
        // the entire mail configuration file as the "driver" config in order to
        // provide "BC" for any Laravel <= 6.x style mail configuration files.
        return $this->app['config']['mail.driver']
            ? $this->app['config']['mail']
            : $this->app['config']["mail.mailers.{$name}"];
    }
}