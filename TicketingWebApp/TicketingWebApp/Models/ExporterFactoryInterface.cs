using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public interface ExporterFactoryInterface
    {
        string exportFile(string search);
    }
}