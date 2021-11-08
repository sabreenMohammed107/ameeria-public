﻿using Newtonsoft.Json.Linq;
using System;

namespace ApiTokenSigner.USBToken
{
    public class Serializer
    {
        public string Serialize(JObject request)
        {
            return SerializeToken(request);
        }

        private string SerializeToken(JToken request)
        {
            string serialized = "";
            if (request.Parent is null)
            {
                SerializeToken(request.First);
            }
            else
            {
                if (request.Type == JTokenType.Property)
                {
                    string name = ((JProperty)request).Name.ToUpper();
                    serialized += "\"" + name + "\"";
                    foreach (var property in request)
                    {
                        if (property.Type == JTokenType.Object)
                        {
                            serialized += SerializeToken(property);
                        }
                        if (property.Type == JTokenType.Boolean || property.Type == JTokenType.Integer || property.Type == JTokenType.Float || property.Type == JTokenType.String || property.Type == JTokenType.Date)
                        {
                            if (property.Type == JTokenType.Date)
                            {
                                serialized += "\"" + property.Value<DateTime>().ToString("yyyy-MM-ddTHH:mm:ssZ") + "\"";
                            }
                            else if (property.Type == JTokenType.Float)
                            {
                                serialized += "\"" + property.Value<double>().Round(5) + "\"";
                            }
                            else
                            {
                                serialized += "\"" + property.Value<string>() + "\"";
                            }
                        }
                        if (property.Type == JTokenType.Array)
                        {
                            foreach (var item in property.Children())
                            {
                                serialized += "\"" + ((JProperty)request).Name.ToUpper() + "\"";
                                serialized += SerializeToken(item);
                            }
                        }
                    }
                }
            }
            if (request.Type == JTokenType.Object)
            {
                foreach (var property in request.Children())
                {
                    if (property.Type == JTokenType.Object || property.Type == JTokenType.Property)
                    {
                        serialized += SerializeToken(property);
                    }
                }
            }
            return serialized;
        }
    }
}