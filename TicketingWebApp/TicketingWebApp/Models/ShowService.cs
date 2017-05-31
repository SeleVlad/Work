using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace TicketingWebApp.Models
{
    public class ShowService
    {


        public List<SelectListItem> getShows()
        {
            ShowRepository showRep = new ShowRepository();
            return showRep.getShows();
        }

        public List<SelectListItem> getShowsID()
        {
            ShowRepository showRep = new ShowRepository();
            return showRep.getShowsID();
        }


        public int getTicketNumbers(int ShowID)
        {
            ShowRepository showRep = new ShowRepository();
            return showRep.getTicketNumbers(ShowID);
        }
    }
}