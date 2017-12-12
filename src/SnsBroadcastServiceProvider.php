<?php namespace Ringtrail\LaravelSns;

use Aws\Sns\SnsClient;
use Illuminate\Support\ServiceProvider;

class SnsBroadcastServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->app->make('Illuminate\Broadcasting\BroadcastManager')->extend('sns', function ($app, $config) {
			$sns_config = array(
				'credentials' => array(
					'key'    => $config['aws_key'],
					'secret' => $config['aws_secret'],
				),
				'version' => 'latest',
				'region' => $config['aws_region'],
			);
			if (isset($config['sns_endpoint'])) {
				$sns_config['endpoint'] = $config['sns_endpoint'];
			}
			return new SnsBroadcaster(SnsClient::factory($sns_config));
		});
	}

	public function register()
	{

	}
}
