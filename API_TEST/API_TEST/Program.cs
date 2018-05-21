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
            Run().Wait();
            Console.ReadLine();
        }

        static async Task Run()
        {
            //var toevoegen = new Dictionary<string, string>()
            //{
            //    {"naam" , "{naam}"},
            //    {"prijs", "{prijs}" }
            //};

            var zoek = new string[] { "naam", "=", "{naam van broodje}" };

            FormUrlEncodedContent content = new FormUrlEncodedContent(new[]
            {
                new KeyValuePair<string, string>("action", "GET"),
                new KeyValuePair<string, string>("api_key", "8e6c7b47e63f664c7c66d84fcf0588202d37c3939e9fd65bf7ad6d9df52d4c188bd9c745"),
                new KeyValuePair<string, string>("zoekterm", JsonConvert.SerializeObject(zoek)),
            });

            var response = await client.PostAsync("http://api.sitewish.be/broodje", content);

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
