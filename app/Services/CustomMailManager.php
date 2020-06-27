<?php

namespace App\Models\Services;

use Illuminate\Mail\MailManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CustomMailManager extends MailManager
{
    protected $config;

    public function config(array $config)
    {
        $this->config = $config;

        $this->setGlobalAddress($this, $config, 'from');

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
        if ($this->config) {
            return $this->config;
        }

        // Here we will check if the "driver" key exists and if it does we will use
        // the entire mail configuration file as the "driver" config in order to
        // provide "BC" for any Laravel <= 6.x style mail configuration files.
        return $this->app['config']['mail.driver']
            ? $this->app['config']['mail']
            : $this->app['config']["mail.mailers.{$name}"];
    }

    /**
     * Set a global address on the mailer by type.
     *
     * @param  \Illuminate\Mail\Mailer  $mailer
     * @param  array  $config
     * @param  string  $type
     * @return void
     */
    protected function setGlobalAddress($mailer, array $config, string $type)
    {
        $address = Arr::get($config, $type, $this->app['config']['mail.'.$type]);

        if ($this->config && isset($this->config[$type])) {
            $address = Arr::get($config, $type, $this->config[$type]);
        }

        if (is_array($address) && isset($address['address'])) {
            $mailer->{'always'.Str::studly($type)}($address['address'], $address['name']);
        }
    }
}
