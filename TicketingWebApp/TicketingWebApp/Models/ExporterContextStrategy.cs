using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class ExporterContextStrategy : ExporterFactoryInterface
    {
        private ExporterStrategy strategy;

        public ExporterContextStrategy(ExporterStrategy strat)
        {
            strategy = strat;
        }

        public string exportFile(string search)
        {
            String data = strategy.export(search);
            return data;
        }
    }
}