<?php
// app/Webservices/N4loginws.php
namespace App\Webservices;
use SoapClient;

class N4LoginWebservice{

    private $url;

    public function __construct($host, $servicename)
    {
      $this->url = $host.$servicename;
    }

    public function processLoginInN4(Array $credentials){

        try{
            $client = new SoapClient($this->url);

            $params = array('loginUsr' => $credentials["username"], 'pswdUsr' => md5($credentials["password"]));
            $wsResponse = $client->processLoginInN4($params);
            $xmlResponse = simplexml_load_string($wsResponse->WSreturn);

            $userRoles = array();

            //$exito = (string)$xmlResponse->xpath('//Valido')[0];
            $exito = ($xmlResponse->Valido == 1) ? true : false;

            if($exito){
                //$userRoles = explode("|",implode("|",$xmlResponse->xpath('//Roles/Rol')));
                foreach ($xmlResponse->xpath('//Roles/Rol') as $node) {
                    array_push($userRoles,(string)$node);
                }

                $credentials["roles"] = $userRoles;

                return $credentials;
            }else{
                return null;
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
    }

}
