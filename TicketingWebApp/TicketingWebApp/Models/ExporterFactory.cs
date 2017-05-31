using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class ExporterFactory
    {
        public static ExporterFactoryInterface create(string type)
        {
            if (type.Equals("XML"))
            {
                return new ExporterContextStrategy(new XMLExport());
            }

            if (type.Equals("JSON"))
            {
                return new ExporterContextStrategy(new JSONExport());
            }

            return null;
        }
    }
}