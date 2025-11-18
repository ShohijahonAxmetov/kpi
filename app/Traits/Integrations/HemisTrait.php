<?php

namespace App\Traits\Integrations;

use Illuminate\Support\Facades\Http;

trait HemisTrait {

	public function getBaseUrl(): string
	{
		return 'https://xmn.tuit.uz/rest';
	}

	public function getPageCount($data): int
	{
		return $data['data']['pagination']['pageCount'];
	}

	public function oAuth()
	{
		$studentProvider = new \League\OAuth2\Client\Provider\GenericProvider([
		    'clientId'                => '8',
		    'clientSecret'            => config('hemis.key'),
		    'redirectUri'             => 'http://hemis-oauth-test.lc/index.php',
		    'urlAuthorize'            => 'https://xmn.tuit.uz/oauth/authorize',
		    'urlAccessToken'          => 'https://xmn.tuit.uz/oauth/access-token',
		    'urlResourceOwnerDetails' => 'https://xmn.tuit.uz/oauth/api/user'
		]);

		// If we don't have an authorization code then get one
		// dd($_GET['start']);
		if (!isset($_GET['code'])) {
		    if (isset($_GET['start'])) {
		        // Fetch the authorization URL from the provider; this returns the
		        // urlAuthorize option and generates and applies any necessary parameters
		        // (e.g. state).
		        $authorizationUrl = $employeeProvider->getAuthorizationUrl();

		        // Get the state generated for you and store it to the session.
		        $_SESSION['oauth2state'] = $employeeProvider->getState();

		        // Redirect the user to the authorization URL.
		        header('Location: ' . $authorizationUrl);
		        exit;
		    } else {
		        echo "<a href='https://xmn.tuit.uz/oauth/authorize?start=1'>Authorize with HEMIS</a>";
		    }
		// Check given state against previously stored one to mitigate CSRF attack
		} else if (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

		    if (isset($_SESSION['oauth2state'])) {
		        unset($_SESSION['oauth2state']);
		    }

		    exit('Invalid state');

		} else {
		    try {
		        // Try to get an access token using the authorization code grant.
		        $accessToken = $employeeProvider->getAccessToken('authorization_code', [
		            'code' => $_GET['code']
		        ]);

		        // We have an access token, which we may use in authenticated
		        // requests against the service provider's API.
		        echo "<p>Access Token: <b>{$accessToken->getToken()}</b></p>";
		        echo "<p>Refresh Token: <b>{$accessToken->getRefreshToken()}</b></p>";
		        echo "Expired in: <b>" . date('m/d/Y H:i:s', $accessToken->getExpires()) . "</b></p>";
		        echo "Already expired: <b>" . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "</b></p>";

		        // Using the access token, we may look up details about the
		        // resource owner.
		        $resourceOwner = $employeeProvider->getResourceOwner($accessToken);

		        echo "<pre>";
		        print_r($resourceOwner->toArray());
		        echo "</pre>";

		    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
		        // Failed to get the access token or user details.
		        exit($e->getMessage());
		    }
		}

		dd($studentProvider);
	}

	public function getAllItems(string $endOfUrl, $type = null):array
	{
		$url = $this->getBaseUrl().$endOfUrl.'?limit=20';
		$res = Http::withToken(config('hemis.key'))
        	->get($url);

		$pageCount = $this->getPageCount($res->json());

    	$temp = $res->json()['data']['items'];

    	if ($pageCount != 1) {
    		for ($i=2; $i <= $pageCount; $i++) { 
				$otherPageRes = Http::withToken(config('hemis.key'))
        			->get($url.'&page='.$i);
    			$temp = array_merge($temp, $otherPageRes->json()['data']['items']);
    		}
    	}

    	switch ($type) {
    		case 'specialities':
    			$temp = $this->getOnlyBachelor($temp);
    			$temp = $this->getUnique($temp);
    			break;

			case 'departments':
    			$temp = $this->getUnique($temp);
    			$temp = $this->getOnlyFaculty($temp);
    			break;
    		
    		default:
    			# code...
    			break;
    	}

    	return $temp;
	}

	/*
	 * use only:
	 *  - $this->getAllItems()
	 */
	public function getOnlyBachelor(array $data): array
	{
		$temp = array_filter($data, function ($item) {
    		return !is_null($item['bachelorSpecialty']);
    	});

		return array_values($temp);
	}

	/*
	 * use only:
	 *  - $this->getAllItems()
	 */
	public function getUnique(array $data): array
	{
		$temp = [];
    	foreach ($data as $value) {
    		if (!isset($temp[0])) $temp[] = $value;
    		else {
    			$allCodes = array_column($temp, 'code');
    			if (!in_array($value['code'], $allCodes)) $temp[] = $value;
    		}
    	}
    	
    	return $temp;
	}

	/*
	 * use only:
	 *  - $this->getAllItems()
	 */
	public function getOnlyFaculty(array $data): array
	{
		$facultyCode = 11;

		$temp = array_filter($data, function ($item) use ($facultyCode) {
    		return $item['structureType']['code'] == $facultyCode;
    	});

    	return array_values($temp);
	}

	public function studentGradeList()
	{
		$url = $this->getBaseUrl().'/v1/data/student-grade-list'.'?limit=20';

		$res = Http::withToken(config('hemis.key'))
        	->get($url);

    	return $res->json();
	}

	public function studentInfo()
	{
		$url = $this->getBaseUrl().'/v1/data/student-info'.'?limit=20&student_id_number=11882';

		$res = Http::withToken(config('hemis.key'))
        	->get($url);

    	return $res->json();
	}

	public function studentList()
	{
		$url = $this->getBaseUrl().'/v1/data/student-list'.'?limit=20';

		$res = Http::withToken(config('hemis.key'))
        	->get($url);

    	return $res->json();
	}
}
