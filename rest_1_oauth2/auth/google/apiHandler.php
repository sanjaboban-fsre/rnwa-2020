<?php

class GoogleApiHandler
{
    public function getAccessToken($client_id, $redirect_uri, $client_secret, $code) {
        $url = 'https://accounts.google.com/o/oauth2/token';

		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if($http_code != 200)
			throw new Exception('Error : Failed to receieve access token');

		return $data;
    }

    public function getUserProfile($access_token) {
        $url = 'https://people.googleapis.com/v1/people/me?personFields=names,emailAddresses';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_code != 200)
			throw new Exception('Error : Failed to get user information - '.$http_code.' - ');

		return $data;
    }
}
