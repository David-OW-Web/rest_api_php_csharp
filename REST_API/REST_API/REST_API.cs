using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net;
using System.IO;
using Newtonsoft.Json;

namespace REST_API
{
    public class REST_API : IT_REST_API
    {
        private string api_url = "http://localhost/rest_api_php_csharp/API_Backend/";
        public Questions getQuestions()
        {
            var request = createWebRequest(api_url + "get/getQuestions.PHP");
            var response = request.GetResponse();
            var responseStream = response.GetResponseStream();

            if (responseStream != null)
            {
                var message = new StreamReader(responseStream).ReadToEnd();
                var questions = JsonConvert.DeserializeObject<Questions>(message);
                return questions;
            }
            return null;
        }
        // WebRequest
        private static WebRequest createWebRequest(string url)
        {
            var request = WebRequest.Create(url);
            var webProxy = WebRequest.DefaultWebProxy;

            webProxy.Credentials = CredentialCache.DefaultNetworkCredentials;
            request.Proxy = webProxy;

            return request;
        }
    }
}
