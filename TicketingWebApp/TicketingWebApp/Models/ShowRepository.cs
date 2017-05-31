using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace TicketingWebApp.Models
{
    public class ShowRepository
    {

        public List<SelectListItem> getShows()
        {
            TicketAppDB db = DataBaseSingleton.Instance;
            var ShowList = new List<string>();
            var sql = from s in db.Shows orderby s.ID select s.Title;
            ShowList.AddRange(sql.Distinct());
            List<SelectListItem> list = new List<SelectListItem>();
            foreach (var show in ShowList)
                list.Add(new SelectListItem() { Value = show, Text = show });

            return list;
        }


        public List<SelectListItem> getShowsID()
        {
            TicketAppDB db = DataBaseSingleton.Instance;
            var ShowIDs = new List<int>();
            var sql2 = from s in db.Shows orderby s.ID select s.ID;
            ShowIDs.AddRange(sql2.Distinct());
            List<SelectListItem> list2 = new List<SelectListItem>();
            foreach (var show in ShowIDs)
                list2.Add(new SelectListItem() { Value = show.ToString(), Text = show.ToString() });

            return list2;
        }

        public int getTicketNumbers(int ShowID)
        {
            TicketAppDB db = DataBaseSingleton.Instance;
            int ticketNumber = db.Shows.Find(ShowID).TicketNumber;
            return ticketNumber;
        }
    }
}