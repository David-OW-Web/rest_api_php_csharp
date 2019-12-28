using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace REST_API
{
    public class Answers
    {
        [JsonProperty("answers")]
        public List<Answer> AnswerList { get; set; }
    }
    public class Answer
    {
        [JsonProperty("id")]
        public int id { get; set; }
        [JsonProperty("question_id")]
        public int question_id { get; set; }
        [JsonProperty("content")]
        public string content { get; set; }
        [JsonProperty("created_at")]
        public DateTime created_at { get; set; }
        [JsonProperty("title")]
        public string title { get; set; }
        [JsonProperty("username")]
        public string username { get; set; }
    }
}
