using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Threading;
using System.Web;
using System.Web.Mvc;
using System.Web.UI;
using TicketingWebApp.Models;

namespace TicketingWebApp.Controllers
{
    public class TicketController : Controller
    {
        private TicketAppDB db = new TicketAppDB();
        [Authorize]
        // GET: Ticket
        public ActionResult Index(string searchString, string submitButton)
        {
            var shows = from s in db.Tickets select s;



            if (submitButton != null)
            {
                if (submitButton.Equals("ExportJSON"))
                {
                    ExportJSON(searchString);
                }
                if (submitButton.Equals("ExportXML"))
                {
                    ExportXML(searchString);
                }
                else
                {
                    return Search(searchString);
                }
            }

            return View(shows.ToList());

        }

        private ActionResult Search(string searchString)
        {
            var shows = from s in db.Tickets select s;

            if (!String.IsNullOrEmpty(searchString))
            {
                shows = shows.Where(m => m.ShowID.ToString().Contains(searchString));
            }
            return View(shows.ToList());

        }

        private void ExportJSON(string searchString)
        {


            ExporterFactoryInterface exService = ExporterService.create("JSON");
            String data = exService.exportFile(searchString);


            System.Web.HttpContext.Current.Response.ClearContent();
            System.Web.HttpContext.Current.Response.Buffer = true;
            System.Web.HttpContext.Current.Response.AddHeader("content-disposition", "attachment;filename = exportJSON.json");
            System.Web.HttpContext.Current.Response.ContentType = "application/json; charset=utf-8";
            System.Web.HttpContext.Current.Response.Write(data);
            System.Web.HttpContext.Current.Response.Flush();
            System.Web.HttpContext.Current.Response.End();



        }

        private void ExportXML(string searchString)
        {

            ExporterFactoryInterface exService = ExporterService.create("XML");
            String data = exService.exportFile(searchString);


            System.Web.HttpContext.Current.Response.ClearContent();
            System.Web.HttpContext.Current.Response.Buffer = true;
            System.Web.HttpContext.Current.Response.AddHeader("content-disposition", "attachment;filename = exportXML.xml");
            System.Web.HttpContext.Current.Response.ContentType = "application/xml; charset=utf-8";
            System.Web.HttpContext.Current.Response.Write(data);
            System.Web.HttpContext.Current.Response.Flush();
            System.Web.HttpContext.Current.Response.End();

        }


        // GET: Ticket/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Ticket ticket = db.Tickets.Find(id);
            if (ticket == null)
            {
                return HttpNotFound();
            }
            return View(ticket);
        }

        // GET: Ticket/Create
        public ActionResult Create()
        {
            ShowService showService = new ShowService();
            ViewBag.ShowsReady = showService.getShows();
            ViewBag.ShowsIDs = showService.getShowsID();

            return View();
        }

        // POST: Ticket/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "ID,ShowID,ShowTitle,Row,Number")] Ticket ticket)
        {

            ShowService showService = new ShowService();
            var ticketNumber = showService.getTicketNumbers(ticket.ShowID);

            TicketService ticketService = new TicketService();
            var currentTicketNumber = ticketService.getCountTickets(ticket.ShowID);


            if (ticketNumber > currentTicketNumber)
            {
                bool OK = ticketService.checkSeat(ticket.ShowID, ticket.Row, ticket.Number);
                if (OK)
                {
                    if (ModelState.IsValid)
                    {
                        db.Tickets.Add(ticket);
                        db.SaveChanges();
                        return RedirectToAction("Index");
                    }
                }
                else
                {

                    TempData["Message"] = "Seat taken!";
                }
            }
            else
            {

                TempData["Message2"] = "Tickets Sold Out!";


            }
            return RedirectToAction("Create");
        }

        // GET: Ticket/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Ticket ticket = db.Tickets.Find(id);
            if (ticket == null)
            {
                return HttpNotFound();
            }
            return View(ticket);
        }

        // POST: Ticket/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "ID,ShowID,ShowTitle,Row,Number")] Ticket ticket)
        {
            if (ModelState.IsValid)
            {
                db.Entry(ticket).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(ticket);
        }

        // GET: Ticket/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Ticket ticket = db.Tickets.Find(id);
            if (ticket == null)
            {
                return HttpNotFound();
            }
            return View(ticket);
        }

        // POST: Ticket/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            Ticket ticket = db.Tickets.Find(id);
            db.Tickets.Remove(ticket);
            db.SaveChanges();
            return RedirectToAction("Index");
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}
