<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CosApi
{
	/**
	 * @var string
	 */
	private $api_url;
	/**
	 * @var string
	 */
	private $api_username;
	/**
	 * @var string
	 */
	private $api_password;
	/**
	 * @var object
	 */
	private $token;
	/**
	 * @var string
	 */
	private $api_loc;

	public function __construct($api_config)
	{
		$this->api_url = $api_config['api_url'];
		$this->api_username = $api_config['api_username'];
		$this->api_password = $api_config['api_password'];
		$this->api_loc = "api/";

		$this->token = $this->getToken();
	}


	public function getUserByEmail($email)
	{
		$url = $this->api_url.$this->api_loc.'party?email=eq:'.$email;
		return $this->secureGet($url);
	}


	public function cos21VirtualRegCheck($partyId)
	{
		$url = $this->api_url.$this->api_loc.'EventRegistration?EventId=21VIRTUAL&PartyId='.$partyId;
		return $this->secureGet($url);
	}

	public function cosRepReg2021RegCheck($partyId)
	{
		$url = $this->api_url.$this->api_loc.'EventRegistration?EventId=REPREG2021&PartyId='.$partyId;
		return $this->secureGet($url);
	}

	public function getMembershipType($partyId)
	{
		$url = $this->api_url.$this->api_loc.'cosdemographics/'.$partyId;
		$response = $this->secureGet($url);
		$response = (array) $response;
		$response = (array) $response['Properties'];
		$response = (array) $response['$values'];

		foreach ($response as $attrs => $attr)
		{
			if ($attr->Name == 'Category_Contact')
				return $attr->Value;
		}

		return NULL;
	}


	private function getToken()
	{
		$params= array(
			"grant_type" => 'password',
			"username" => $this->api_username,
			"password" => $this->api_password
		);

		$curl = curl_init();
		$fields_string = http_build_query($params);
		curl_setopt($curl, CURLOPT_URL, $this->api_url.'/token');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
		$response = curl_exec($curl);
		curl_close($curl);

		return json_decode($response);
	}

	private function securePost($url, $params)
	{
		$authorization = "Authorization: Bearer ".$this->token->access_token;
		$headers = array('Accept: application/json' , $authorization );
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		return json_decode($result);
	}

	private function secureGet($url)
	{
		$authorization = "Authorization: Bearer ".$this->token->access_token;
		$headers = array('Accept: application/json' , $authorization );

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);;
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
}
