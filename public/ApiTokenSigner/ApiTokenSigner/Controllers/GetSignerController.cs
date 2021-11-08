using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using ApiTokenSigner.USBToken;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Web.Http;

namespace ApiTokenSigner.Controllers
{
    //[Microsoft.AspNetCore.Mvc.Produces("application/json")]
    public class GetSignerController : ApiController
    {

        // GET api/GetSigner
        [HttpGet, AllowAnonymous]
        public HttpResponseMessage FullSignedDocument([FromBody] JObject json)
        {
            string error = string.Empty;
            try
            {
                if (json == null)
                {
                    error = "The file Json is not exist !!";
                    Console.WriteLine(error);
                    return Request.CreateResponse(HttpStatusCode.BadRequest, error);
                }
                else
                {
                    var replacejson = json.ToString().Replace(",\"signatures\":[]", "");
                    JObject request = JsonConvert.DeserializeObject<JObject>(replacejson, new JsonSerializerSettings()
                    {
                        FloatFormatHandling = FloatFormatHandling.String,
                        FloatParseHandling = FloatParseHandling.Decimal,
                        DateFormatHandling = DateFormatHandling.IsoDateFormat,
                        DateParseHandling = DateParseHandling.None
                    });

                    JObject FullFile = this.WriteFiles(request);
                    return Request.CreateResponse(HttpStatusCode.OK, FullFile);
                };
            }
            catch (Exception ex)
            {
                error = ex.Message;
                Console.WriteLine(error);
                return Request.CreateResponse(HttpStatusCode.BadRequest, error);
            }
        }

        public JObject WriteFiles(JObject request)
        {
            string cades = "";
            Serializer serializer = new Serializer();
            var SerializeJson = serializer.Serialize(request);
            byte[] byteData = Encoding.UTF8.GetBytes(SerializeJson);

            if (request["documentTypeVersion"].Value<string>() == "0.9")
                cades = "ANY";
            else
                cades = SignFromToken.Sign(byteData);

            JObject signaturesObject = new JObject(
                                   new JProperty("signatureType", "I"),
                                   new JProperty("value", cades));
            JArray signaturesArray = new JArray();
            signaturesArray.Add(signaturesObject);
            request.Add("signatures", signaturesArray);
            String fullSignedDocument = "{\"documents\":[" + request.ToString() + "]}";

            var fullSigned = JObject.Parse(fullSignedDocument);
            return fullSigned;
        }
    }
}
