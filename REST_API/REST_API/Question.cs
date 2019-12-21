using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace REST_API
{
    public class Questions
    {
        [JsonProperty("questions")]
        public List<Question> QuestionList { get; set; }
    }
    public class Question
    {
        [JsonProperty("id")]
        public int id { get; set; }
        [JsonProperty("title")]
        public string title { get; set; }
        [JsonProperty("content")]
        public string content { get; set; }
        [JsonProperty("created_at")]
        public DateTime created_at { get; set; }
        [JsonProperty("category")]
        public string category { get; set; }
        [JsonProperty("username")]
        public string username { get; set; }
        [JsonProperty("status")]
        public string status { get; set; }
    }
}
