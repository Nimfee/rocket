<?php

namespace Rocket\APIBundle\Services;


class ApiManager
{
	public function soapRequst($code, $usr, $pwd, $url)
	{
		$request = '<?xml version="1.0" encoding="UTF-8"?>
                    <REQWX>
                        <USR>' . $usr . '</USR>
                        <PASSWD>' . $pwd . '</PASSWD>
                        <ICAO>' . $code . '</ICAO>
                    </REQWX>';

		$client = new \SoapClient($url);

		$response = $client->getNotam($request);

		return simplexml_load_string($response);
	}
}