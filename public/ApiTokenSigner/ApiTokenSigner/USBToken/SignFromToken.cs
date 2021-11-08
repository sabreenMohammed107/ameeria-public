using Net.Pkcs11Interop.Common;
using Net.Pkcs11Interop.HighLevelAPI;
using Org.BouncyCastle.Asn1;
using Org.BouncyCastle.Asn1.Ess;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Security.Cryptography.Pkcs;
using System.Security.Cryptography.X509Certificates;
using System.Text;


namespace ApiTokenSigner.USBToken
{
    public class SignFromToken
    {
        private static readonly string DllLibPath = "eps2003csp11.dll";
        private static readonly string TokenPin = "99175228"; 
        
        public static string Sign(byte[] data)
        {
            string error = string.Empty;
            Pkcs11InteropFactories factories = new Pkcs11InteropFactories();
            using (IPkcs11Library pkcs11Library = factories.Pkcs11LibraryFactory.LoadPkcs11Library(factories, DllLibPath, AppType.MultiThreaded))
            {
                ISlot slot = pkcs11Library.GetSlotList(SlotsType.WithTokenPresent).FirstOrDefault();

                if (slot is null)
                {
                    error = "No slots found";
                    Console.WriteLine(error);
                    return error;
                }

                ITokenInfo tokenInfo = slot.GetTokenInfo();
                ISlotInfo slotInfo = slot.GetSlotInfo();

                using (var session = slot.OpenSession(SessionType.ReadWrite))
                {
                    session.Login(CKU.CKU_USER, Encoding.UTF8.GetBytes(TokenPin));
                    var certificateSearchAttributes = new List<IObjectAttribute>()
                    {
                        session.Factories.ObjectAttributeFactory.Create(CKA.CKA_CLASS, CKO.CKO_CERTIFICATE),
                        session.Factories.ObjectAttributeFactory.Create(CKA.CKA_TOKEN, true),
                        session.Factories.ObjectAttributeFactory.Create(CKA.CKA_CERTIFICATE_TYPE, CKC.CKC_X_509)
                    };

                    IObjectHandle certificate = session.FindAllObjects(certificateSearchAttributes).FirstOrDefault();
                    if (certificate is null)
                    {
                        error = "Certificate not found";
                        Console.WriteLine(error);
                        return error;
                    }

                    X509Store store = new X509Store(StoreName.My, StoreLocation.CurrentUser);
                    store.Open(OpenFlags.MaxAllowed);
                   
                    X509Certificate2 cert = null;
                    foreach (var item in store.Certificates)
                    {
                        if (item.Issuer.ToUpper().Contains("MCDR") || item.Issuer.ToUpper().Contains("TRUST"))
                        {
                            cert = item;
                            break;
                        }
                    }
                    
                    if (cert is null)
                    {
                        error = "Certificate not found";
                        Console.WriteLine(error);
                        return error;
                    }
                   
                    store.Close();
                    ContentInfo content = new ContentInfo(new Oid("1.2.840.113549.1.7.5"), data);
                    SignedCms cms = new SignedCms(content, true);
                    SHA256 sha = SHA256.Create();
                    byte[] byteCert = sha.ComputeHash(cert.RawData);

                    EssCertIDv2 bouncyCertificate = new EssCertIDv2(new Org.BouncyCastle.Asn1.X509.AlgorithmIdentifier(new DerObjectIdentifier("1.2.840.113549.1.9.16.2.47")), byteCert); //اجرب  ؟؟
                    SigningCertificateV2 signerCertificateV2 = new SigningCertificateV2(new EssCertIDv2[] { bouncyCertificate });
                    CmsSigner signer = new CmsSigner(cert);

                    signer.DigestAlgorithm = new Oid("2.16.840.1.101.3.4.2.1");

                    signer.SignedAttributes.Add(new Pkcs9SigningTime(DateTime.UtcNow));
                    signer.SignedAttributes.Add(new AsnEncodedData(new Oid("1.2.840.113549.1.9.16.2.47"), signerCertificateV2.GetEncoded()));
                    signer.IncludeOption = X509IncludeOption.EndCertOnly;// Use if Error: A certificate chain could not be built to a trusted root authority.

                    cms.ComputeSignature(signer);

                    var output = cms.Encode();
                    return Convert.ToBase64String(output);
                }
            }
        }
    }
}
