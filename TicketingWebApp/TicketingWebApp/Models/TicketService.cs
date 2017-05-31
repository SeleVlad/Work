using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class TicketService
    {

        public IQueryable<Ticket> getTickets(string searchString)
        {
            TicketRepository ticketRep = new TicketRepository();
            return ticketRep.getTickets(searchString);
        }

        public int getCountTickets(int showID)
        {
            TicketRepository ticketRep = new TicketRepository();
            return ticketRep.getCountTickets(showID);
        }

        public bool checkSeat(int showID, int row, int number)
        {
            bool OK = false;

            TicketRepository ticketRep = new TicketRepository();
            var data = ticketRep.checkSeat(showID, row, number);

            if (data == null)
                OK = true;
            else
                OK = false;

            return OK;
        }
    }
}