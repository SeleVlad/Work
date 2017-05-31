using System;
using System.Data;
using System.IO;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class XMLExport : ExporterStrategy
    {
        public String export(string searchString)
        {


            TicketService tService = new TicketService();
            var data = tService.getTickets(searchString).ToList();

            var serializer = new System.Xml.Serialization.XmlSerializer(data.GetType());
            StringWriter textWriter = new StringWriter();
            serializer.Serialize(textWriter, data);

            return textWriter.ToString();
        }
    }
}