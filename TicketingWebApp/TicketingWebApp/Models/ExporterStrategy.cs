using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public interface ExporterStrategy
    {
        String export(string searchString);
    }
}