using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Data.Entity;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class Show
    {
        public int ID { get; set; }
        public string Title { get; set; }
        public string Genre { get; set; }
        [Required]
        public string Regie { get; set; }
        [Required]
        public string Distribution { get; set; }
        [Required]
        public DateTime ReleaseDate { get; set; }
        [Required]
        public int TicketNumber { get; set; }
    }

    public class TicketAppDB : DbContext
    {
        public DbSet<Show> Shows { get; set; }
        public DbSet<Ticket> Tickets { get; set; }

        public System.Data.Entity.DbSet<TicketingWebApp.Models.RoleViewModel> RoleViewModels { get; set; }
    }
}