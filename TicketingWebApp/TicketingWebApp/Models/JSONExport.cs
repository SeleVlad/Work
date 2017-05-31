using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class JSONExport : ExporterStrategy
    {
        public String export(string searchString)
        {


            TicketService tService = new TicketService();
            var data = tService.getTickets(searchString).ToList();

            string JSONresult;
            JSONresult = JsonConvert.SerializeObject(data, Formatting.Indented);
            return JSONresult;
        }
    }
}