<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 20.06.2018
 * Time: 15:36
 */

namespace App\Http\Controllers;

use App\Quickbooks;
use Illuminate\Http\Request;

class TestController extends Controller{

    public function test(){

        $quickBooks = Quickbooks::find('1');

        return view('test',['authUrl' => $quickBooks->getAuthUrl()]);
    }

    public function testConnection(){
        $quickBooks = Quickbooks::find('1');
        $result = $quickBooks->connect();

        if (is_array($result) && $result['error']){
            return view('test',['authUrl' => $quickBooks->getAuthUrl(), 'message' => $result['message']]);
        }
    }

    public function testRedirect(Request $request){
        $code = $request->get('code');
        $realmId = $request->get('realmId');

        $quickBooks = Quickbooks::find('1');

        $token = $quickBooks->getToken($code,$realmId);

        $quickBooks->code = $code;
        $quickBooks->realmId = $realmId;
        $quickBooks->accessToken = $token->getAccessToken();
        $quickBooks->refreshToken = $token->getRefreshToken();

        $quickBooks->save();

        echo "<script type='text/javascript'>window.close()</script>";


//        $dataService = DataService::Configure([
//            'auth_mode' => 'oauth2',
//            'ClientID' => $quickBooks->ClientID,
//            'ClientSecret' => $quickBooks->ClientSecret,
//            'RedirectURI' => $quickBooks->RedirectURI,
//            'scope' => "com.intuit.quickbooks.accounting",
//            'baseUrl' => 'Development',
//        ]);
//
//        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
////It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
////get the Code and realmID, use for the exchangeAuthorizationCodeForToken
//        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($quickBooks->code, $quickBooks->realmId);
//        $dataService->updateOAuth2Token($accessToken);
//        $dataService->throwExceptionOnError(true);
//        $CompanyInfo = $dataService->getCompanyInfo();
//        $nameOfCompany = $CompanyInfo->CompanyName;
//        echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
//        $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
//        echo $xmlBody . "\n";

    }
}