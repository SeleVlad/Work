using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace TicketingWebApp.Controllers
{
    public class HomeController : Controller
    {
        public ActionResult Index()
        {
            return View();
        }

        public ActionResult About()
        {
            ViewBag.Message = "Engine used for ticketing!";

            return View();
        }
        public ActionResult Contact()
        {
            ViewBag.Message = "Contact us at : +60789654123";

            return View();
        }
    }
}