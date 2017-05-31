using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Data.Entity;
using System.Linq;
using System.Web;

namespace TicketingWebApp.Models
{
    public class Ticket
    {

        public int ID { get; set; }

        [Required]
        public int ShowID { get; set; }
        [Required]
        public String ShowTitle { get; set; }
        [Required]
        public int Row { get; set; }
        [Required]
        public int Number { get; set; }



    }




}