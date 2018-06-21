<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mockery\Exception;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Exception\SdkException;

class Quickbooks extends Model
{

    public function connect(){
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => $this->ClientID,
            'ClientSecret' => $this->ClientSecret,
            'accessTokenKey' =>  $this->accessToken,
            'refreshTokenKey' => $this->refreshToken,
            'QBORealmID' => $this->realmID,
            'baseUrl' => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        try{
            $accessToken = $OAuth2LoginHelper->refreshToken();
        } catch ( SdkException $e){
            return ['error' => true, 'message' => $e->getMessage()];
        }
        $error = $OAuth2LoginHelper->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
            return;
        }
        $dataService->updateOAuth2Token($accessToken);
        $dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
// Iterate through all Accounts, even if it takes multiple pages
        echo "<pre/>";
        $i = 1;
        while (1) {
            $allAccounts = $dataService->FindAll('Account', $i, 500);
            $error = $dataService->getLastError();
            if ($error) {
                echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                echo "The Response message is: " . $error->getResponseBody() . "\n";
                exit();
            }
            if (!$allAccounts || (0==count($allAccounts))) {
                break;
            }
            foreach ($allAccounts as $oneAccount) {
                echo "Account[".($i++)."]: {$oneAccount->Name}\n";
                echo "\t * Id: [{$oneAccount->Id}]\n";
                echo "\t * AccountType: [{$oneAccount->AccountType}]\n";
                echo "\t * AccountSubType: [{$oneAccount->AccountSubType}]\n";
                echo "\t * Active: [{$oneAccount->Active}]\n";
                echo "\n";
            }
        }
    }


    public function getAuthUrl(){
        $quickBooks = self::find(1);
        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $quickBooks->ClientID,
            'ClientSecret' => $quickBooks->ClientSecret,
            'RedirectURI' => $quickBooks->RedirectURI,
            'scope' => "com.intuit.quickbooks.accounting",
            'baseUrl' => 'Development',
        ]);

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $url = $OAuth2LoginHelper->getAuthorizationCodeURL();
        return $url;
    }

    public function getToken($code, $realmId){

        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $this->ClientID,
            'ClientSecret' => $this->ClientSecret,
            'RedirectURI' => $this->RedirectURI,
            'scope' => "com.intuit.quickbooks.accounting",
            'baseUrl' => 'Development',
        ]);

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

        return $accessToken;
    }
}
