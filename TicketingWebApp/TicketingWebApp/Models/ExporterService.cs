using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class ExporterService
    {
        public static ExporterFactoryInterface create(string type)
        {
            return ExporterFactory.create(type);
        }
    }
}