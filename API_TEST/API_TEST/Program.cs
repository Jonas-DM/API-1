using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace API_TEST
{
    class Program
    {
        private static readonly HttpClient client = new HttpClient();

        static void Main(string[] args)
        {
            //HttpWebRequest request = (HttpWebRequest)WebRequest.Create("http://localhost/api/broodje?Naam=");
            //request.Method = "POST";
            //request.ContentType = "apllication/json";
            //try
            //{
            //    var response = (HttpWebResponse)request.GetResponse();
            //    Console.WriteLine(response.Headers);
            //    StreamReader s = new StreamReader(response.GetResponseStream());
            //    var resp = s.ReadToEnd();

            //    Console.WriteLine(JsonConvert.DeserializeObject(resp));

            //    var test = JsonConvert.DeserializeObject<List<Broodje>>(resp);
            //    Console.WriteLine(test);
            //}
            //catch(WebException web)
            //{
            //    Console.WriteLine(web.Response.Headers);
            //}

            Run().Wait();

           // var data = new Dictionary<Object, Object>()
           //{
           //    {"api", "qsljdhgqs" },
           //    {"velden", new Dictionary<string, string>()
           //     {

           //     }
           //    }
           //};

            

            Console.ReadLine();
        }

        static async Task Run()
        {
            //var val = new Dictionary<Object, Object>()
            //{
            //    {"params", new Dictionary<Object, Object>()
            //        {
            //            {"api" ,"8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745" },
            //            {"velden", new Dictionary<string , string>()
            //                {
            //                    {"naam", "Pita" }
            //                }
            //            }
            //        }
            //    }
            //};

            //var val = new Dictionary<string, string>()
            //{
            //    {"naam", "qsdlgk"   }
            //};

            //Console.WriteLine(JsonConvert.SerializeObject(values, Formatting.Indented));

            //var json = JsonConvert.SerializeObject(val);
            ////Console.WriteLine(json);

            //var content = new StringContent(json, UnicodeEncoding.UTF8, "application/json");
            ////var content = new FormUrlEncodedContent(json);

            //var response = await client.PostAsync("http://localhost/api/broodje", content);
            //var resp = response.Content.ReadAsStringAsync().Result;


            //Console.WriteLine(resp);
            //var content = new StringContent(json, Encoding.UTF8);

            //var values = new Dictionary<string, string>()
            //{
            //    {"api_key" , "8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745" },
            //    {"veld", "lqksdfj" }
            //};

            //object values = new
            //{
            //    "api" = "8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745";
            //}

            //var content = new FormUrlEncodedContent(values);

            //var response = await client.PostAsync("http://localhost/api/broodje", content);
            //Console.WriteLine(content.ReadAsStringAsync());
            //var rep = response.Content.ReadAsStringAsync();
            //.WriteLine(JsonConvert.DeserializeObject<Dictionary<string, string>>(await response.Content.ReadAsStringAsync()));
            //var responseString = await response.Content.ReadAsStringAsync();
            //var resp = JsonConvert.DeserializeObject<Dictionary<string, string>>(responseString);
            // Console.WriteLine(rep.Result);
            //if (resp["status"] == "400")
            //{
            //    Console.Write("Oei");
            //}

            var test = new Dictionary<string, string>()
            {
                {"naam", "bakboux" }
            };

            FormUrlEncodedContent content = new FormUrlEncodedContent(new[]
            {
                new KeyValuePair<string, string>("action", "POST"),
                new KeyValuePair<string, string>("api_key", "8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745"),
                new KeyValuePair<string, string>("velden", JsonConvert.SerializeObject(test))
            });

            var response = await client.PostAsync("http://localhost/api/broodje", content);

            Console.WriteLine(response.Content.ReadAsStringAsync().Result);

        }
    }

    public class Broodje
    {
        private int _broodjesID;

        public int BroodjesID
        {
            get { return _broodjesID; }
            set { _broodjesID = value; }
        }

        private string _naam;

        public string Naam
        {
            get { return _naam; }
            set { _naam = value; }
        }

        private string _prijs;

        public string Prijs
        {
            get { return _prijs; }
            set { _prijs = value; }
        }

        private string _omschrijving;

        public string Omschrijving
        {
            get { return _omschrijving; }
            set { _omschrijving = value; }
        }

        private string _aanpassingen;

        public string Aanpassingen
        {
            get { return _aanpassingen; }
            set { _aanpassingen = value; }
        }


    }
}
