<?php

// This example requires the Chilkat API to have been previously unlocked.
// See Global Unlock Sample for sample code.

$scmd = new COM("Chilkat_9_5_0.ScMinidriver");

// Reader names (smart card readers or USB tokens) can be discovered
// via List Readers or Find Smart Cards
$readerName = 'FS USB Token 0';
$success = $scmd->AcquireContext($readerName);
if ($success == 0) {
    print $scmd->LastErrorText . "\n";
    exit;
}

// If successful, the name of the currently inserted smart card is available:
print 'Card name: ' . $scmd->CardName . "\n";

// If desired, perform regular PIN authentication with the smartcard.
// For more details about smart card PIN authentication, see the Smart Card PIN Authentication Example
$retval = $scmd->PinAuthenticate('user','12345678');
if ($retval != 0) {
    print 'PIN Authentication failed.' . "\n";
}

// You can find a cerficate using any of the following certificate parts:
// "subjectDN" -- The full distinguished name of the cert.
// "subjectDN_withTags" -- Same as above, but in a format that includes the subject part tags, such as the "CN=" in "CN=something"
// "subjectCN" -- The common name part (CN) of the certificate's subject.
// "serial" -- The certificate serial number.
// "serial:issuerCN" -- The certificate serial number + the issuer's common name, delimited with a colon char.
// These are the same certificate parts that can be retrieved by listing certificates on the smart card (or USB token).
// See List Certificates on Smart Card Example
$certPart = 'subjectCN';
$partValue = 'Matt';

// If the certificate is found, it is loaded into the cert object.
// Note: We imported this certificate from a .p12/.pfx using code such as this Example to Import a .pfx/.p12 onto a Smart Card
$cert = new COM("Chilkat_9_5_0.Cert");
$success = $scmd->FindCert($certPart,$partValue,$cert);
if ($success == 0) {
    print 'Failed to find the certificate.' . "\n";
    $scmd->DeleteContext();
    exit;
}

print 'Successfully loaded the cert object from the smart card / USB token.' . "\n";

// Note: When successful, the cert object is internally linked to the ScMinidriver object's authenticated session.
// The cert object can now be used to sign or do other cryptographic operations that occur on the smart card / USB token.
// If your application calls PinDeauthenticate or DeleteContext, the cert will no longer be able to sign on the smart card
// because the smart card ScMinidriver session will no longer be authenticated or deleted.

// ------------------------------------------------------------------------------------------------------------

// Here we have to code to create the CADES-BES signature using Chilkat Crypt2..
$crypt = new COM("Chilkat_9_5_0.Crypt2");

// Tell the crypt class to use the cert on the ePass2003 token.
$success = $crypt->SetSigningCert($cert);
if ($success != 1) {
    print $crypt->LastErrorText . "\n";
    exit;
}

$cmsOptions = new COM("Chilkat_9_5_0.JsonObject");
// Setting "DigestData" causes OID 1.2.840.113549.1.7.5 (digestData) to be used.
$cmsOptions->UpdateBool('DigestData',1);
$cmsOptions->UpdateBool('OmitAlgorithmIdNull',1);

// Indicate that we are passing normal JSON and we want Chilkat do automatically
// do the ITIDA JSON canonicalization:
$cmsOptions->UpdateBool('CanonicalizeITIDA',1);

$crypt->CmsOptions = $cmsOptions->emit();

// The CadesEnabled property applies to all methods that create CMS/PKCS7 signatures. 
// To create a CAdES-BES signature, set this property equal to true. 
$crypt->CadesEnabled = 1;

$crypt->HashAlgorithm = 'sha256';

$jsonSigningAttrs = new COM("Chilkat_9_5_0.JsonObject");
$jsonSigningAttrs->UpdateInt('contentType',1);
$jsonSigningAttrs->UpdateInt('signingTime',1);
$jsonSigningAttrs->UpdateInt('messageDigest',1);
$jsonSigningAttrs->UpdateInt('signingCertificateV2',1);
$crypt->SigningAttributes = $jsonSigningAttrs->emit();

// By default, all the certs in the chain of authentication are included in the signature.
// If desired, we can choose to only include the signing certificate:
$crypt->IncludeCertChain = 0;

// Pass a JSON document such as the following.  Chilkat will do the ITIDA canonicalization.
// (It is the canonicalized JSON that gets signed.)

// {
//    "documents":[
//       {
//          "issuer":{
//             "address":{
//                "branchID":"0",
//                "country":"EG",
//                "regionCity":"Cairo",
//                "postalCode":"",
//                "buildingNumber":"0",
//                "street":"123rd Street",
//                "governate":"GOVERNATE"
//             },
//             "type":"B",
//             "id":"209999899",
//             "name":"Xyz SAE"
//          },
//          "receiver":{
//             "address":{
//                "country":"EG",
//                "regionCity":"CAIRO",
//                "postalCode":"11435",
//                "buildingNumber":"0",
//                "street":"Autostrad Road Abc",
//                "governate":"GOVERNATE"
//             },
//             "type":"B",
//             "id":"999999999",
//             "name":"XYZ EGYPT FOR TRADE"
//          },
//          "documentType":"I",
//          "documentTypeVersion":"1.0",
//          "dateTimeIssued":"2020-11-15T11:04:53Z",
//          "taxpayerActivityCode":"1073",
//          "internalID":"ZZZZ999",
//          "purchaseOrderReference":"2009199918",
//          "salesOrderReference":"",
//          "payment":{
//             "bankName":"",
//             "bankAddress":"",
//             "bankAccountNo":"",
//             "bankAccountIBAN":"",
//             "swiftCode":"",
//             "terms":""
//          },
//          "delivery":{
//             "approach":"",
//             "packaging":"",
//             "dateValidity":"",
//             "exportPort":"",
//             "countryOfOrigin":"EG",
//             "grossWeight":0,
//             "netWeight":0,
//             "terms":""
//          },
//          "invoiceLines":[
//             {
//                "description":"CDM Widget 48GX99X12BA",
//                "itemType":"GS1",
//                "itemCode":"7622213335056",
//                "unitType":"CS",
//                "quantity":1.00,
//                "unitValue":{
//                   "currencySold":"EGP",
//                   "amountEGP":588.67,
//                   "amountSold":0,
//                   "currencyExchangeRate":0
//                },
//                "salesTotal":588.67,
//                "total":603.97,
//                "valueDifference":0,
//                "totalTaxableFees":0,
//                "netTotal":529.8,
//                "itemsDiscount":0,
//                "discount":{
//                   "rate":10.00,
//                   "amount":58.87
//                },
//                "taxableItems":[
//                   {
//                      "taxType":"T1",
//                      "amount":74.17,
//                      "subType":"No sub",
//                      "rate":14.00
//                   }
//                ],
//                "internalCode":"9099994"
//             }
//          ],
//          "totalSales":588.67,
//          "totalSalesAmount":588.67,
//          "totalDiscountAmount":58.87,
//          "netAmount":529.80,
//          "taxTotals":[
//             {
//                "taxType":"T1",
//                "amount":74.17
//             }
//          ],
//          "extraDiscountAmount":0,
//          "totalItemsDiscountAmount":0,
//          "totalAmount":603.97,
//       }
//    ]
// }
// 

$jsonToSign = '{ ... }';

// Create the CAdES-BES signature.
$crypt->EncodingMode = 'base64';

// Make sure we sign the utf-8 byte representation of the JSON string
$crypt->Charset = 'utf-8';

$sigBase64 = $crypt->signStringENC($jsonToSign);
if ($crypt->LastMethodSuccess == 0) {
    print $crypt->LastErrorText . "\n";
    exit;
}

print 'Base64 signature:' . "\n";
print $sigBase64 . "\n";

// ------------------------------------------------------------------------------------------------------------
// Cleanup our ScMinidriver session...

// When finished with operations that required authentication, you may if you wish, deauthenticate the session.
$success = $scmd->PinDeauthenticate('user');
if ($success == 0) {
    print $scmd->LastErrorText . "\n";
}

// Delete the context when finished with the card.
$success = $scmd->DeleteContext();
if ($success == 0) {
    print $scmd->LastErrorText . "\n";
}



// ****************************************************


    public function getDocumentSignatures($document)
    {
        $string = $this->serializeDocument($document);
        $hashing = $this->SHA256Hashing($string);
    }


    private function serializeDocument($document)
    {
        $string = '';
        foreach ($document as $key => $value)
        {
            $string .= '"'.strtoupper($key).'"';
            
            if(is_array($value))
            {
                 $string .= $this->fetchJSONArray($key, $value);
            }
            else
            {
                $string .= '"'.(string)$value.'"';   
            }
        }

        return $string;
    }


    private function fetchJSONArray($mainkey, $array)
    {
        $string = '';
        foreach ($array as $key => $value)
        {
            if(is_array($value))
            {
                if(is_numeric($key))
                    $string .= '"'.strtoupper($mainkey).'"';
                else
                    $string .= '"'.strtoupper($key).'"';

                foreach ($value as $item_key => $item_value)
                {
                    if(is_array($item_value))
                    {
                        $string .= '"'.strtoupper($item_key).'"';
                        foreach ($item_value as $sub_item_key => $sub_item_value)
                        {
                            $string .= '"'.strtoupper($sub_item_key).'"';
                            $string .= '"'.(string)$sub_item_value.'"';
                        }
                    }
                    else
                    {
                        $string .= '"'.strtoupper($item_key).'"';
                        $string .= '"'.(string)$item_value.'"';
                    }
                }
            }
            else
            {
                $string .= '"'.strtoupper($key).'"';
                $string .= '"'.(string)$value.'"';
            }

        }

        return $string;
    }


    private function SHA256Hashing($string)
    {
        return hash( 'sha256', $string);
    }