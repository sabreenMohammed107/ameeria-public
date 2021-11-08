<?php

namespace App\Traits;
use GuzzleHttp\Client as httpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Models\Setting;

trait EInvoicingTrait
{

    private $apiPreProdUrl = 'https://api.preprod.invoicing.eta.gov.eg/api/v1';
    private $apiIdentityUrl = 'https://id.preprod.eta.gov.eg';
    private $apiProUrl = 'https://api.invoicing.eta.gov.eg/api/v1';
    private $apiIdentityProUrl = 'https://id.eta.gov.eg';
    private $apiTokenSignerURL = 'https://localhost:44307/api/GetSigner/FullSignedDocument';
    
    private $sortedArray = [];

    /**
     * Document Submission API is the main API of the solution because it is used to submit one or more documents of different types to the solution. 
     * @param $inputs array
     * @return boolean
     */
    public function documentSubmissions($token, $documents)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiProUrl.'/documentsubmissions');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $documents);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ]);
        
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'status' => $code,
            'data' => $response
        ];
    }



    /**
     * Document cancellation is a way to correct submission errors that were noticed right away. 
     * @param $token String
     * @param $documentUUID String
     * @return boolean
     */
    public function cancelDocument($token, $documentUUID)
    {
        $inputs = [
            "status" => "cancelled",
            "reason" => "wrong data"
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiProUrl.'/documents/state/'.$documentUUID.'/state');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($inputs));
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ]);
        
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'status' => $code,
            'data' => $response
        ];
    }


    /**
     * Send the json object to return the full document with signature.
     * @param $data array.
     * @return $data object.
     */
    public function getFullDocumentSignatures($token, $documentJson)
    {
        // $client = new \GuzzleHttp\Client([
        //     'verify' => false
        // ]);
        // $response = $client->get($this->apiTokenSignerURL, [
        //     'form_params' => $documentJson
        // ]);

        $response = Http::withOptions(["verify"=>false])->send('GET', $this->apiTokenSignerURL, [
            'form_params' => $documentJson,
            'token' => $token
        ]);
        // dd($response->ok(), $response->status(), $response->json()['documents']);

        if($response->ok())
        {
            // $data = $response->json()['documents'][0];
            $data = $this->repreparingJsonValues($data);
        }

        return $data;
    }


    /**
     * Revalue the object values like int to double.
     * @param $data array.
     * @return $data object.
     */
    private function repreparingJsonValues($data)
    {
        foreach ($data['invoiceLines'] as $key => $value)
        {
            $data['invoiceLines'][$key]['quantity'] = (int) $value['quantity'];
            $data['invoiceLines'][$key]['salesTotal'] = (strpos($value['salesTotal'], ".") !== false) ? (float) $value['salesTotal'] : (int) $value['salesTotal'];
            $data['invoiceLines'][$key]['total'] = (strpos($value['total'], ".") !== false) ? (float) $value['total'] : (int) $value['total'];
            $data['invoiceLines'][$key]['valueDifference'] = (strpos($value['valueDifference'], ".") !== false) ? (float) $value['valueDifference'] : (int) $value['valueDifference'];
            $data['invoiceLines'][$key]['totalTaxableFees'] = (strpos($value['totalTaxableFees'], ".") !== false) ? (float) $value['totalTaxableFees'] : (int) $value['totalTaxableFees'];
            $data['invoiceLines'][$key]['netTotal'] = (strpos($value['netTotal'], ".") !== false) ? (float) $value['netTotal'] : (int) $value['netTotal'];
            $data['invoiceLines'][$key]['itemsDiscount'] = (strpos($value['itemsDiscount'], ".") !== false) ? (float) $value['itemsDiscount'] : (int) $value['itemsDiscount'];
            $data['invoiceLines'][$key]['unitValue']['amountEGP'] = (strpos($value['unitValue']['amountEGP'], ".") !== false) ? (float) $value['unitValue']['amountEGP'] : (int) $value['unitValue']['amountEGP'];
            $data['invoiceLines'][$key]['discount']['rate'] = (strpos($value['discount']['rate'], ".") !== false) ? (float) $value['discount']['rate'] : (int) $value['discount']['rate'];
            $data['invoiceLines'][$key]['discount']['amount'] = (strpos($value['discount']['amount'], ".") !== false) ? (float) $value['discount']['amount'] : (int) $value['discount']['amount'];

            foreach ($data['invoiceLines'][$key]['taxableItems'] as $skey => $value){
                $data['invoiceLines'][$key]['taxableItems'][$skey]['taxType'] = $value['taxType'];
                $data['invoiceLines'][$key]['taxableItems'][$skey]['amount'] = (strpos($value['amount'], ".") !== false) ? (float) $value['amount'] : (int) $value['amount'];
                $data['invoiceLines'][$key]['taxableItems'][$skey]['subType'] = $value['subType'];
                $data['invoiceLines'][$key]['taxableItems'][$skey]['rate'] = (int) $value['rate'];
            }
        }

        $data['totalSalesAmount'] = (strpos($data['totalSalesAmount'], ".") !== false) ? (float) $data['totalSalesAmount'] : (int) $data['totalSalesAmount'];
        $data['totalAmount'] = (strpos($data['totalAmount'], ".") !== false) ? (float) $data['totalAmount'] : (int) $data['totalAmount'];
        $data['totalDiscountAmount'] = (strpos($data['totalDiscountAmount'], ".") !== false) ? (float) $data['totalDiscountAmount'] : (int) $data['totalDiscountAmount'];
        $data['netAmount'] = (strpos($data['netAmount'], ".") !== false) ? (float) $data['netAmount'] : (int) $data['netAmount'];
        $data['extraDiscountAmount'] = (strpos($data['extraDiscountAmount'], ".") !== false) ? (float) $data['extraDiscountAmount'] : (int) $data['extraDiscountAmount'];
        $data['totalItemsDiscountAmount'] = (strpos($data['totalItemsDiscountAmount'], ".") !== false) ? (float) $data['totalItemsDiscountAmount'] : (int) $data['totalItemsDiscountAmount'];
        foreach ($data['taxTotals'] as $key => $value){
            $data['taxTotals'][$key]['amount'] = (strpos($value['amount'], ".") !== false) ? (float) $value['amount'] : (int) $value['amount'];
        }

        return $data;
    }


    /**
     * Send the payment request with the CURL Request.
     * @param $data array.
     * @return Transaction object.
     */
    private function getAccessToken()
    {
        // $fields = [
        //     'grant_type' => 'client_credentials',
        //     'client_id' => '5cbbf651-5f59-4638-b103-4a45f1b098aa',
        //     'client_secret' => 'ec250f00-d610-449d-8f4f-d6e0d533761c',
        //     'scope' => 'InvoicingAPI',
        // ];
        
        $cleint_id = Setting::where('key_name', 'client_id')->first();
        $client_secret = Setting::where('key_name', 'client_secret')->first();

        $fields = [
            'grant_type' => 'client_credentials',
            'client_id' => $cleint_id->value_name, //'ba116e83-b0cd-48ab-9f6c-92a7a9e66e3b',
            'client_secret' => $client_secret->value_name, //'9cf87ec5-3e8b-4d89-93bf-80893854638f',
            'scope' => 'InvoicingAPI',
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiIdentityProUrl.'/connect/token');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'status' => $code,
            'data' => $response
        ];
    }
}
