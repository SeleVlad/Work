using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace TicketingWebApp.Models
{
    public class TicketRepository
    {

        public IQueryable<Ticket> getTickets(string searchString)
        {
            TicketAppDB db = DataBaseSingleton.Instance;
            var data = from t in db.Tickets select t;

            if (!String.IsNullOrEmpty(searchString))
            {
                data = data.Where(m => m.ShowID.ToString().Contains(searchString));
            }
            return data;
        }

        public int getCountTickets(int showID)
        {
            TicketAppDB db = DataBaseSingleton.Instance;
            var sql = "SELECT COUNT(*) FROM dbo.Tickets WHERE ShowID = " + showID;
            int currentTicketNumber = db.Database.SqlQuery<int>(sql).First();
            return currentTicketNumber;
        }


        public object checkSeat(int showID, int row, int number)
        {
            TicketAppDB db = DataBaseSingleton.Instance;

            var sql2 = "SELECT Number FROM dbo.Tickets WHERE ShowID = " + showID + " AND Row = " + row + " AND Number = " + number;

            int tester;
            try
            {
                tester = db.Database.SqlQuery<int>(sql2).First();
            }
            catch (Exception)
            {

                return null;
            }


            return tester;
        }
    }
}