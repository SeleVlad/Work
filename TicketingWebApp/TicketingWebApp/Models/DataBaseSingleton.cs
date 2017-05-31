using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class DataBaseSingleton
    {
        private static TicketAppDB instance;

        private DataBaseSingleton()
        {

        }

        public static TicketAppDB Instance
        {
            get
            {
                if (instance == null)
                {
                    instance = new TicketAppDB();
                }
                return instance;
            }
        }
    }
}